<?php
class one{
function __toString(){
	return "onestring";
}
}
$one = new one;
class two
{
	public $one;

	public function __construct($one) {
		$this->one = $one;
	}

	function lol(){
		return "lol";
	}

	public function __toString() {
		print_r($this->one);
		return "".$this->one->two->lol();
	}
}

$one->two = new two($one);
echo $one->two;
?>