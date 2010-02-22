<?php

class account{

	function __construct($recursion, $account){
		$this->recursion = $recursion;
		$this->details = $account;
		include("note/note.php");
		$this->note = new note($recursion);
	}

	private function widraw_money($money){
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

	private function deposit_money($money){
		if ($money < 0.01) {
			throw new Exception("Invalid amount");
		}
		$this->details["balance"] += $money;
		$this->recursion->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	public function pay($money, $to, $owner_name, $comment){
		if (!$to_account = $this->recursion->database->account->select("id=$to")) {
			throw new Exception("Account does not exist");
		}
		if (!$to_person = $this->recursion->database->person->select("name=".$owner_name)) {
			throw new Exception("Person does not exist");
		}
		if ($to_person["id"] != $to_account["owner"]) {
			throw new Exception("Name and account did not match");
		}
		$this->widraw_money($money);
		$to_account["balance"] += $money;
		$this->recursion->database->account->update(
			"balance=".$to_account["balance"], "id=$to");
		return true;
	}
}
?>