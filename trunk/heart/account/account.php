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
			$this->person =  $this->recursion->database->person->select("id='" . $this->details["person"] . "'");
		}
        return true;
	}

    function logged_in($session)
    {
    	if ($account = $this->recursion->database->account->select("session='" .
    		md5($_SERVER['REMOTE_ADDR'].$session)."'")) {
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
            "session='" . md5($_SERVER['REMOTE_ADDR'].$session) . "', last_refresh=NOW()",
            "id='" . $login["id"] . "'");

        return $session;
    }

    function logout($session)
    {
        $account = $this->recursion->database->account->update(
        "session=0",
        "session='" .md5($_SERVER['REMOTE_ADDR'].$session)."'");
    }
}

$recursion->account = new account($recursion);
?>