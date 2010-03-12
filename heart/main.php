<?php

class recursion {
	var $mysql_host = "localhost";
	var $mysql_database = "rahauudistus";
	var $mysql_username = "root";
	var $mysql_password = "";
    var $government_buypower = 0.25; // how much buyingpower does the
                                                            // government have compared to an individual
    var $equalibrium = 1000;  // Natural balance of one person's account
}
$recursion = new recursion;

include("database/database.php");
include("account/account.php");
include("publical/publical.php");
?>