<?php
if ($person)
    extract($person);
?>

<form method=POST action="?action=edit">
<table>
<tr><td>&nbsp;</td><td>Sinun on annettava nykyinen salasanasi jotta voit tallentaa</td></tr>
<tr><td>Salasana</td><td><input type="password" value="" name="password"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Käyttäjänimi</td><td><?php echo $details["username"]; ?></td></tr>
<tr><td>Email</td><td><input type="text" value="<?php echo $details["email"]; ?>" name="edit[email]"><br></td></tr>
<tr><td>Uusi salasana</td><td><input type="password" value="" name="edit[password]"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Koko nimi</td><td>
<?php
if (!$person)
{
    echo "<input type=\"text\" name=\"edit[name]\">";
}   else
    echo $name; ?>
</td></tr>
<tr><td>Posti osoite</td><td><input type="text" value="<?php echo $address; ?>" name="edit[address]"></td></tr>
<input type="hidden" value="Finland" name="edit[country]">
<?php
if (!$person)
{
    echo "<tr><td>Sosiaaliturva<br>tunnus</td><td><input type=\"text\" name=\"edit[social_security_number]\"></td></tr>";
}
?>
<tr><td>Puhelin numero</td><td><input type="text" value="<?php echo $phone; ?>" name="edit[phone]"></td></tr>
<tr><td><input type="submit" value="Tallenna"></td><td>
Jos haluat muuttaa asetuksia, mitä tässä ei voi muuttaa, ota yhteyttä asiakas palveluun
0415370389 tai droppenk@gmail.com</td></tr>
</table>

</form>