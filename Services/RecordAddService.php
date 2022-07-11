<?php

namespace Services;

use PDO;
use Services\Request;
use Utilities\Utility;


class RecordAddService
{

    protected $connection;
    protected $sensorID;
    protected $data;
    protected $warnPPM = 2000;

    protected $requiredParameters = [
        'co2',
        'time',
    ];

    public function __construct(DBService $dBService)
    {
        $this->connection = $dBService->getConnection();
    }


    public function execute(Request $request): array
    {

        $this->sensorID = $request->getUrlParam(0);
        $serviceName = $request->getUrlParam(1);
        $this->data = $request->getBody();
        if (empty($this->sensorID) || empty($serviceName) || empty($this->data)) {
            return [];
        }

        if ($this->getSensor() === false) {
            return ['message' => "Sensor UUID:{$this->sensorID} is not available."];
        }
        switch ($serviceName) {
            case 'measurements':
                if (!Utility::checkRequiredParameters($this->requiredParameters, $this->data) ||
                    !Utility::validationMeasurement($this->data)) {
                    return ["error" => "badRequest", "message" => "Missing required parameters."];
                }
                return $this->collectMeasurement();

            default:
                return ["error" => "badRequest", "message" => "Missing required parameters."];
        }
    }

    /**
     * @return array
     */
    public function collectMeasurement(): array
    {
        try {
            $sql = <<<SQL
INSERT INTO 
    measurements(sensor_measurement_id, sensor_id, co2,time) 
VALUES 
    (:sensor_measurement_id,:sensor_id,:co2,:time)
SQL;
            $time = Utility::convertIsoDateToDBFormat($this->data['time']);
            $clauseParams = ["sensor_measurement_id" => Utility::gen_uuid(), "sensor_id" => $this->sensorID,
                "co2" => $this->data['co2'], "time" => $time];

            $stmt = $this->connection->prepare($sql);
            $this->connection->beginTransaction();
            $stmt->execute($clauseParams);
            $this->connection->commit();

            //try to capture alert
            if ($this->data['co2'] > $this->warnPPM) {
                $this->captureAlert();
            }
            return ['message' => "Collected sensor measurements successfully."];
        } catch (\Exception $ex) {
            $this->connection->rollback();
            //If we are exposing api to public then we can hide exception
            return ['message' => $ex->getMessage()];
        }
    }

    /**
     * @return bool
     */
    public function captureAlert(): bool
    {

        try {
            $lastMeasurements = $this->fetchMeasurements();

            if (count($lastMeasurements) !== 3) {
                return false;
            }
            $dataForAlert = [];
            foreach ($lastMeasurements as $lastMeasurement) {
                if ($lastMeasurement['co2'] > $this->warnPPM &&
                    (int)$lastMeasurement['alert_captured'] == 0) {
                    $dataForAlert['co2_levels'][] = $lastMeasurement['co2'];
                    $dataForAlert['time'][] = $lastMeasurement['time'];
                    $dataForAlert['measurements_ids'][] = $lastMeasurement['sensor_measurement_id'];
                }
            }
            if (count($dataForAlert['co2_levels']) === 3) {
                //Insert alert
                if ($this->insertAlert($dataForAlert)) {
                    //Update measurement table after alert capture
                    $this->updateMeasurements($dataForAlert['measurements_ids']);
                }
            }
            return true;

        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }


    public function fetchMeasurements()
    {
        try {
            $sql = <<<SQL
SELECT 
    sensor_measurement_id,
    co2,
    alert_captured,
    time
FROM
    measurements 
WHERE 
    sensor_id = :sensor_id
ORDER BY
    time DESC
LIMIT 0, 3
SQL;
            $stmt = $this->connection->prepare($sql);
            $clauseParams = ["sensor_id" => $this->sensorID];
            $stmt->execute($clauseParams);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $ex) {
            return ['message' => $ex->getMessage()];
        }
    }

    /**
     * @return bool
     */
    public function getSensor(): bool
    {
        try {
            $sql = <<<SQL
SELECT
   * 
FROM
   sensors 
WHERE
   sensor_id = :sensor_id
SQL;
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array('sensor_id' => $this->sensorID));
            return (bool)$stmt->rowCount();
        } catch (\Exception $ex) {
            return false;
        }
    }


    /**
     * @param $dataForAlert
     * @return bool
     */
    public function insertAlert($dataForAlert): bool
    {
        try {
            $sql = <<<SQL
INSERT INTO 
    alerts(alert_id, sensor_id,co2_levels,start_time,end_time) 
VALUES
(:alert_id,:sensor_id,:co2_levels,:start_time,:end_time)
SQL;
            $co2_levels = implode(",", $dataForAlert['co2_levels']);
            sort($dataForAlert['time']);

            $clauseParams = ["alert_id" => Utility::gen_uuid(), "sensor_id" => $this->sensorID,
                "co2_levels" => $co2_levels, "start_time" => $dataForAlert['time'][0], "end_time" => $dataForAlert['time'][2]];
            $stmt = $this->connection->prepare($sql);
            $this->connection->beginTransaction();
            $stmt->execute($clauseParams);
            $this->connection->commit();
            return true;
        } catch (\Exception $ex) {
            $this->connection->rollback();
            return false;
        }
    }

    /**
     * @param $ids
     * @return bool
     */
    public function updateMeasurements($ids): bool
    {
        try {
            $sql = <<<SQL
UPDATE 
    measurements
    SET alert_captured = 1 
WHERE
    sensor_measurement_id IN (:sensor_measurement_ids)
SQL;
            $sensor_measurement_ids = $this->connection->quote(implode(",", $ids));
            $clauseParams = ["sensor_measurement_id" => $sensor_measurement_ids, 1];
            $stmt = $this->connection->prepare($sql);
            $this->connection->beginTransaction();
            $stmt->execute($clauseParams);
            $this->connection->commit();
            return true;
        } catch (\Exception $ex) {
            $this->connection->rollback();
            return false;
        }
    }
}

