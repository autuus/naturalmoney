<?php
include("main.php");
/* interface handles get and post and turns them into json objects */
do {
try {
    $recursion->publical->day_tax_check();

	$return["page"] = "login";

    if ($_GET["action"] == "logout") {
        $recursion->account->logout($_POST["session"]);
    	break;
    }
	if ($_GET["action"] == "login") {
		$return["session"] = $recursion->account->login($_POST["username"], $_POST["password"]);
        $_POST["session"] = $return["session"];
    }
    if ($_GET["action"] == "info")
        $return["page"] = "info";

	// thease are for viewing the accountlogs
	$return["from_date"] = $_GET["from_date"];
	$return["to_date"] = $_GET["to_date"];

	if (!$_GET["from_date"]) {
		// from now
		$return["from_date"] = date("Y-m-d");
	}
	if (!$_GET["to_date"]) {
		// to last month
		$return["to_date"] = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
	}

	if ($_GET["action"] == "public") {
		$return["page"] = "public";
        $return["public"] = $recursion->publical->gather_information();
		$return["public_account_log"] = $recursion->publical->show_log_by_date($return["from_date"], $return["to_date"]);
	}

    if ($_GET["action"] == "register") {
        $return["page"] = "register";
        if ($_POST["register"]) {
            if ($recursion->publical->register($_POST["register"])) {
                $return["page"] = "login";
                throw new Exception("Rekiströinti onnistui!");
            }
        }
    }

    // from this point on, you need to be logged in
    if (!$recursion->account->init($_POST["session"])) {
        break;
    }
	$return["logged_in"] = true;
	$return["details"]["username"] = $recursion->account->details["username"];
	$return["details"]["email"] = $recursion->account->details["email"];
	$return["details"]["account_code"] = $recursion->account->details["code"];
	$return["details"]["balance"] = $recursion->account->details["balance"];

	if ($return["page"] == "login") {
		$return["page"] = "account";
		$return["account_log"] = $recursion->account->bank->show_log_by_date($return["from_date"], $return["to_date"]);
    }

    if ($_GET["action"] == "payment") {
        $return["page"] = "payment";

        if ($_POST["payment_permission"]) {
            if ($recursion->account->bank->pay($_POST["money"],
            $_POST["account_code"], $_POST["comment"]))
                throw new Exception("Maksu hyväksytty");
        }
    }

	if ($_GET["action"] == "tax") {
		$return["page"] = "tax";

		if ($recursion->account->details["id"] == 1) {
			$return["taxpage"] = $recursion->publical->day_tax();
		}
	}

    if ($_GET["action"] == "edit") {
        $return["page"] = "edit";

        $return["person"] = $recursion->account->details["person"];

        if ($_POST["edit"])
        {
            if ($recursion->account->details["password"] != md5($_POST["password"]))
                throw new Exception("Salasana ei täsmää");

            $recursion->account->edit($_POST["edit"]);

	        $return["details"]["email"] = $recursion->account->details["email"];
            $return["person"] = $recursion->account->details["person"];
            throw new Exception("Tallennettu!");
        }

    }

    if ($_GET["action"] == "accountlog") {
        $return["page"] = "accountlog";

        if ($_GET["id"]) {
            $return["log"] = $recursion->account->bank->show_log_by_id($_GET["id"]);
        }
    }

    if ($_GET["action"] == "notes") {
        $return["page"] = "notes";

        if ($_POST["create_note"]) {
            $return["note"] = $recursion->account->note->create($_POST["create_note"]);
    	    $return["notes"] = $notes = $recursion->account->note->get_notes();
            throw new Exception("Seteli luotu");
        }
        if ($_GET["redeem"]) {
            $recursion->account->note->redeem($_GET["redeem"]);
        }

    	$return["note"] = $recursion->database->note->select("barcode='".$_GET["barcode"]."'");
    	$return["notes"] = $notes = $recursion->account->note->get_notes();
    }
}
catch (Exception $e) {
    $return["error"] = $e->getMessage();
}
}while(false);

if ($_GET["console"]) {
	echo json_encode($return);
}
?>