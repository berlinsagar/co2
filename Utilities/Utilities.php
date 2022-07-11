<?php

namespace Utilities;

class Utility
{
    /**
     * @param $date
     * @return string
     */
    public static function convertDBDateToIsoFormat($date): string
    {
        return empty($date) ? "" : date('c', strtotime($date));;
    }

    /**
     * @param $date
     * @return string
     */
    public static function convertIsoDateToDBFormat($date): string
    {
        return empty($date) ? "" : date('Y-m-d h:m:s', strtotime(substr($date, 0, 10)));;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function clean(array $data = []): array
    {
        foreach ($data as $fieldName => $fieldValue) {
            $data[$fieldName] = htmlspecialchars($fieldValue);
            $data[$fieldName] = stripslashes($data[$fieldName]);
            $data[$fieldName] = trim($data[$fieldName]);
        }
        return $data;
    }

    /**
     * @param $requiredParameters
     * @param $data
     * @return bool
     */
    public static function checkRequiredParameters($requiredParameters, $data): bool
    {
        $checkFlag = true;
        if (empty($requiredParameters) && empty($requestParameters)) {
            return false;
        }
        $requestParameters = array_keys($data);
        if (count($requiredParameters) === count($requestParameters)) {
            foreach ($requiredParameters as $requiredParameter) {
                if (!in_array($requiredParameter, $requestParameters)) {
                    return false;
                }
                if (empty($data[$requiredParameter])) {
                    return false;
                }
            }
        } else {
            $checkFlag = false;
        }
        return $checkFlag;
    }

    /**
     * @return string
     */
    public static function gen_uuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            mt_rand(0, 0x0fff) | 0x4000,

            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * @param $data
     * @return bool
     */
    public static function validationMeasurement($data): bool
    {
        if (filter_var($data['co2'], FILTER_VALIDATE_INT, array("options" => array("min_range" => 300, "max_range" => 10000))) === false) {
            return false;
        }
        return true;
    }
}
