<?php
include("../server/main.php");

try {
    if ($_GET["action"] == "logout") {
        $recursion->personal->logout();
        header("Location: ?");
    }
    if ($_GET["action"] == "login") {
        $recursion->personal->login($_POST["username"], $_POST["password"]);
        header("Location: ?");
    }

    if ($recursion->personal->logged_in()) {
        $page = "account";

    	if ($_GET["action"] == "payment") {
    		if ($_SESSION["validate_payment"]) {
    			$_SESSION["validate_payment"] = false;
    			if ($recursion->personal->account->pay($_POST["money"], $_POST["account_id"]))
    				throw new Exception("maksu hyväksytty");
    		}
    		else
    		{
    			if ($_POST["account_id"])
    			{
    				$account_owner = $recursion->personal->account->get_account_owner($_POST["account_id"]);
    				$_SESSION["validate_payment"] = true;
    			}
    		}
    	}
    }else {
        $page = "login";

    	if ($_GET["action"] == "register") {
    		if ($_POST["args"]) {
    			if ($recursion->personal->create_person($_POST["args"])) {
    				throw new Exception("kiitos! rekisteröinti odottaa hyväksyntää");
    			}
    		} else
            	$page = "register";
        }
    }
}
catch (Exception $e) {
    $error = $e->getMessage();
}

?>

<style type="text/css">
body {
	font-family:"Arial",Georgia,Serif;
}
A:link {text-decoration: none; color: blue;}
A:visited {text-decoration: none; color: blue;}
A:active {text-decoration: none; color: blue;}
A:hover {text-decoration: none; color: black;}
table {border-width: 0px; border-spacing: 0; }
</style>
<div align="center" style="position: absolute; left: 30%;top: 30%;">
<font color="red"><?php echo $error; ?></font><br>
<?php include("page/$page.php"); ?>
</div>