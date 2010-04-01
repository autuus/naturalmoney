<?php

class account {
    function __construct($recursion)
    {
    	$this->recursion = $recursion;
    }

	function init($session){
		$this->details = $this->logged_in($session);
        if (!$this->details)
            return false;
		include("note/note.php");
		$this->note = new note($this->recursion, $this->details["id"]);
		include("bank/bank.php");
		$this->bank = new bank($this->recursion);

		if ($this->details["person"]) {
			//include("person/person.php");
			$this->details["person"] =  $this->recursion->database->person->select("id=" . $this->details["person"]);
            unset($this->details["person"]["social_security_number"]);
		}
        return true;
	}

    function reload()
    {
		$this->details = $this->recursion->database->account->select("id=".$this->details["id"]);
		if ($this->details["person"]) {
			$this->details["person"] =  $this->recursion->database->person->select("id=" . $this->details["person"]);
            unset($this->details["person"]["social_security_number"]);
		}
    }

    function edit($array)
    {
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $array["email"])) {
            throw new Exception("Sähköpostiosoite on virheellinen");
        }
        if ($found = $this->recursion->database->account->select(
            array("email" => $array["email"]))
        ){
            if ($found["id"] != $this->details["id"]) {
                throw new Exception("Sähköposti osoite on jo käytössä");
            }
        }

        if ($array["name"])
            $person["name"] = $array["name"];
        if ($array["address"])
            $person["address"] = $array["address"];
        if ($array["country"])
            $person["country"] = $array["country"];
        if ($array["phone"])
            $person["phone"] = $array["phone"];

        if ($array["social_security_number"])
            $person["social_security_number"] = $array["social_security_number"];

        if ($person["social_security_number"] && !$this->details["person"]) {

            $this->recursion->database->person->insert($person);

            $new_person = $this->recursion->database->person->select(
                array("social_security_number" => $person["social_security_number"]));

            $account["person"] = $new_person["id"];
        }
        else
            $this->recursion->database->person->update($person, "id=".$this->details["person"]["id"]);

        if ($array["email"])
            $account["email"] = $array["email"];
        if ($array["password"])
            $account["password"] = md5($array["password"]);

        $this->recursion->database->account->update($account, "id=".$this->details["id"]);

        $this->reload();
        return true;
    }

    function logged_in($session)
    {
    	if ($account = $this->recursion->database->account->select(
            array("session" => md5($_SERVER['REMOTE_ADDR'].$session)))
        ) {
    		$last_refresh = strtotime($account["last_refresh"]);
            $now = time();
    		// session timeout is 15 minutes
    		if ($now+60*15 < $last_refresh) {
    			throw Exception("Session timeout");
    		}
            // bypass the logging, we dont need to log this
    		$this->recursion->database->query(
            "UPDATE account SET last_refresh=NOW() WHERE id=".$account["id"]);
            return $account;
    	}
    	return false;
    }

    function login($username, $password = "")
    {
        $login = array(
            "password" => md5($password),
            "username" => $username);

        if (!$login = $this->recursion->database->account->select($login)) {
            throw new Exception("Väärä käyttäjätunnus tai salasana");
        }

    	$session = rand(10, 10000);
        $this->recursion->database->account->update(
            array("session" => md5($_SERVER['REMOTE_ADDR'].$session), "last_refresh" => "NOW()"),
            "id=" . $login["id"]);

        return $session;
    }

    function logout($session)
    {
        $account = $this->recursion->database->account->update(
        "session=0",
        array("session" => md5($_SERVER['REMOTE_ADDR'].$session)));
    }
}

$recursion->account = new account($recursion);
?>