<?php

class personal {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    	if ($account = $this->logged_in()) {
    		include("account/account.php");
    		$this->account = new account($recursion, $account);
            $this->details = $recursion->database->person->select("id=".$account["owner"]);
        }
    }

    public function logged_in()
    {
        if ($id = $_SESSION["login"]) {
            $account = $this->recursion->database->account->select("id=$id");
            if ($_SESSION["hash"] == md5($account["username"] . $_SERVER['REMOTE_ADDR'])) {
            	$account["password"] = "";
                return $account["username"];
            }
        }
        return false;
    }

    public function create_person($array)
    {
    	if ($person = $this->recursion->database->person->select(
    	"username=".$array["username"])) {
    		throw new Exception("username is allredy in use");
    	}
    	if ($person = $this->recursion->database->person->select(
    	"social_security_number=".$array["social_security_number"])) {
    		throw new Exception("Social security number is allredy in use");
    	}

        $person = Array();
        $person["name"] = $array["name"];
        $person["address"] = $array["address"];
        $person["country"] = $array["country"];
        $person["birthdate"] = $array["birthdate"];
    	$person["social_security_number"] = $array["social_security_number"];
    	$person["email"] = $array["email"];


        $account["username"] = $array["username"];
        $account["password"] = $array["password"];

        if (!$this->recursion->database->person->insert($person)) {
        	throw new Exception("Person was not created");
        }

        $person = $this->recursion->database->person->select($person);
        $this->recursion->database->account->insert(
            array("balance" => 0,
                "owner" => $person["id"],
                "username" => $account["username"],
                "password" => $account["password"])
        	);
    }

    public function login($username, $password = "")
    {
        $login = array(
            "password" => md5($password),
            "username" => $username);

        if (!$login = $this->recursion->database->account->select($login)) {
        	throw new Exception("Invalid username or password");
        }
    	if (!$login["active"]) {
    		throw new Exception("Your account has not been activated yet");
    	}

		$this->recursion->database->account->update(
            "loggin_ip='" . $_SERVER['REMOTE_ADDR'] . "'", "id=" . $login["id"]);
        $_SESSION["login"] = $login["id"];
        $_SESSION["login_hash"] = md5($login["username"] . $_SERVER['REMOTE_ADDR']);
    }
}

$recursion->personal = new personal($recursion);
?>