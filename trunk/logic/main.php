<?php
class recursion{
	function __construct($recursion)
	{
		session_start();

		include("settings/settings.php");
		$recursion->settings = new settings;
		include("database/database.php");
		$recursion->database = new database($recursion);
		include("personal/personal.php");
		$recursion->personal = new personal($recursion);
	}
}
$recursion = new recursion($recursion);

?>