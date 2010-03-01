<?php
include("logic/main.php");

$page = "login";

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
    		if ($_SESSION["validate_payment"] && $_POST["permission"]) {
    			$_SESSION["validate_payment"] = false;
    			if ($recursion->personal->account->pay(
    				$_POST["money"], $_POST["account_id"], $_POST["account_owner"], $_POST["comment"]))
    				throw new Exception("Maksu hyväksytty");
    		}
    		else
    		{
    			if ($_POST)
    			{
    				$recursion->personal->account->validate_payment($_POST["account_id"], $_POST["account_owner"]);
					$_SESSION["validate_payment"] = true;
    			}
    		}
    	}
    	else
	    	$_SESSION["validate_payment"] = false;

    	if ($_GET["action"] == "accountlog") {
    		if ($_GET["id"]) {
    			$accountlog = $recursion->personal->account->show_log($_GET["id"]);
    		}
    	}

    	if ($_GET["action"] == "notes") {
    		$barcode = $_GET["barcode"];
    		if ($_POST["create_note"]) {
    			$new_note = $recursion->personal->account->note->create($_POST["create_note"]);
    			$barcode = $new_note["barcode"];
    			//Header("Location: ?action=shownote&barcode=".$new_note["barcode"]);
    			throw new Exception("Seteli luotu");
    		}
    		if ($_GET["redeem"]) {
    			$recursion->personal->account->note->redeem($_GET["redeem"]);
    		}
    	}
    	if ($_GET["action"] == "shownote") {
    		include("show/account/shownote.php");
    	}
    }else {
    	if ($_GET["action"] == "info")
    		$page = "info";
    	if ($_GET["action"] == "public")
    		$page = "public";

    	if ($_GET["action"] == "register") {
    		if ($_POST["args"]) {
    			if ($recursion->personal->register($_POST["args"])) {
    				throw new Exception("Kiitos mielenkinnosta, käyttäjätunnuksesi on aktivoitu");//"Kiitos! Rekisteröinti odottaa hyväksyntää");
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
A:hover {text-decoration: none; color: orange;}
table {border-width: 0px; border-spacing: 0; }
</style>
<div align="center" style="position: absolute; left: 10%;top: 10%; width: 80%">
<font size=-1>Rahaj&auml;rjestelm&auml; on toistaiseksi testik&auml;yt&ouml;ss&auml;</font><br>
<font color="red"><?php echo $error; ?></font><br>
<?php include("show/$page.php"); ?>
</div>