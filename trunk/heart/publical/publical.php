<?php
class publical {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    }

	function count_users()
	{
		return count($this->recursion->database->account->select_all());
	}

    function money_in_circulation()
    {
        $account = $this->recursion->database->account->select_all();
        foreach ($account as $key => $value) {
            $money += $value["balance"];
        }
        $note = $this->recursion->database->note->select_all();
        if (!$note)
            return $money;
        foreach ($note as $key => $value) {
            $money += $value["money"];
        }
        return $money;
    }

    function tax_all()
    {
        $account = $this->recursion->database->account->select_all();
    	$overall_taxed = 0;
        foreach ($account as $key => $value) {

        	// skip government account
        	if ($value["id"] == 1) {
        		continue;
        	}

            $money = $value["balance"];
        	$tax = $money * $this->recursion->tax_percent * 0.01;

        	// rounding up with ceil, that cant handle double
        	$tax *= 100;
        	$tax = ceil($tax);
        	$tax *= 0.01;

        	echo "Account ".$value["id"]." with balance ".$value["balance"]." paid $tax<br>";

        	$value["balance"] -= $tax;
        	$overall_taxed += $tax;


        	$this->recursion->database->account->update(
        		"balance=".$value["balance"], "id=".$value["id"]);

            $this->recursion->database->accountlog->insert(
                array("money" => "-$tax", "comment" => "Vero", "account" => $value["id"]));
        }
        $note = $this->recursion->database->note->select_all();
    	foreach ($note as $key => $value) {

    		$money = $value["money"];
    		$tax = $money * $this->recursion->tax_percent * 0.01;

    		// rounding up with ceil, that cant handle double
    		$tax *= 100;
    		$tax = ceil($tax);
    		$tax *= 0.01;

    		echo "Note ".$value["id"]." of value ".$value["money"]." paid $tax<br>";

    		$value["money"] -= $tax;
    		$overall_taxed += $tax;

    		$this->recursion->database->note->update(
    			"money=".$value["money"], "id=".$value["id"]);
    	}

    	$government = $this->recursion->database->account->select("id=1");
    	$government["balance"] += $overall_taxed;
    	$this->recursion->database->account->update("balance=".$government["balance"], "id=1");

    	echo "overall taxed $overall_taxed";
    	$this->recursion->database->accountlog->insert(
    	    array("money" => "+$overall_taxed", "comment" => "Vero tulot", "account" => 1));
        return true;
    }


    function register($array)
    {
        if ($person = $this->recursion->database->account->select(
                "username='" . $array["username"] . "'")) {
            throw new Exception("Käyttäjänimi on jo käytössä");
        }
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $array["email"])) {
            throw new Exception("Sähköpostiosoite in virheellinen");
        }
        if ($person = $this->recursion->database->account->select(
                "email='" . $array["email"] . "'")) {
            throw new Exception("Sähköposti osoite on jo käytössä");
        }

        $person["name"] = $array["name"];
        $person["address"] = $array["address"];
        $person["country"] = $array["country"];
        $person["phone"] = $array["phone"];
        $person["social_security_number"] = $array["social_security_number"];

        if ($person["social_security_number"]) {
            if ($this->recursion->database->person->select("social_security_number='" . $array["social_security_number"] . "'")) {
                throw new Exception("Sosiaaliturvatunnus on jo käytössä, jos epäilette henkilöllisyys rikosta, soittakaa asiakaspalveluun.");
            }

            if (!$this->recursion->database->person->insert($person)) {
                throw new Exception("Tietokantavirhe, henkilöä ei luotu");
            }

            $new_person = $this->recursion->database->person->select(
                "social_security_number='" . $person["social_security_number"] . "'");

        	$account["person"] = $new_person["id"];
        }

        $account["email"] = $array["email"];
        $account["username"] = $array["username"];
        $account["password"] = md5($array["password"]);

        $this->recursion->database->account->insert($account);
        return true;
    }

	function show_log_by_date($from = false, $to = false)
	{
		// explode and count the numbers to see if the syntax is correct
		if (count($from = explode("-", $from)) == 3) {
			if (!is_numeric($from[2]) || !is_numeric($from[1]) || !is_numeric($from[0])) {
				$from = time();
			} else
				$from = mktime(23, 59, 59, $from[1], $from[2], $from[0]);
		} else {
			$from = time();
		}

		if (count($to = explode("-", $to)) == 3) {
			if (!is_numeric($to[2]) || !is_numeric($to[1]) || !is_numeric($to[0])) {
				$to = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
			} else
				$to = mktime(0, 0, 0, $to[1], $to[2], $to[0]);
		} else {
			$to = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
		}

		if ($to > $from) {
			$select = "account=1 AND creation > FROM_UNIXTIME($from) AND creation < FROM_UNIXTIME($to) ORDER BY creation DESC";
		} else
			$select = "account=1 AND creation < FROM_UNIXTIME($from) AND creation > FROM_UNIXTIME($to) ORDER BY creation DESC";
		return $this->recursion->database->accountlog->select_all($select);
	}
}

$recursion->publical = new publical($recursion);

?>