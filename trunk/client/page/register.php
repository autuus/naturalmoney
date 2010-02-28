<a href="?page=info">K&auml;ytt&ouml;ehdot</a>
<br><br>
<form method=POST action="?action=register">
<table>
<tr><td>nimi</td><td><input type="text" name="args[name]"></td></tr>
<tr><td>osoite</td><td><input type="text" name="args[address]"></td></tr>
<tr><td>maa</td><td><input type="text" value="Suomi" name="args[country]"></td></tr>
<tr><td>syntym&auml; aika</td><td><input type="text" value="01.01.1980" name="args[birthdate]"></td></tr>
<tr><td>sotu</td><td><input type="text" value="010180-185x" name="args[social_security_number]"></td></tr>
<tr><td>email</td><td><input type="text" value="" name="args[email]"><br></td></tr>
<tr><td>k&auml;ytt&auml;j&auml;nimi</td><td><input type="text" value="" name="args[username]"></td></tr>
<tr><td>salasana</td><td><input type="password" value="" name="args[password]"></td></tr>
</table>
<input type="submit" value="Olen lukenut k&auml;ytt&ouml;ehdot, ja hyv&auml;ksyn ne">
</form>

<!--
        $person["name"] = $array["name"];
        $person["address"] = $array["address"];
        $person["country"] = $array["country"];
        $person["birthdate"] = $array["birthdate"];
    	$person["social_security_number"] = $array["social_security_number"];
    	$person["email"] = $array["email"];


        $account["username"] = $array["username"];
        $account["password"] = $array["password"];
--!>