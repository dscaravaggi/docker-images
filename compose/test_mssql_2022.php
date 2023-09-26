<?php
/* Native Microsoft client modern installation encrypted */ 
/* use correct address and password */
$serverName = "172.20.12.258";
$connectionInfo = array( "Database"=>"anagrafica", "UID"=>"php-anag-user", "PWD"=>"*******" );
$con = sqlsrv_connect( $serverName, $connectionInfo);
if( $con ) {
    echo "connection established.<br />";
}else{
echo "connection could not be established.<br />";
die( print_r( sqlsrv_errors(), true));
}
