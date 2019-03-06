<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'devices';

// Table's primary key
$primaryKey = 'device_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`device_id`', 'dt' => 0, 'field' => 'device_id' ),
	array( 'db' => '`u`.`status`',  'dt' => 1, 'field' => 'status' ),
	array( 'db' => '`u`.`sysName`',   'dt' => 2, 'field' => 'sysName' ),
	array( 'db' => '`u`.`hostname`', 'dt' => 3, 'field' => 'hostname' ),
	array( 'db' => '`u`.`hostname`', 'dt' => 4, 'field' => 'hostname' ),
	array( 'db' => '`ud`.`location`', 'dt' => 5, 'field' => 'location' ),
	array( 'db' => '`u`.`hardware`', 'dt' => 6, 'field' => 'hardware' ),
	array( 'db' => '`u`.`os`', 'dt' => 7, 'field' => 'os' ),
	array( 'db' => '`u`.`version`', 'dt' => 8, 'field' => 'version' ),
	array( 'db' => '`u`.`serial`', 'dt' => 9, 'field' => 'serial' ),
	array( 'db' => '`u`.`features`', 'dt' => 10, 'field' => 'features' ),
	array( 'db' => '`u`.`uptime`', 'dt' => 11, 'field' => 'uptime' ),
);

// SQL server connection information
$sql_details = array(
        'user' => 'ilog',
        'pass' => 'ilogpassword',
        'db'   => 'librenms',
        'host' => 'localhost'
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$joinQuery = "FROM `devices` AS `u` LEFT JOIN `locations` AS `ud` ON (`ud`.`id` = `u`.`device_id`)";
$extraWhere = "";
$groupBy = "";
$having = "";

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
);
