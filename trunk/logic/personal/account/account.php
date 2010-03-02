<?php

class account{

	function __construct($recursion, $account){
		$this->recursion = $recursion;
		$this->details = $account;
		include("note/note.php");
		$this->note = new note($recursion, $account["id"]);
	}

	function widraw_money($money){
		if (round($money, 2) != $money) {
			throw new Exception("Outo summa");
		}
		if ($money < 0.01) {
			throw new Exception("Liian pieni summa");
		}
		if ($money > $this->details["balance"]) {
			throw new Exception("Sinulla ei ole tarpeeksi rahaa");
		}
		$this->details["balance"] -= $money;
		$this->recursion->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	function validate_payment($account_id, $account_owner){
		if (!$account_id) {
			throw new Exception("Syötä tilinumero");
		}
		if (!$account_owner) {
			throw new Exception("Syötä saajan nimi");
		}
		if (!$to_account = $this->recursion->database->account->select("id=$account_id")) {
			throw new Exception("Käyttäjä tiliä ei löytynyt");
		}
		if (!$to_person = $this->recursion->database->person->select("name='$account_owner'")) {
			throw new Exception("Henkilöä ei löytynyt");
		}
		if ($to_person["id"] != $to_account["owner"]) {
			throw new Exception("Tili ja henkilö ei täsmää");
		}
		return true;
	}

	function pay($money, $account_id, $account_owner, $comment){
		$this->validate_payment($account_id, $account_owner);

		$this->widraw_money($money);

		$to_account = $this->recursion->database->account->select("id=$account_id");
		$to_account["balance"] += $money;

		$this->recursion->database->accountlog->insert(
			array("money"=>"-$money", "comment"=>$comment, "account"=>$this->details["id"]));
		$this->recursion->database->accountlog->insert(
			array("money"=>"+$money", "comment"=>$comment, "account"=>"$account_id"));

		$this->recursion->database->account->update(
			"balance=".$to_account["balance"], "id=$account_id");
		return true;
	}



	function show_log($id = false){
		if (!$id) {
			$log = $this->recursion->database->accountlog->select_all(
					"account=".$this->details["id"]." ORDER BY creation DESC");
		}
		else {
		$log = $this->recursion->database->accountlog->select(
				"id=$id AND account=".$this->details["id"]);
		}
		return $log;
	}

	function show_log_by_date($from = false, $to = false){
		// explode and count the numbers to see if the syntax is correct
		if (count($from = explode("-",$from)) == 3) {
			if (!is_numeric($from[2]) || !is_numeric($from[1]) || !is_numeric($from[0])) {
				$from = time();
			}
			else
				$from = mktime(23, 59, 59, $from[1], $from[2], $from[0]);
		}
		else {
			$from = time();
		}

		if (count($to = explode("-",$to)) == 3) {
			if (!is_numeric($to[2]) || !is_numeric($to[1]) || !is_numeric($to[0])) {
				$to = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
			}
			else
				$to = mktime(0, 0, 0, $to[1], $to[2], $to[0]);
		}
		else {
			$to = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
		}

		if ($to > $from) {
			$select = "account=".$this->details["id"]." AND creation > FROM_UNIXTIME($from) AND creation < FROM_UNIXTIME($to) ORDER BY creation DESC";
		}
		else
	    	$select = "account=".$this->details["id"]." AND creation < FROM_UNIXTIME($from) AND creation > FROM_UNIXTIME($to) ORDER BY creation DESC";
		return $this->recursion->database->accountlog->select_all($select);
	}
}
?>