<?php
class publical {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    }

    function money_in_circulation()
    {
        $accounts = $this->recursion->database->account->select_all();
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
        foreach ($account as $key => $value) {
            $money = $value["balance"];
            $money *= $recursion->settings->tax_percent;

            $this->recursion->database->accountlog->insert(
                array("money" => "+$money", "comment" => "Vero", "account" => $value["id"]));
        }
        $accounts = $this->recursion->database->note->select_all();
        foreach ($account as $key => $value) {
            $money += $value["money"];
        }
        return $money;
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