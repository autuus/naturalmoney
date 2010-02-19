<?php
class publical{
	function __construct($recursion){
		$this->recursion = $recursion;
	}

}

$recursion->publical = new publical($recursion);
?>