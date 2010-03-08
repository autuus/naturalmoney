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

    function logged_in()
    {
    	if (isset($_SESSION["login"])) {
        	$account = $this->recursion->database->account->select("id=".$_SESSION["login"]);
            if ($_SESSION["hash"] == md5($account["username"] . $_SERVER['REMOTE_ADDR'])) {
                return $account;
            }
        }
        return false;
    }

    public function login($username, $password = "")
    {
        $login = array(
            "password" => md5($password),
            "username" => $username);

        if (!$login = $this->recursion->database->account->select($login)) {
        	throw new Exception("Vننrن kنyttنjنtunnus tai salasana");
        }
    	if (!$login["active"]) {
    		throw new Exception("Kنyttنjنtunnustasi ei ole aktivoitu vielن");
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