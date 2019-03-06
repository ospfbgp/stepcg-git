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
$table = 'ignition_catId_10';

// Table's primary key
$primaryKey = 'seq';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'seq',                        'dt' => 0 ),
    array( 'db' => 'Id',                         'dt' => 1 ),
    array( 'db' => 'datetime',                   'dt' => 2 ),
    array( 'db' => 'host',                       'dt' => 3 ),
    array( 'db' => 'AuthServerName',             'dt' => 4 ),
    array( 'db' => 'AuthenticationDecision',     'dt' => 5 ),
    array( 'db' => 'AuthenticatorIpAddr',        'dt' => 6 ),
    array( 'db' => 'AuthenticatorName',          'dt' => 7 ),
    array( 'db' => 'AuthenticatorType',          'dt' => 8 ),
    array( 'db' => 'UserNameAttr',               'dt' => 9 ),
    array( 'db' => 'AuthorizationDecision',      'dt' => 10 ),
    array( 'db' => 'AuthorizationRuleIds',       'dt' => 11 ),
    array( 'db' => 'CallingStationIdAttr',       'dt' => 12 ),
    array( 'db' => 'CredentialValidationPolicy', 'dt' => 13 ),
    array( 'db' => 'Description',                'dt' => 14 ),
    array( 'db' => 'DirectoryServiceName',       'dt' => 15 ),
    array( 'db' => 'NASIPAddrAttr',              'dt' => 16 ),
    array( 'db' => 'ProvisioningValues',         'dt' => 17 ),
    array( 'db' => 'ServiceCatName',             'dt' => 18 ),
    array( 'db' => 'UserId',                     'dt' => 19 )
);

// SQL server connection information
$sql_details = array(
	'user' => 'ilog',
	'pass' => 'ilogpassword',
	'db'   => 'ilog',
	'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
