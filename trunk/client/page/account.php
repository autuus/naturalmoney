<?php
$page = "money";
if ($_GET["action"] == "payment") {
	$page = "payment";
}
?>
<table>
<tr><td valign="top" width="130px">
<a href="?">oma tili</a><br>
<a href="?action=payment">uusi maksu</a><br><br>
<a href="#">setelit</a><br>
<a href="#">>> luo seteli</a><br>
<a href="#">>> talleta seteli</a><br><br>
<a href="#">tarkastele yleisi&auml; tilastoja</a></a><br><br>
<a href="?action=logout"><< kirjaudu ulos</a></a>
</td><td valign="top">
<?php include("account/$page.php"); ?>
</td></tr>
</table>