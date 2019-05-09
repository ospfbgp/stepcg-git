-- MySQL dump 10.16  Distrib 10.1.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: librenms
-- ------------------------------------------------------
-- Server version	10.1.34-MariaDB-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alert_templates`
--

DROP TABLE IF EXISTS `alert_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_rec` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert_templates`
--

LOCK TABLES `alert_templates` WRITE;
/*!40000 ALTER TABLE `alert_templates` DISABLE KEYS */;
INSERT INTO `alert_templates` VALUES (8,'Default Alert Template','<div style=\"font-family:Georgia;\">\n<b>Severity:</b> @if ($alert->state == 1) @if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">{{ $alert->severity }}</span> @else <span style=\"color:red;\">{{ $alert->severity }}</span> @endif @endif\n@if ($alert->state == 2) <span style=\"color:goldenrod;\">Acknowledged</span> @endif\n@if ($alert->state == 3) <span style=\"color:orange;\">Got worse</span> @endif\n@if ($alert->state == 4) <span style=\"color:green;\">Got better</span> @endif\n@if ($alert->state == 0) <span style=\"color:green;\">Recovered</span> @endif\n<br> \n<b>Rule:</b> @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif<br>\n@if ($alert->state == 0)<b>Alert-ID:</b> {{ $alert->id }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 1)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 2)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 3)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 4)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n<b>sysDescr:</b> {{ $alert->sysDescr }}<br>\n<b>sysName:</b> {{ $alert->sysName }} - {{ $alert->hostname }}<br>\n@if ($alert->state != 0)\n@if ($alert->faults)<b>Faults: </b><br>\n@foreach ($alert->faults as $key => $value) <b>#{{ $key }}</b> {{ $value[\'string\'] }}<br>\n@endforeach\n@endif\n@endif\n</div>','Alert: {{ $alert->sysName }} - {{ $alert->name }}','Recovered: {{ $alert->sysName }} - {{ $alert->name }}'),(9,'Service Alert Template','<div style=\"font-family:Georgia;\">\n<b>Severity:</b> @if ($alert->state == 1) @if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">{{ $alert->severity }}</span> @else <span style=\"color:red;\">{{ $alert->severity }}</span> @endif @endif\n@if ($alert->state == 2) <span style=\"color:goldenrod;\">Acknowledged</span> @endif\n@if ($alert->state == 3) <span style=\"color:orange;\">Got worse</span> @endif\n@if ($alert->state == 4) <span style=\"color:green;\">Got better</span> @endif\n@if ($alert->state == 0) <span style=\"color:green;\">Recovered</span> @endif\n<br> \n<b>Rule:</b> @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif<br>\n@if ($alert->state == 0)<b>Alert-ID:</b> {{ $alert->id }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 1)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 2)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 3)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 4)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n<b>sysName:</b> {{ $alert->sysName }} - {{ $alert->hostname }}<br>\n@if ($alert->state != 0)\n@if ($alert->faults)<b>Service faults:</b><br>\n@foreach ($alert->faults as $key => $value) <b>#{{ $key }}</b> <b>{{ $value[\'service_type\'] }}</b> {{ $value[\'service_message\'] }}<br>\n@endforeach\n@endif\n@endif\n</div>','Service Alert: {{ $alert->sysName }} - {{ $alert->name }}','Service Recovered: {{ $alert->sysName }} - {{ $alert->name }}'),(10,'Syslog Alert Template','<div style=\"font-family:Georgia;\">\n<b>Severity:</b> @if ($alert->state == 1)\n@if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">{{ $alert->severity }}</span> @else <span style=\"color:red;\">{{ $alert->severity }}</span> @endif\n@endif\n@if ( $alert->state == 2 ) <span style=\"color:goldenrod;\">Acknowledged</span> @endif\n@if ( $alert->state == 3 )\n@if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">Got worse</span> @else <span style=\"color:red;\">Got worse</span> @endif\n@endif\n@if ($alert->state == 4)\n@if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">Got better</span> @else <span style=\"color:green;\">Got better</span> @endif\n@endif\n@if ($alert->state == 0) <span style=\"color:green;\">Recovered</span> @endif\n<br> \n<b>Rule:</b> @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif<br>\n@if ($alert->state == 0)<b>Alert-ID:</b> {{ $alert->id }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 1)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 2)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 3)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 4)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n<b>sysDescr:</b> {{ $alert->sysDescr }}<br>\n<b>sysName:</b> {{ $alert->sysName }} - {{ $alert->hostname }}<br>\n@if ($alert->state != 0)\n@if ($alert->faults)<b>Faults:</b><br>\n@foreach ($alert->faults as $key => $value) <b>#{{ $key }}</b> {{ $value[\'msg\'] }}<br>\n@endforeach\n@endif\n@endif\n</div>','Syslog Alert: {{ $alert->sysName }} - {{ $alert->name }}',''),(11,'CPU/Memory Alert Template','<div style=\"font-family:Georgia;\">\n<b>Severity:</b> @if ($alert->state == 1) @if ( $alert->severity == \'ok\' ) <span style=\"color:green;\">{{ $alert->severity }}</span> @else <span style=\"color:red;\">{{ $alert->severity }}</span> @endif @endif\n@if ($alert->state == 2) <span style=\"color:goldenrod;\">Acknowledged</span> @endif\n@if ($alert->state == 3) <span style=\"color:orange;\">Got worse</span> @endif\n@if ($alert->state == 4) <span style=\"color:green;\">Got better</span> @endif\n@if ($alert->state == 0) <span style=\"color:green;\">Recovered</span> @endif\n<br> \n<b>Rule:</b> @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif<br>\n@if ($alert->state == 0)<b>Alert-ID:</b> {{ $alert->id }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 1)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n @endif\n@if ($alert->state == 2)<b>Alert-ID:</b> {{ $alert->uid }}<br>\n<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 3)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n@if ($alert->state == 4)<b>Timestamp:</b> {{ $alert->timestamp }}<br>\n@endif\n<b>sysDescr:</b> {{ $alert->sysDescr }}<br>\n<b>sysName:</b> {{ $alert->sysName }} - {{ $alert->hostname }}<br>\n@foreach ($alert->faults as $key => $value)\n@if ($value[\'mempool_perc\'])<b>Memory Usage:</b> {{ $value[\'mempool_perc\'] }} %<br>@endif\n@if ($value[\'processor_usage\'])<b>CPU Usage:</b> {{ $value[\'processor_usage\'] }}%<br>@endif\n@endforeach\n</div>','Alert: {{ $alert->sysName }} - {{ $alert->name }}','Recovered: {{ $alert->sysName }} - {{ $alert->name }}');
/*!40000 ALTER TABLE `alert_templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-09  9:32:44
