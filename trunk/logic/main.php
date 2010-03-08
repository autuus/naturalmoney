<?php
session_start();

class recursion {
	var $mysql_host = "localhost";
	var $mysql_database = "naturalmoney";
	var $mysql_username = "root";
	var $mysql_password = "";
	var $tax_percent = 4;
}
$recursion = new recursion;

include("database/database.php");
include("personal/personal.php");
include("publical/publical.php");


// echo json_encode($return);

?>