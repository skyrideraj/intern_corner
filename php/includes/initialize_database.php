<?php
require_once __DIR__.'/../zebra/Zebra_Database.php';
class Database{

function __construct(){

}
function connectToDatabase(){
$conn_error = 'could not connect to database';
$mysql_host = 'localhost';
$mysql_user = 'sen';
$mysql_pass = 'password';
$mysql_db = 'InternCorner';
$db = new Zebra_Database();
$db->debug=true;
$db->connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
return $db;

}

}
?>