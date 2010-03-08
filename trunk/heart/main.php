<?php

class recursion {
	var $mysql_host = "localhost";
	var $mysql_database = "rahauudistus";
	var $mysql_username = "root";
	var $mysql_password = "";
	var $tax_percent = 4;
}
$recursion = new recursion;

include("database/database.php");
include("account/account.php");
include("publical/publical.php");
?>