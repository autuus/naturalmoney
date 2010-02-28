<?php
class publical {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    }

    function money_in_circulation()
    {
        $account = $this->recursion->database->account->select_all();
        foreach ($account as $key => $value) {
            $money += $value["balance"];
        }
        $accounts = $this->recursion->database->note->select_all();
        foreach ($account as $key => $value) {
            $money += $value["money"];
        }
        return $money;
    }

    function tax_all()
    {
        $accounts = $this->recursion->database->account->select_all();
    	$overall_taxed = 0;
        foreach ($account as $key => $value) {

        	// skip government account
        	if ($value["id"] == 1) {
        		continue;
        	}

            $money = $value["balance"];
        	$tax = $money * $recursion->tax_percent * 0.01;

        	// rounding up with ceil, that cant handle double
        	$tax *= 100;
        	$tax = ceil($tax);
        	$tax *= 0.01;

        	echo "Account ".$value["id"]." with balance ".$value["balance"]." paid $tax<br>";

        	$value["balance"] -= $tax;
        	$overall_taxed += $tax;


        	$this->recursion->database->account->update(
        		"balance=".$value["balance"], "id=".$value["id"]);

            $this->recursion->database->accountlog->insert(
                array("money" => "- $tax", "comment" => "Vero", "account" => $value["id"]));
        }
        $note = $this->recursion->database->note->select_all();
    	foreach ($note as $key => $value) {

    		$money = $value["money"];
    		$tax = $money * $recursion->tax_percent * 0.01;

    		// rounding up with ceil, that cant handle double
    		$tax *= 100;
    		$tax = ceil($tax);
    		$tax *= 0.01;

    		echo "Note ".$value["id"]." of value ".$value["money"]." paid $tax<br>";

    		$value["money"] -= $tax;
    		$overall_taxed += $tax;

    		$this->recursion->database->note->update(
    			"money=".$value["money"], "id=".$value["id"]);
    	}

    	$government = $this->recursion->database->account->select("id=1");
    	$government["balance"] += $overall_taxed;
    	$this->recursion->update("balance=".$government["balance"], "id=1");

    	$this->recursion->database->accountlog->insert(
    	    array("money" => "+ $overall_taxed", "comment" => "Vero tulot", "account" => 1));
        return true;
    }

    function show_log($arg1 = false, $arg2 = false)
    {
        if (!$arg1 && !$arg2) {
            $log = $this->recursion->database->accountlog->select_all(
                "account=1 ORDER BY creation DESC");
        }
        if ($arg1 && !$arg2) {
            $log = $this->recursion->database->accountlog->select(
                "id=$arg1 AND account=1");
        }

        return $log;
    }
}

$recursion->publical = new publical($recursion);

?>