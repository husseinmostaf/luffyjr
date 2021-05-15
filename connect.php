<?php
if (!isset($config)) {
    exit;
}
// sql inject protection
// sql injection class
include("sql_reports/sql_reports.php");
include("sql_check.php");
$conn_string = "host=" . $config['pgsql_host'] . " port=" . $config['pgsql_port'] . " dbname=" . $config['db_name'] . " user=" . $config['pgsql_user'] . " password=" . $config['pgsql_password'] . "";
$dbconn = pg_connect($conn_string);
try{$dbuser = "" . $config['pgsql_user'] . "";
$dbpass = "" . $config['pgsql_password'] . "";
$host = "" . $config['pgsql_host'] . "";
$dbname="" . $config['db_name'] . "";
$connec = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass);
}
catch (PDOException $e)
{
	echo "Error : " . $e->getMessage() . "<br/>";
	die();
}
?>