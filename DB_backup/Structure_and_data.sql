-- MySQL dump 10.13  Distrib 8.0.29, for macos12 (x86_64)
--
-- Host: localhost    Database: co2
-- ------------------------------------------------------
-- Server version	5.7.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES ('0175fa20-782c-4e91-899d-680a118e6ea9','2c1a3ade-0151-11ed-b939-0242ac120002','5001,3000,5001','2022-07-11 22:41:57','2022-08-12 12:08:00','2022-08-12 12:08:00');
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `measurements`
--

LOCK TABLES `measurements` WRITE;
/*!40000 ALTER TABLE `measurements` DISABLE KEYS */;
INSERT INTO `measurements` VALUES ('04a6baf1-908d-444d-b948-6a36549d3b69','2c1a3ade-0151-11ed-b939-0242ac120002',3702,'2022-08-06 12:08:45',1),('055d1947-7d98-4f6f-8868-86654a53fae9','2c1a3ade-0151-11ed-b939-0242ac120002',5001,'2022-08-12 12:08:00',1),('0af1388d-e469-422e-b0db-fc86676e95f3','2c1a3ade-0151-11ed-b939-0242ac120002',2364,'2022-08-11 01:08:45',1),('0d82b746-f6cc-4f35-aaf8-74920b328933','2c1a424a-0151-11ed-b939-0242ac120002',2311,'2022-08-11 01:08:45',1),('0fdf5e31-7d88-4538-bed4-d194c40e3e7e','2c1a424a-0151-11ed-b939-0242ac120002',3241,'2022-08-11 12:08:45',1),('111a5464-ddb5-4d9f-9eb4-30c351c114af','2c1a3d54-0151-11ed-b939-0242ac120002',2584,'2022-08-11 12:08:45',1),('1266b2f9-4494-4c54-801f-19cb2f32f531','2c1a3ade-0151-11ed-b939-0242ac120002',523,'2022-08-11 01:08:45',0),('1298e88f-3a17-49d9-ad48-504c8a5bc837','2c1a3ade-0151-11ed-b939-0242ac120002',5001,'2022-08-12 12:08:00',1),('1946a91d-9060-4a08-a974-31ad08905bd5','2c1a3d54-0151-11ed-b939-0242ac120002',907,'2022-08-11 12:08:45',0),('1e5fad14-ab76-4bf7-8451-7f10591fcdd5','2c1a3d54-0151-11ed-b939-0242ac120002',911,'2022-08-11 01:08:45',0),('1ee0d966-c29d-452a-9993-62ef144a2b10','2c1a3ade-0151-11ed-b939-0242ac120002',2998,'2022-08-11 02:08:45',1),('1f4aba11-015f-4b95-9874-026c02214f13','2c1a424a-0151-11ed-b939-0242ac120002',2840,'2022-08-11 12:08:45',1),('1f6cf26f-04b6-4698-a2ce-4dd574e4d653','2c1a3d54-0151-11ed-b939-0242ac120002',4412,'2022-08-11 01:08:45',1),('21af0feb-d190-4e81-919b-76f5712f5a62','2c1a3ade-0151-11ed-b939-0242ac120002',1793,'2022-08-11 01:08:45',0),('22794f48-0889-4f74-b721-91fd84ca91fa','2c1a3ade-0151-11ed-b939-0242ac120002',550,'2022-08-11 12:08:45',0),('2302dea2-a721-4a50-9513-b7069e22f393','2c1a424a-0151-11ed-b939-0242ac120002',4067,'2022-08-11 12:08:45',1),('285236fe-6735-490f-9fa5-a84f246e1121','2c1a424a-0151-11ed-b939-0242ac120002',912,'2022-08-11 01:08:45',0),('2f793a1c-4029-4dec-b1c4-eccffbc232aa','2c1a3d54-0151-11ed-b939-0242ac120002',931,'2022-08-11 01:08:45',0),('3435683c-870a-4000-9a05-f140b8a9e266','2c1a3ade-0151-11ed-b939-0242ac120002',3069,'2022-08-11 12:08:45',1),('34ea08eb-0051-4d80-8374-abf8500a8d02','2c1a424a-0151-11ed-b939-0242ac120002',4629,'2022-08-11 12:08:45',1),('3539916c-e7d8-4f22-a533-c0200661efb3','2c1a3ade-0151-11ed-b939-0242ac120002',3231,'2022-08-11 01:08:45',1),('398e6915-9ef5-4847-9dbc-2679a395d0b3','2c1a3ade-0151-11ed-b939-0242ac120002',4254,'2022-08-11 01:08:45',1),('3bc55a23-a334-43cf-a8a6-d2d0d11f8b24','2c1a424a-0151-11ed-b939-0242ac120002',1224,'2022-08-11 01:08:45',0),('3e082f3d-2cca-4114-8bbc-908866b88056','2c1a424a-0151-11ed-b939-0242ac120002',3914,'2022-08-11 01:08:45',1),('3eb07e1f-e467-4d28-a212-dde8de5e4be6','2c1a3d54-0151-11ed-b939-0242ac120002',2608,'2022-08-11 01:08:45',1),('4620b210-971a-4354-ad77-5aa9b63e8f0c','2c1a3ade-0151-11ed-b939-0242ac120002',2765,'2022-08-11 01:08:45',1),('466bbcf4-0547-4c07-a783-ba6a43844751','2c1a3ade-0151-11ed-b939-0242ac120002',4118,'2022-08-11 01:08:45',1),('4837ae11-4802-40f6-8e43-b0618b26533a','2c1a3d54-0151-11ed-b939-0242ac120002',4019,'2022-08-11 01:08:45',1),('4a98a308-17b7-45a6-be77-4746ba4e0446','2c1a3ade-0151-11ed-b939-0242ac120002',3800,'2022-08-11 01:08:45',1),('4b605355-3ca2-4db7-955c-48149b66f408','2c1a3ade-0151-11ed-b939-0242ac120002',4674,'2022-08-11 12:08:45',1),('4c322d7d-ffda-4408-89e4-3959e79dacc4','2c1a3d54-0151-11ed-b939-0242ac120002',4919,'2022-08-11 01:08:45',1),('4cd44e60-e196-4753-ad3c-2de4230936ec','2c1a424a-0151-11ed-b939-0242ac120002',1214,'2022-08-11 12:08:45',0),('53c75e1f-8dfd-4cf3-9861-c328d358bcb6','2c1a3ade-0151-11ed-b939-0242ac120002',3491,'2022-08-11 12:08:45',1),('55dfda1b-c0bb-45fe-bb4d-deef2242093b','2c1a3ade-0151-11ed-b939-0242ac120002',3392,'2022-08-11 12:08:45',1),('6025514f-2373-4f4f-b190-de1bf1815267','2c1a3d54-0151-11ed-b939-0242ac120002',3099,'2022-08-11 01:08:45',1),('6189b309-42e3-4108-b47b-b71d265d60b1','2c1a3d54-0151-11ed-b939-0242ac120002',2124,'2022-08-11 01:08:45',1),('64a061c2-a991-40de-81b4-a20cdba080b3','2c1a3ade-0151-11ed-b939-0242ac120002',1766,'2022-08-11 01:08:45',0),('660fe0e9-4a3a-4ff5-afd5-c35baf49c2d5','2c1a3d54-0151-11ed-b939-0242ac120002',1092,'2022-08-11 12:08:45',0),('6758c1b6-bf73-4c14-808f-7a4f669ff292','2c1a424a-0151-11ed-b939-0242ac120002',452,'2022-08-11 12:08:45',0),('67a53b5a-b504-4701-9923-764fae999052','2c1a3d54-0151-11ed-b939-0242ac120002',1990,'2022-08-11 01:08:45',0),('67cafc26-202c-4bf9-9293-8db2b9e64756','2c1a3ade-0151-11ed-b939-0242ac120002',4188,'2022-08-11 01:08:45',1),('6ab0898d-bcdb-46e7-b706-d9861bc4e5e7','2c1a424a-0151-11ed-b939-0242ac120002',3189,'2022-08-11 12:08:45',1),('6d0ca9b7-d611-4f79-80cc-f4a159299370','2c1a3d54-0151-11ed-b939-0242ac120002',369,'2022-08-11 02:08:45',0),('7207af2d-6af4-4e78-9ca3-21bc0fbf2032','2c1a3d54-0151-11ed-b939-0242ac120002',1699,'2022-08-11 12:08:45',0),('74888994-eb98-4526-8418-8323cfcb1884','2c1a3ade-0151-11ed-b939-0242ac120002',3230,'2022-08-11 12:08:45',1),('75ae15a4-cb51-4f45-a6b7-e4b6fb5e2b1a','2c1a3ade-0151-11ed-b939-0242ac120002',3132,'2022-08-11 01:08:45',1),('76551861-6ca6-4245-bd31-350248401aa9','2c1a3d54-0151-11ed-b939-0242ac120002',2390,'2022-08-11 12:08:45',1),('76e78589-69ba-400e-9897-f3d0348270b4','2c1a424a-0151-11ed-b939-0242ac120002',4358,'2022-08-11 01:08:45',1),('796b64d4-f415-4b14-8984-b9d945ec522f','2c1a424a-0151-11ed-b939-0242ac120002',4513,'2022-08-11 01:08:45',1),('8081666e-17d5-4298-a8b0-05ffe8e8c924','2c1a3ade-0151-11ed-b939-0242ac120002',1951,'2022-08-11 12:08:45',0),('83763a52-5c26-4d4e-bd9d-a2a4b35b6c70','2c1a3d54-0151-11ed-b939-0242ac120002',3764,'2022-08-11 12:08:45',1),('884460d8-5e92-4685-9833-982a5a55fd95','2c1a424a-0151-11ed-b939-0242ac120002',784,'2022-08-11 12:08:45',0),('88e5010d-ca5f-485e-b117-2df69a95d6bd','2c1a424a-0151-11ed-b939-0242ac120002',1194,'2022-08-11 01:08:45',0),('8907276d-a6e4-4e77-9e8e-b76047cfea15','2c1a424a-0151-11ed-b939-0242ac120002',576,'2022-08-11 01:08:45',0),('8a4f3227-bfe9-400b-818d-7b74689ae485','2c1a424a-0151-11ed-b939-0242ac120002',1832,'2022-08-11 12:08:45',0),('8cbba7e1-0dcf-4588-9acd-81cccbf050bd','2c1a3ade-0151-11ed-b939-0242ac120002',1520,'2022-08-11 01:08:45',0),('92ca7775-9273-45b8-8f40-9ec568d0a82f','2c1a424a-0151-11ed-b939-0242ac120002',2019,'2022-08-11 01:08:45',1),('93cd4d13-8cb6-42f5-88d7-73f2b8edbd82','2c1a3ade-0151-11ed-b939-0242ac120002',4051,'2022-08-11 01:08:45',1),('9a317850-6e5c-4f5f-b8c3-c296eb0ccf25','2c1a3ade-0151-11ed-b939-0242ac120002',3997,'2022-08-11 12:08:45',1),('9b564734-f85a-4989-9000-bbb7db9be7a1','2c1a3d54-0151-11ed-b939-0242ac120002',1967,'2022-08-11 01:08:45',0),('a02ef7c0-1983-41e4-ad3b-2440bef5bd4c','2c1a3ade-0151-11ed-b939-0242ac120002',2020,'2022-08-12 12:08:00',0),('a0d13d93-b4e8-4860-ad05-f894efbb6761','2c1a3ade-0151-11ed-b939-0242ac120002',1802,'2022-08-11 12:08:45',0),('a1d65a6c-a881-4a57-a2fc-dd048328b10d','2c1a3d54-0151-11ed-b939-0242ac120002',4009,'2022-08-11 12:08:45',1),('a2c68f5c-33a3-43c5-96fa-398ffb635ef3','2c1a3d54-0151-11ed-b939-0242ac120002',2931,'2022-08-11 01:08:45',1),('a3370082-385e-4b9b-8d99-7ddd4008b5c4','2c1a3ade-0151-11ed-b939-0242ac120002',4300,'2022-08-12 12:08:00',1),('a5c50de2-e9b7-4502-9533-2fa9e96632f4','2c1a3ade-0151-11ed-b939-0242ac120002',2567,'2022-08-11 01:08:45',1),('b0c10083-c59c-474f-8f2f-f63e2c651aa2','2c1a3d54-0151-11ed-b939-0242ac120002',4164,'2022-08-11 12:08:45',1),('b190c142-5179-4e21-ab54-32ebb992ddb6','2c1a3ade-0151-11ed-b939-0242ac120002',4300,'2022-08-12 12:08:00',0),('b21ff931-4a92-4e7b-a79a-b0a9952a332b','2c1a3ade-0151-11ed-b939-0242ac120002',674,'2022-08-11 02:08:45',0),('b8842cb2-cc0e-4947-95fa-6d8900440fcb','2c1a3d54-0151-11ed-b939-0242ac120002',4017,'2022-08-11 01:08:45',1),('bae24666-c713-4c1e-b1b8-779e96436565','2c1a3d54-0151-11ed-b939-0242ac120002',2802,'2022-08-11 01:08:45',1),('bb9e5bb0-4bc9-411e-87b6-a8fda424c82c','2c1a3d54-0151-11ed-b939-0242ac120002',3917,'2022-08-11 01:08:45',1),('bbed4c0b-b950-4041-aeb2-cdb1f8d9e511','2c1a3ade-0151-11ed-b939-0242ac120002',3000,'2022-08-12 12:08:00',1),('bc423b81-585c-40c4-8778-3407f892f8ed','2c1a424a-0151-11ed-b939-0242ac120002',3071,'2022-08-11 01:08:45',1),('bef11077-81d3-4326-ab00-60a19e1f6b02','2c1a3ade-0151-11ed-b939-0242ac120002',2356,'2022-08-12 12:08:00',0),('bffd203f-fe02-4b56-9deb-afefb866c872','2c1a3d54-0151-11ed-b939-0242ac120002',1038,'2022-08-11 01:08:45',0),('c01aabcf-6620-48db-833c-9980bd0d9648','2c1a3d54-0151-11ed-b939-0242ac120002',2278,'2022-08-11 01:08:45',1),('c4e5fa51-a57a-4c2f-af68-c72e90c34ad9','2c1a424a-0151-11ed-b939-0242ac120002',4839,'2022-08-11 12:08:45',1),('c63ca6e8-4f66-4a6c-9e53-6b80895be7a3','2c1a3ade-0151-11ed-b939-0242ac120002',2929,'2022-08-11 01:08:45',1),('ca101bfc-55d3-4245-853c-87d7d2e996b7','2c1a3d54-0151-11ed-b939-0242ac120002',910,'2022-08-11 12:08:45',0),('caf49d1a-fded-48d1-aeda-2cb4ae908acd','2c1a3d54-0151-11ed-b939-0242ac120002',2583,'2022-08-11 01:08:45',1),('cb467048-3e74-4270-b5f6-f1ef5a05fee9','2c1a3ade-0151-11ed-b939-0242ac120002',2197,'2022-08-11 01:08:45',1),('cb87a516-a6cf-49a6-bff6-5182a7e183f1','2c1a3ade-0151-11ed-b939-0242ac120002',2053,'2022-08-11 01:08:45',1),('cd1f9ed3-9003-499f-966f-ef1af4147537','2c1a424a-0151-11ed-b939-0242ac120002',4236,'2022-08-11 01:08:45',1),('d03acd50-64b4-4852-a036-aecdaccf6d4c','2c1a3ade-0151-11ed-b939-0242ac120002',1152,'2022-08-11 12:08:45',0),('d0553c86-46ce-49da-a414-c838815bd8cb','2c1a424a-0151-11ed-b939-0242ac120002',3928,'2022-08-11 01:08:45',1),('d1e657fd-6d54-4805-823a-01519c91483e','2c1a424a-0151-11ed-b939-0242ac120002',4362,'2022-08-11 01:08:45',1),('d1fe81f9-f97d-4d5c-a3a9-88e8ead7c7f2','2c1a3d54-0151-11ed-b939-0242ac120002',2805,'2022-08-11 01:08:45',1),('d7fa773d-89b1-4e36-9f04-47de341cb8f3','2c1a3d54-0151-11ed-b939-0242ac120002',4803,'2022-08-11 01:08:45',1),('da53e22b-ef6c-41d7-9270-3b984422e9b3','2c1a424a-0151-11ed-b939-0242ac120002',629,'2022-08-11 12:08:45',0),('dca39003-fb7c-4aa4-92cb-fd20cdec76f2','2c1a3d54-0151-11ed-b939-0242ac120002',1361,'2022-08-11 01:08:45',0),('dd50340a-b617-402f-ab3b-f078ed65c3b0','2c1a424a-0151-11ed-b939-0242ac120002',2705,'2022-08-11 12:08:45',1),('dfd12cde-4509-4a03-bead-4d603b90b2b3','2c1a3ade-0151-11ed-b939-0242ac120002',5001,'2022-08-12 12:08:00',1),('e0bca6bf-0da0-4dc0-b320-7c7e862f7623','2c1a3d54-0151-11ed-b939-0242ac120002',1560,'2022-08-11 12:08:45',0),('e56ef331-a695-4a1d-aa0b-780b70efdb7f','2c1a3ade-0151-11ed-b939-0242ac120002',4380,'2022-08-11 01:08:45',1),('e793e450-ed7c-40e1-91b0-bb872cc88891','2c1a3ade-0151-11ed-b939-0242ac120002',4692,'2022-08-11 01:08:45',1),('e8eccfd4-7908-4e2e-bf3f-e5e0ef118f19','2c1a3ade-0151-11ed-b939-0242ac120002',2969,'2022-08-11 01:08:45',1),('e91b3eed-1311-439e-ba92-6be269b16512','2c1a424a-0151-11ed-b939-0242ac120002',2442,'2022-08-11 01:08:45',1),('e92e6340-d6ec-4c0b-9773-db633bf75aad','2c1a3d54-0151-11ed-b939-0242ac120002',3981,'2022-08-11 01:08:45',1),('ea411246-29db-493a-99ef-ab5569e3ef03','2c1a424a-0151-11ed-b939-0242ac120002',1678,'2022-08-11 01:08:45',0),('ea9d4987-d991-45f0-a204-f80b85b13b7a','2c1a3d54-0151-11ed-b939-0242ac120002',477,'2022-08-11 01:08:45',0),('eeb98feb-4ad2-4e70-be08-1c20ca8574e1','2c1a3d54-0151-11ed-b939-0242ac120002',948,'2022-08-11 01:08:45',0),('f45aa7af-631e-43c4-afb3-501e8c4d849a','2c1a424a-0151-11ed-b939-0242ac120002',3320,'2022-08-11 12:08:45',1),('f7cd19ed-3613-45ee-8916-5b55cff7b7c4','2c1a424a-0151-11ed-b939-0242ac120002',1737,'2022-08-11 12:08:45',0),('f8e78534-27bd-45ee-9ef5-944abb803fb4','2c1a3d54-0151-11ed-b939-0242ac120002',2648,'2022-08-11 01:08:45',1),('fb0fadde-19e2-4db1-a25b-8be5c4d29140','2c1a3d54-0151-11ed-b939-0242ac120002',397,'2022-08-11 01:08:45',0),('fcfbf72a-2be4-4a03-a44e-2149e76938e8','2c1a3ade-0151-11ed-b939-0242ac120002',1772,'2022-08-11 02:08:45',0);
/*!40000 ALTER TABLE `measurements` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sensors`
--

LOCK TABLES `sensors` WRITE;
/*!40000 ALTER TABLE `sensors` DISABLE KEYS */;
INSERT INTO `sensors` VALUES ('2c1a3ade-0151-11ed-b939-0242ac120002','MLX90393',0,'2022-07-11 21:40:08'),('2c1a3d54-0151-11ed-b939-0242ac120002','MLX90392',0,'2022-07-11 21:40:08'),('2c1a424a-0151-11ed-b939-0242ac120002','MLX90391',0,'2022-07-11 21:40:08'),('2c1a4380-0151-11ed-b939-0242ac120002','MLX90390',0,'2022-07-11 21:40:08');
/*!40000 ALTER TABLE `sensors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-11 22:52:50
