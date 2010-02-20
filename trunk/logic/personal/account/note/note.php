<?php
class note{
	function __construct($recursion){
		$this->recursion = $recursion;
	}

	public function create($money){
		$this->recursion->personal->account->widraw_money($money);

		do {
			$barcode = $this->generate_barcode();
		} while ($this->recursion->database->note->select("barcode=$barcode"));

		$note = array(
			"account" => $this->recursion->personal->account->details["id"],
			"barcode" => $barcode,
			"money" => $money
		);
		$this->recursion->database->note->insert($note);

		$new_note = $this->recursion->database->note->select("barcode=$barcode");
		return $new_note;
	}

	public function delete($id){
		if (!$note = $this->recursion->database->note->select("id=$id"))
		{
			throw new Exception("Note $id does not exist");
		}
		$this->recursion->database->note->delete("id=$id");

	}

	public function redeem($barcode){
		if (!$note = $this->recursion->database->note->select("barcode=".$barcode)) {
			// Trace the note.
			throw new Exception("This note $barcode was not found.");
		}
		$this->recursion->personal->account->deposit_money($note["money"]);
		$this->delete($note["id"]);
	}

	private function generate_barcode(){
		// generate a random 11 digit number
		$digits = rand(1, 99999999999);

		// add zeros to missing digits
		while (strlen($digits) < 11) {
			$digits = "0".$digits;
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
		$X = 10 - $X;

		$digits = $digits.$X;
	}
}
?>