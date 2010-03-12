<?php
class publical {
    function __construct($recursion)
    {
        $this->recursion = $recursion;
    }

    function gather_information()
    {
        $array["government_buypower"] = $this->recursion->government_buypower;
        $array["equalibrium"] = $this->recursion->equalibrium;
        $array["accounts"] = count($this->recursion->database->account->select_all());
        $array["full_members"] = count($this->recursion->database->person->select_all("full_member=1"));
        $array["mans_worth"] = $this->recursion->equalibrium +
                                            $this->recursion->equalibrium *
                                            $this->recursion->government_buypower;
        $array["tax_percent"] = ((1 / $array["mans_worth"]) +
                                            ((1 / $array["mans_worth"]) * $this->government_buypower)) *  30 * 100;
        $gvt = $this->recursion->database->account->select("id=1");
        $array["government_balance"] = $gvt["balance"];
        $array["overall_money"] = $array["mans_worth"] * $array["full_members"];
        return $array;
    }

    function day_tax_check()
    {
        $date = date ("Y-m-d");
        if (!$this->recursion->database->heartbeat->select("date='$date'")) {
            $log = $this->day_tax();
            $this->recursion->database->heartbeat->insert(array(
                    "date" => $date,
                    "log" => $log));
        }
    }

    function normalize($number)
    {
        $number *= 100;
        $number = floor($number);
        $number *= 0.01;
        return $number;
    }

    function day_tax()
    {
        $mans_worth = $this->recursion->equalibrium + $this->recursion->equalibrium * $this->recursion->government_buypower;
        $account = $this->recursion->database->account->select_all();
        $member_count = 0;
        foreach ($account as $key => $value) {
            // skip government account
            if ($value["id"] == 1) {
                continue;
            }
            $out .= "account " . $value["id"] . " has " . $value["balance"];

            $full_member = false;
            if ($value["person"]) {
                $person = $this->recursion->database->person->select("id=" . $value["person"]);
                if ($person["full_member"]) {
                    $full_member = true;
                    $member_count ++;
                }
            }
            // man's share on government tax
            $tax = $value["balance"] * ((1 / $mans_worth) * $this->government_buypower);
            $tax += $value["balance"] * (1 / $mans_worth); // man's share in sharing the wealth
            $value["balance"] -= $tax;
            if ($full_member)
                $value["balance"] += 1;

            $value["balance"] = $this->normalize($value["balance"]);

            $this->recursion->database->account->update(
                "balance=" . $value["balance"], "id=" . $value["id"]);

            $out .= " left with " . $value["balance"] . " is member? " . $full_member . "<br>\n";

            $overall_money += $value["balance"];
        }
        $out .= "<br>\n<br>\n";
        $note = $this->recursion->database->note->select_all();
        if ($note) {
            foreach ($note as $key => $value) {
                $out .= "note " . $value["id"] . " with " . $value["money"];
                // man's share on government tax
                $tax = $value["money"] * ((1 / $mans_worth) * $this->government_buypower);
                $tax += $value["money"] * (1 / $mans_worth); // man's share in sharing the wealth
                $value["money"] -= $tax;

                $value["money"] = $this->normalize($value["money"]);

                $this->recursion->database->note->update(
                    "money=" . $value["money"], "id=" . $value["id"]);

                $out .= " left with " . $value["money"] . "<br>\n";

                $overall_money += $value["money"];
            }
        }
        // government funds is the shadow that the economy casts
        $government_balance = $member_count * $mans_worth;
        $government_balance -= $overall_money;
        $government_balance = round($government_balance, 2);

        $out .= "<br>\n<br>\n<br>\n";
        $out .= "mans worth $mans_worth, members $member_count, overall money $overall_money<br>\n";
        $out .= "government balance $government_balance";

        $this->recursion->database->account->update("balance=" . $government_balance, "id=1");

        return $out;
    }

    function register($array)
    {
        if ($person = $this->recursion->database->account->select(
                "username='" . $array["username"] . "'")) {
            throw new Exception("Käyttäjänimi on jo käytössä");
        }
        if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $array["email"])) {
            throw new Exception("Sähköpostiosoite in virheellinen");
        }
        if ($person = $this->recursion->database->account->select(
                "email='" . $array["email"] . "'")) {
            throw new Exception("Sähköposti osoite on jo käytössä");
        }

        $person["name"] = $array["name"];
        $person["address"] = $array["address"];
        $person["country"] = $array["country"];
        $person["phone"] = $array["phone"];
        $person["social_security_number"] = $array["social_security_number"];

        if ($person["social_security_number"]) {
            if ($this->recursion->database->person->select("social_security_number='" . $array["social_security_number"] . "'")) {
                throw new Exception("Sosiaaliturvatunnus on jo käytössä, jos epäilette henkilöllisyys rikosta, soittakaa asiakaspalveluun.");
            }

            if (!$this->recursion->database->person->insert($person)) {
                throw new Exception("Tietokantavirhe, henkilöä ei luotu");
            }

            $new_person = $this->recursion->database->person->select(
                "social_security_number='" . $person["social_security_number"] . "'");

            $account["person"] = $new_person["id"];
        }

        $account["email"] = $array["email"];
        $account["username"] = $array["username"];
        $account["password"] = md5($array["password"]);

        $this->recursion->database->account->insert($account);
        return true;
    }

    function show_log_by_date($from = false, $to = false)
    {
        // explode and count the numbers to see if the syntax is correct
        if (count($from = explode("-", $from)) == 3) {
            if (!is_numeric($from[2]) || !is_numeric($from[1]) || !is_numeric($from[0])) {
                $from = time();
            } else
                $from = mktime(23, 59, 59, $from[1], $from[2], $from[0]);
        } else {
            $from = time();
        }

        if (count($to = explode("-", $to)) == 3) {
            if (!is_numeric($to[2]) || !is_numeric($to[1]) || !is_numeric($to[0])) {
                $to = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
            } else
                $to = mktime(0, 0, 0, $to[1], $to[2], $to[0]);
        } else {
            $to = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
        }

        if ($to > $from) {
            $select = "account=1 AND creation > FROM_UNIXTIME($from) AND creation < FROM_UNIXTIME($to) ORDER BY creation DESC";
        } else
            $select = "account=1 AND creation < FROM_UNIXTIME($from) AND creation > FROM_UNIXTIME($to) ORDER BY creation DESC";
        return $this->recursion->database->accountlog->select_all($select);
    }
}

$recursion->publical = new publical($recursion);

?>