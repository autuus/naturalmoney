<a href="?action=info">K&auml;ytt&ouml;ehdot</a>
<br><br>
<form method=POST action="?action=register">
<table>
<tr><td>Email</td><td><input type="text" value="" name="register[email]"><font color="red">*</font><br></td></tr>
<tr><td>K&auml;ytt&auml;j&auml;nimi</td><td><input type="text" value="" name="register[username]"><font color="red">*</font></td></tr>
<tr><td>Salasana</td><td><input type="password" value="" name="register[password]"><font color="red">*</font></td></tr>
<tr><td>Koko nimi</td><td><input type="text" name="register[name]"></td></tr>
<tr><td>Posti osoite</td><td><input type="text" name="register[address]"></td></tr>
<!-- tr><td>maa</td><td><input type="text" value="Suomi" name="register[country]"></td></tr -->
<input type="hidden" value="Finland" name="register[country]">
<!-- tr><td>syntym&auml; aika</td><td><input type="text" value="" name="register[birthdate]"></td></tr -->
<tr><td>Sosiaaliturva<br>tunnus</td><td><input type="text" value="" name="register[social_security_number]"></td></tr>
<tr><td>Puhelin numero</td><td><input type="text" value="" name="register[phone]"></td></tr>
</table>
<br>Vain <font color="red">*</font>ll&auml; merkityt ovat pakollisia kohtia, mutta jos<br>
haluat &auml;&auml;nestysoikeudet, sinun on t&auml;ytett&auml;v&auml; kaikki kohdat.<br><br>
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