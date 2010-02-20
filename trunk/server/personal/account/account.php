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
		if ($money > $this->details["money"]) {
			throw new Exception("Not enough money");
		}
		$this->moneyfilter($money);
		$this->details["balance"] -= $money;
		$this->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	private function deposit_money($money){
		if ($money < 0.01) {
			throw new Exception("Invalid amount");
		}
		$this->details["balance"] += $money;
		$this->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	public function pay($money, $to, $note){
		if (!$to_account = $this->recursion->database->account->select("id=$to")) {
			throw new Exception("Account $to does not exist");
		}

		$this->widraw_money($money);
		$to_account["balance"] += $money;
		$this->database->account->update(
			"balance=".$to_account["balance"], "id=$to");
	}

	public function total_balance(){

	}
}
?>