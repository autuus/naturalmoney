<?php
include("table/table.php");

class database {
    function __construct($recursion)
    {
        $this->connection = mysql_connect($recursion->mysql_host,
        	$recursion->mysql_username, $recursion->mysql_password);
    	$database = $recursion->mysql_database;
        mysql_select_db($database, $this->connection);

    	$result = $this->query("SHOW TABLES FROM $database");
    	while($table = mysql_fetch_assoc($result))
    	{
    		$table = $table["Tables_in_naturalmoney"];
    		$this->$table = new table($recursion, $table);
    	}
    }


    function query($query)
    {
        $result = mysql_query($query, $this->connection);
        if (!$result) {
            throw new Exception("Mysql error: $query");
        }
        return $result;
    }
}

$recursion->database = new database($recursion);

?>