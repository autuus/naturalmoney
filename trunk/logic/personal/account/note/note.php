<?php
class note{
	function __construct($recursion, $account_id){
		$this->recursion = $recursion;
		$this->account_id = $account_id;
	}

	public function create($money){
		$this->recursion->personal->account->widraw_money($money);

		$this->recursion->database->accountlog->insert(
			array("money"=>"-$money", "comment"=>"Käteis nosto", "account"=>$this->account_id));

		do {
			$barcode = $this->generate_barcode();
		} while ($this->recursion->database->note->select("barcode='$barcode'"));

		$note = array(
			"account" => $this->account_id,
			"barcode" => $barcode,
			"money" => $money
		);
		$this->recursion->database->note->insert($note);
		$new_note = $this->recursion->database->note->select($note);

		return $new_note;
	}

	function redeem($barcode){
		if (!$note = $this->recursion->database->note->select("barcode='".$barcode."'")) {
			// Trace the note.
			throw new Exception("Viivakoodi ei kelpaa.");
		}
		$balance = $note["money"] + $this->recursion->personal->account->details["balance"];
		$this->recursion->database->account->update("balance='$balance'", "id=".$this->account_id);
		$this->recursion->database->accountlog->insert(
			array("money"=>"+".$note["money"], "comment"=>"Rahan talletus", "account"=>$this->account_id));

		$this->recursion->database->note->delete("id=".$note["id"]);
	}

	function generate_barcode(){
		// generate a random 11 digit number
		while (strlen($digits) < 11) {
			$digits = $digits.rand(0,9);
		}

		// Calculation of the check digit
		// UPC-A barcode "03600029145X" where X is the check digit, X can be calculated by
		// adding the odd-numbered digits (0 + 6 + 0 + 2 + 1 + 5 = 14),
		$X = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
		// multiplying by three (14 × 3 = 42)
		$X *= 3;
		// adding the even-numbered digits (42 + (3 + 0 + 0 + 9 + 4) = 58)
		$X += $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9};
		// calculating modulo ten (58 mod 10 = 8)
		$X = substr($X, -1); // only the last digit of the number
		// subtracting from ten (10 - 8 = 2).
		if ($X != 0) {
			$X = 10 - $X;
		}

		return $digits.$X;
	}

	function get_notes()
	{
		return $this->recursion->database->note->select_all(
			"account=".$this->account_id);
	}
}
?>