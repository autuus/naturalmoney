<?php

$_GET["call"] = "personal->login";
$_POST["args"] = array("droppen","password");
include("../logic/main.php");
exit;
$return = array();

try{

	switch($_GET["action"]){
		case "login":
			$recursion->personal->login($_POST["username"], $_POST["password"]);
			break;
		case "":
			;
			break;
		default:
			;
	}

} catch (Exception $e) {
	$return["error"] = $e->getMessage();
}
?>