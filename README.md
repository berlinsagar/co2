## Instructions

- Unzip the project and from the terminal.
- Import the test data provided along with the project.
- Update the config.php file your correct database parameters.
- "cd"  to the directory. Then execute the following command.

```sh
php -S localhost:9999 router.php
```

You should now be able to access the below endpoints

# Co2 Api Application

**This project is made using PHP, Restful Api , mysql and phpunit test.**

## API Testing

## Collect sensor measurements

**Request URL:**
```
http://localhost:9999/api/v1/sensors/2c1a3ade-0151-11ed-b939-0242ac120002/measurements
```
**Request Response**

```
{
  "co2" :"5001",
  "time" : "2022-08-12T18:59:47+00:01"
}
```
**Response:**
```
{
	"message": "Collected sensor measurements successfully."
}
```

## Sensor metrics

**Request URL:**
```
http://localhost:9999/api/v1/sensors/2c1a3ade-0151-11ed-b939-0242ac120002/metrics
```
**Response:**

```
{
	"maxLast30Days": "5001",
	"avgLast30Days": "2878"
}
```

## Sensor status
**Request URL:**
```
http://localhost:9999/api/v1/sensors/2c1a3ade-0151-11ed-b939-0242ac120002/status
```
**Response:**

//Possible status OK,WARN,ALERT
```
{
	"status": "ALERT"
}
```
## Sensor alerts
**Request URL:**
```
http://localhost:9999/api/v1/sensors/2c1a3ade-0151-11ed-b939-0242ac120002/alerts
```
**Response:**

```
[
	{
		"startTime": "2022-08-12T12:08:00+02:00",
		"endTime": "2022-08-12T12:08:00+02:00",
		"measurements1": "5001",
		"measurements2": "3000",
		"measurements3": "5001"
	}
]
```


## PHP Unit Testing
Installed but didn't got have time to write cases.

## Database Schema / Design
```
--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts` (
`alert_id` char(36) NOT NULL,
`sensor_id` char(36) NOT NULL,
`co2_levels` varchar(50) NOT NULL,
`date_entered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`start_time` datetime DEFAULT NULL,
`end_time` datetime DEFAULT NULL,
PRIMARY KEY (`alert_id`),
KEY `sensor_id_index` (`sensor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
```
```
--
-- Table structure for table `measurements`
--

DROP TABLE IF EXISTS `measurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `measurements` (
`sensor_measurement_id` char(36) NOT NULL,
`sensor_id` char(36) NOT NULL,
`co2` smallint(2) NOT NULL,
`time` datetime DEFAULT NULL,
`alert_captured` tinyint(1) DEFAULT '0',
PRIMARY KEY (`sensor_measurement_id`),
KEY `sensor_id_index` (`sensor_id`),
KEY `co2_level_index` (`co2`),
KEY `time_index` (`time`),
KEY `alert_captured` (`alert_captured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
```
```
--
-- Table structure for table `sensors`
--

DROP TABLE IF EXISTS `sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sensors` (
`sensor_id` char(36) NOT NULL,
`mac_address` varchar(100) NOT NULL,
`is_active` tinyint(1) NOT NULL DEFAULT '0',
`date_entered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`sensor_id`),
KEY `sensor_id_index` (`sensor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
