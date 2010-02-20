<?php

class database {
    function __construct($recursion)
    {
        $this->connection = mysql_connect($recursion->settings->mysql_host,
        	$recursion->settings->mysql_username, $recursion->settings->mysql_password);
    	$database = $recursion->settings->mysql_database;
        mysql_select_db($database, $this->connection);

    	include("table/table.php");
    	$this->tables = mysql_fetch_assoc($this->query("SHOW TABLES FROM $database"));
    	foreach($this->tables as $table)
    	{
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


?>