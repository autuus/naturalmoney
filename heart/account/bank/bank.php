<?php

class bank {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    	$this->recursion->account->details["code"] =
    		$this->id_to_code($this->recursion->account->details["id"]);
    }

	function id_to_code($id){
		$code = $id;
		$code .= substr($id * 2, -1);
		$code .= substr($id * 3, -1);
		return $code;
	}
	function code_to_id($code){
		$id = substr($code, 0, strlen($code)-2);
		if ($this->id_to_code($id) != $code) {
			throw new Exception("Tarkista tilinumero");
		}
        return $id;
	}

    function withdraw_money($money)
    {
        if (round($money, 2) != $money) {
            throw new Exception("Outo summa");
        }
        if ($money < 0.01) {
            throw new Exception("Liian pieni summa");
        }
        if ($money > $this->recursion->account->details["balance"]) {
            throw new Exception("Sinulla ei ole tarpeeksi rahaa");
        }
        $this->recursion->account->details["balance"] -= $money;
        $this->recursion->database->account->update(
            "balance=" . $this->recursion->account->details["balance"],
            "id=" . $this->recursion->account->details["id"]);
    }

    function pay($money, $account_code, $comment)
    {
    	if (!$account_code) {
    		throw new Exception("Syötä tilinumero");
    	}
    	$account_id = $this->code_to_id($account_code);
    	if (!$to_account = $this->recursion->database->account->select("id=$account_id")) {
    		throw new Exception("Käyttäjä tiliä ei löytynyt");
    	}

        $this->withdraw_money($money);

        $to_account = $this->recursion->database->account->select("id=$account_id");

        $to_account["balance"] += $money;

        $this->recursion->database->account->update(
    	    "balance=" . $to_account["balance"], "id=" . $to_account["id"]);

        $this->recursion->database->accountlog->insert(
            array("money" => "-$money", "comment" => $comment,
            "account" => $this->recursion->account->details["id"]));
        $this->recursion->database->accountlog->insert(
            array("money" => "+$money", "comment" => $comment,
            "account" => $to_account["id"]));

        return true;
    }

    function show_log_by_id($id = false)
    {
        if (!$id) {
            return false;
        } else {
            $log = $this->recursion->database->accountlog->select(
                "id=$id AND account=" . $this->recursion->account->details["id"]);
        }
        return $log;
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
            $select = "account=" . $this->recursion->account->details["id"] . " AND creation > FROM_UNIXTIME($from) AND creation < FROM_UNIXTIME($to) ORDER BY creation DESC";
        } else
            $select = "account=" . $this->recursion->account->details["id"] . " AND creation < FROM_UNIXTIME($from) AND creation > FROM_UNIXTIME($to) ORDER BY creation DESC";
        return $this->recursion->database->accountlog->select_all($select);
    }
}

?>