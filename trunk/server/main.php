<?php
session_start();

class recursion {
}
$recursion = new recursion;

include("settings/settings.php");
include("database/database.php");
include("personal/personal.php");


/* simplicity will eat this too
if ($_GET["call"]) {
	construct_call($_GET["call"], $_POST["args"]);
}
// this gets a bit trick, we need to construct a call
// from $_GET["call"] and $_POST["args"]
function construct_call($call, $args)
{
    $call = explode("->", $_GET["call"]);
    // Hack protection. Deny access to thease functions or values.
    $protected = array("database", "recursion", "settings");
    foreach ($protected as $value) {
        if (in_array($value, $call)) {
            echo "\"Access denied!\"";
            exit;
        }
    }

    try {
        if (count($call) == 1) {
            if (count($args) == 0) {
                $return = $recursion->$call[0]();
            }
            if (count($args) == 1) {
                $return = $recursion->$call[0]($args[0]);
            }
            if (count($args) == 2) {
                $return = $recursion->$call[0]($args[0], $args[1]);
            }
            if (count($args) == 3) {
                $return = $recursion->$call[0]($args[0], $args[1], $args[2]);
            }
            if (count($args) == 4) {
                $return = $recursion->$call[0]($args[0], $args[1], $args[2], $args[3]);
            }
        }
        if (count($call) == 2) {
            if (count($args) == 0) {
                $return = $recursion->$call[0]->$call[1]();
            }
            if (count($args) == 1) {
                $return = $recursion->$call[0]->$call[1]($args[0]);
            }
            if (count($args) == 2) {
                $return = $recursion->$call[0]->$call[1]($args[0], $args[1]);
            }
            if (count($args) == 3) {
                $return = $recursion->$call[0]->$call[1]($args[0], $args[1], $args[2]);
            }
            if (count($args) == 4) {
                $return = $recursion->$call[0]->$call[1]($args[0], $args[1], $args[2], $args[3]);
            }
        }
        if (count($call) == 3) {
            if (count($args) == 0) {
                $return = $recursion->$call[0]->$call[1]->$call[2]();
            }
            if (count($args) == 1) {
                $return = $recursion->$call[0]->$call[1]->$call[2]($args[0]);
            }
            if (count($args) == 2) {
                $return = $recursion->$call[0]->$call[1]->$call[2]($args[0], $args[1]);
            }
            if (count($args) == 3) {
                $return = $recursion->$call[0]->$call[1]->$call[2]($args[0], $args[1], $args[2]);
            }
            if (count($args) == 4) {
                $return = $recursion->$call[0]->$call[1]->$call[2]($args[0], $args[1], $args[2], $args[3]);
            }
        }
        if (count($call) == 4) {
            if (count($args) == 0) {
                $return = $recursion->$call[0]->$call[1]->$call[2]->$call[3]();
            }
            if (count($args) == 1) {
                $return = $recursion->$call[0]->$call[1]->$call[2]->$call[3]($args[0]);
            }
            if (count($args) == 2) {
                $return = $recursion->$call[0]->$call[1]->$call[2]->$call[3]($args[0], $args[1]);
            }
            if (count($args) == 3) {
                $return = $recursion->$call[0]->$call[1]->$call[2]->$call[3]($args[0], $args[1], $args[2]);
            }
            if (count($args) == 4) {
                $return = $recursion->$call[0]->$call[1]->$call[2]->$call[3]($args[0], $args[1], $args[2], $args[3]);
            }
        }
    }
    catch (Exception $e) {
        $return = $e->getMessage();
    }
	return $return;
}*/
// encode the response
// echo json_encode($return);

?>