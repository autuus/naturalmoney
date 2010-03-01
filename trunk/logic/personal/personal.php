<?php

class personal {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    	if ($account = $this->logged_in()) {
    		include("account/account.php");
    		$this->account = new account($recursion, $account);
            $this->details = $recursion->database->person->select("id='".$account["owner"]."'");
        }
    }

    public function logged_in()
    {
        if ($id = $_SESSION["login"]) {
        	$account = $this->recursion->database->account->select("id=$id");
            if ($_SESSION["hash"] == md5($account["username"] . $_SERVER['REMOTE_ADDR'])) {
                return $account;
            }
        }
        return false;
    }

    public function register($array)
    {
    	if ($person = $this->recursion->database->account->select(
    	"username='".$array["username"]."'")) {
    		throw new Exception("Käyttäjänimi on jo käytössä");
    	}
    	if ($person = $this->recursion->database->person->select(
    	"social_security_number='".$array["social_security_number"]."'")) {
    		throw new Exception("Sosiaaliturvatunnus on jo käytössä");
    	}

        $person = Array();
        $person["name"] = $array["name"];
        $person["address"] = $array["address"];
        $person["country"] = $array["country"];
        $person["birthdate"] = $array["birthdate"];
    	$person["social_security_number"] = $array["social_security_number"];
    	$person["email"] = $array["email"];

        $account["username"] = $array["username"];
        $account["password"] = md5($array["password"]);

        if (!$this->recursion->database->person->insert($person)) {
        	throw new Exception("Henkilöä ei luotu");
        }

    	$person = $this->recursion->database->person->select(
    		"social_security_number='".$person["social_security_number"]."'");

        $this->recursion->database->account->insert(
            array("balance" => 200,
                "owner" => $person["id"],
                "username" => $account["username"],
                "password" => $account["password"],
                "active" => 1)
        );
    	return true;
    }

    public function login($username, $password = "")
    {
        $login = array(
            "password" => md5($password),
            "username" => $username);

        if (!$login = $this->recursion->database->account->select($login)) {
        	throw new Exception("Väärä käyttäjätunnus tai salasana");
        }
    	if (!$login["active"]) {
    		throw new Exception("Käyttäjätunnustasi ei ole aktivoitu vielä");
    	}

		$this->recursion->database->account->update(
            "login_ip='" . $_SERVER['REMOTE_ADDR'] . "'", "id='" . $login["id"]."'");
        $_SESSION["login"] = $login["id"];
        $_SESSION["hash"] = md5($login["username"] . $_SERVER['REMOTE_ADDR']);
    	return true;
    }

	public function logout()
	{
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
	}
}

$recursion->personal = new personal($recursion);
?>