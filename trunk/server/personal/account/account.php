<?php

class account{

	function __construct($recursion, $account){
		$this->recursion = $recursion;
		$this->details = $account;
		include("note/note.php");
		$this->note = new note($recursion, $account["id"]);
	}

	function widraw_money($money){
		if ($money < 0.01) {
			throw new Exception("Invalid amount");
		}
		if ($money > $this->details["balance"]) {
			throw new Exception("Not enough money");
		}
		$this->details["balance"] -= $money;
		$this->recursion->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	function deposit_money($money){
		if ($money < 0.01) {
			throw new Exception("Invalid amount");
		}
		$this->details["balance"] += $money;
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
			array("money"=>"- $money", "comment"=>$comment, "account"=>$this->details["id"]));
		$this->recursion->database->accountlog->insert(
			array("money"=>"+ $money", "comment"=>$comment, "account"=>"$account_id"));

		$this->recursion->database->account->update(
			"balance=".$to_account["balance"], "id=$account_id");
		return true;
	}



	function show_log($arg1 = false, $arg2 = false){
		if (!$arg1 && !$arg2) {
			$log = $this->recursion->database->accountlog->select_all(
				"account=".$this->details["id"]." ORDER BY creation DESC");
		}
		if ($arg1) {
			$log = $this->recursion->database->accountlog->select(
				"id=$arg1 AND account=".$this->details["id"]."");
		}
		/*
		if (arg1 && arg2){
		   $log = $this->recursion->database->accountlog
		*/

		return $log;
	}
}
?>