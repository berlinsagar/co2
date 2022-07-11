<?php

namespace Services;

use PDO;
use Utilities\Utility;

class RecordFinderService
{

    protected $connection;
    protected $sensorID;

    public function __construct(DBService $dBService)
    {
        $this->connection = $dBService->getConnection();
    }

    /**
     * @param string $serviceName
     * @param string $sensorID
     * @return array[]
     */
    public function findIdMapByService(string $serviceName, string $sensorID): array
    {
        $this->sensorID = $sensorID;

        if ($this->checkSensorExists() === false) {
            return ['message' => "Sensor UUID:{$this->sensorID} is not available."];
        }
        switch ($serviceName) {
            case 'status':
                return $this->getSensorStatus();
            case 'alerts':
                return $this->getSensorAlerts();
            case 'metrics':
                return $this->getSensorMetrics();
            default:
                return ['message' => "No {$serviceName} service exists"];
        }
    }

    /**
     * @return array
     */
    public function getSensorStatus(): array
    {
        try {
            return $this->getSensorStatusCalculation();
        } catch (\Exception $ex) {
            return ['message' => $ex->getMessage()];
        }
    }

    /**
     * @return array
     */
    public function getSensorAlerts(): array
    {
        try {
            $sql = <<<SQL
SELECT
    start_time,
    end_time,
    co2_levels
FROM
    alerts 
WHERE 
    sensor_id = :sensor_id
ORDER BY
    date_entered ASC
SQL;
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array('sensor_id' => $this->sensorID));
            $allRecords = array();
            while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $row = array();
                $row['startTime'] = Utility::convertDBDateToIsoFormat($result['start_time']);
                $row['endTime'] = Utility::convertDBDateToIsoFormat($result['end_time']);
                $co2_levels = explode(",", $result['co2_levels']);
                $count = 1;
                foreach ($co2_levels as $co2_level) {
                    $row['measurements' . $count] = $co2_level;
                    $count++;
                }
                $allRecords[] = $row;
            }
            if (empty($allRecords)) {
                return ['message' => "No alerts found for the sensor UUID:{$this->sensorID}"];
            }

            return $allRecords;
        } catch (\Exception $ex) {
            return ['message' => $ex->getMessage()];
        }
    }

    /**
     * @return array|string[]
     */
    public function getSensorMetrics(): array
    {
        try {
            $sql = <<<SQL
SELECT
    MAX(co2) maxLast30Days,
    Round(AVG(co2)) avgLast30Days
FROM
    measurements 
WHERE 
    sensor_id = :sensor_id
AND
    DATE(time) >= (DATE(NOW()) - INTERVAL 30 DAY)
;
SQL;
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(array('sensor_id' => $this->sensorID));
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (empty($result['maxLast30Days']) && empty($result['avgLast30Days'])) {
                return ["message" => "No Reading found with sensor ID:{$this->sensorID} for last 30 days."];
            }
            return $result;
        } catch (\Exception $ex) {
            return ['message' => $ex->getMessage()];
        }
    }

    /**
     * @return bool
     */
    public function checkSensorExists(): bool
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


    public function getSensorStatusCalculation(): array
    {
        $first_status = "";
        $calls = 0;
        $oldSensorData = [];
        cal:
        $calls++;
        $sensorData = $this->fetchSensorRecords($calls);

        //First Time Empty Data
        if (empty($sensorData) && $calls === 1) {
            return ["error" => "Status not available for UUID: $this->sensorID"];
        }

        if (!empty($sensorData) && $calls === 1) {
            $first_status = "OK";
            if ($sensorData[0]['co2'] > 2000) {
                $first_status = "WARN";
            }
        }

        if (!empty($sensorData) && $calls === 1 && count($sensorData) < 3) {
            if ($sensorData[0]['co2'] > 2000) {
                return ["status" => "WARN"];
            }
            return ["status" => "OK"];
        }

        //For next calls Empty Data
        if (empty($sensorData) && $calls > 1) {
            if (!empty($first_status)) {
                return ["status" => $first_status];
            } else {
                return ["status" => "OK"];
            }
        }

        $sortResults = $this->sensorDataSort($oldSensorData, $sensorData);

        if (in_array($sortResults['notExceededLevel'], array(1, 2))) {
            if ($calls <= 5) {
                $oldSensorData = $sortResults['oldSensorData'];
                goto cal;
            }

            return ["status" => "WARN"];
        } else if ($sortResults['exceededLevel'] === 3) {
            return ["status" => "ALERT"];
        } elseif ($sortResults['notExceededLevel'] === 3) {
            if (!empty($first_status)) {
                return ["status" => $first_status];
            } else {
                return ["status" => "OK"];
            }
        } else {
            return ["error" => "Status not available for UUID: $this->sensorID"];
        }
    }

    /**
     * @param $calls
     * @return array
     */
    public function fetchSensorRecords($calls): array
    {
        try {
            $sql = <<<SQL
SELECT 
    co2
FROM
    measurements 
WHERE 
    sensor_id = :sensor_id
ORDER BY
    time DESC
LIMIT :limit , :offset
SQL;
            $limit = ($calls === 1) ? 0 : ($calls - 1) * 3;

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':offset', 3, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':sensor_id', $this->sensorID);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $ex) {
            return ['message' => $ex->getMessage()];
        }
    }

    public function sensorDataSort($oldData, $newData = []): array
    {

        $sortResults = [];
        $sortResults['oldSensorData'] = $newData;
        if (empty($oldData)) {
            $oldData = $newData;
            $sortResults['exceededLevel'] = 0;
            $sortResults['notExceededLevel'] = 0;
            foreach ($oldData as $data) {
                if ($data['co2'] > 2000) {
                    $sortResults['exceededLevel'] += 1;
                } else {
                    $sortResults['notExceededLevel'] += 1;
                }
            }
            return $sortResults;
        }

        $sensorData = array_merge($oldData, $newData);
        $lastExceededLevel = 0;
        $lastNotExceededLevel = 0;
        for ($i = 1; $i <= count($sensorData); $i++) {
            $sortResults['exceededLevel'] = 0;
            $sortResults['notExceededLevel'] = 0;

            //If last set not have 3 elements
            if (!isset($sensorData[$i + 1]['co2']) || !isset($sensorData[$i + 2]['co2'])) {
                $sortResults['exceededLevel'] = $lastExceededLevel;
                $sortResults['notExceededLevel'] = $lastNotExceededLevel;
                return $sortResults;
            }

            //Preparing at least 3 elements check
            //first Element
            if ($sensorData[$i]['co2'] > 2000) {
                $sortResults['exceededLevel'] += 1;
            } else {
                $sortResults['notExceededLevel'] += 1;
            }

            //second Element
            if ($sensorData[$i + 1]['co2'] > 2000) {
                $sortResults['exceededLevel'] += 1;
            } else {
                $sortResults['notExceededLevel'] += 1;
            }

            //Third Element
            if ($sensorData[$i + 2]['co2'] > 2000) {
                $sortResults['exceededLevel'] += 1;
            } else {
                $sortResults['notExceededLevel'] += 1;
            }
            $lastExceededLevel = $sortResults['exceededLevel'];
            $lastNotExceededLevel = $sortResults['notExceededLevel'];
            if ($sortResults['exceededLevel'] === 3 || $sortResults['notExceededLevel'] === 3) {
                return $sortResults;
            }
        }
        return $sortResults;
    }
}
