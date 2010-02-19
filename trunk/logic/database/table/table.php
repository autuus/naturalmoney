<?php

class table
{
	function __construct($recursion, $table){
		$this->table = $table;
		$this->recursion = $recursion;
	}

	function select($where = 1){
		$this->stringify($where);

		$query = "SELECT * FROM ".$this->table." WHERE $where";
		return mysql_fetch_assoc($this->recursion->database->query($query));
	}


	function insert($values)
	{
		foreach ($values as $key => $value) {
			$cols .= "$key,";
			$vals .= "'$value',";
		}
		$cols = substr($cols, 0, - 1);
		$vals = substr($vals, 0, - 1);

		$query = "INSERT INTO ".$this->table." ($cols) VALUES ($vals)";
		$this->log();
		return $this->recursion->database->query($query);
	}


	function update($how, $where = 1){
		$how = $this->stringify($how);
		$where = $this->stringify($where);

		$query = "UPDATE ".$this->table." SET $how WHERE $where";
		$this->log();
		return $this->recursion->database->query($query);
	}

	function delete($where)
	{
		$where = $this->stringify($where);

		$query = "DELETE FROM ".$this->table." WHERE $where";
		$this->log();
		return $this->recursion->database->query($query);
	}

	function stringify($array)
	{
		if (gettype($array) == "array") {
			foreach($array as $key => $value) {
				if ($value == "NOW()")
					$line .= "$key = $value,";
				else
					$line .= "$key = '$value',";
			}
			// delete the last ,
			return substr($line, 0, - 1);
		}
		return $array;
	}


	function log(){

		// We can figure out practically everything worth logging with debug_backtrace
		$debug_backtrace = debug_backtrace();

		// what change did the table get
		$table.= $this->table."->".$debug_backtrace[1]["function"];
		$table.= "(".$this->stringify($debug_backtrace[1]["args"][0]).")";
		if ($debug_backtrace[1]["args"][1]) {
			$table.= "(".$this->stringify($debug_backtrace[1]["args"][1]).")";
		}

		// where did it come from and what did it get?
		$call.= $debug_backtrace[2]["class"]."->";
		$call.= $debug_backtrace[2]["function"];
		if ($debug_backtrace[2]["args"][0]) {
			$call.= "(".$this->stringify($debug_backtrace[2]["args"][0]).")";
		}
		if ($debug_backtrace[2]["args"][1]) {
			$call.= "(".$this->stringify($debug_backtrace[2]["args"][1]).")";
		}

		// witch user is logged on now.
		$login = $_SESSION["login"];

		$query = "INSERT INTO log (login, table, call) VALUES ('$login','".
			str_replace("'", "", $table)."','".str_replace("'", "", $call)."')";

		$this->recursion->database->query($query);
	}
}

?>