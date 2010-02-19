<?php
include("note/note.php");

class account{

	function __construct($recursion, $account){
		$this->recursion = $recursion;
		$this->details = $account;
		$this->note = new note($recursion);
	}

	function widraw_money($money){
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

	function deposit_money($money){
		if ($money < 0.01) {
			throw new Exception("Invalid amount");
		}
		$this->details["balance"] += $money;
		$this->database->account->update(
			"balance=".$this->details["balance"], "id=".$this->details["id"]);
	}

	function pay($money, $to, $note){
		if (!$to_account = $this->recursion->database->account->select("id=$to")) {
			throw new Exception("Account $to does not exist");
		}

		$this->widraw_money($money);
		$to_account["balance"] += $money;
		$this->database->account->update(
			"balance=".$to_account["balance"], "id=$to");
	}

	function total_balance(){

	}

	/* Lendsystem will be discarded until later. because its not in tune with
	   simplicity.
	function lend($money, $to){
		if ($to) {
			if (!$this->recursion->database->account->select("id=$to")) {
				throw new Exception("Account $to does not exist");
			}
		}
		$this->widraw_money($money);

		$this->recursion->database->lend->insert(array(
			"to" => $to,
			"from" => $this->details["id"],
			"money" => $money));
	}

	function accept_lend($lend_id){
		if (!$lend = $this->recursion->database->lend->select("id=$lend_id")) {
			throw new Exception("Lend $lend_id does not exist");
		}
		if ($lend["to"] == $this->details["id"] || !$lend["to"]) {
			$this->deposit_money($lend["money"]);
			$this->recursion->database->lend->delete("id=".$lend["id"]);
		}
	}*/
}
?>