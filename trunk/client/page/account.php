<?php
$page = "money";
if ($_GET["action"] == "payment") {
	$page = "payment";
}
if ($_GET["action"] == "notes") {
	$page = "notes";
}
if ($_GET["action"] == "accountlog") {
	$page = "accountlog";
}
if ($_GET["page"] == "info") {
	$page = "../info";
}
if ($_GET["page"] == "public") {
	$page = "../public";
}
?>
<table>
<tr><td valign="top" width="130px">
<a href="?">Oma tili</a><br>
<a href="?action=payment">Uusi maksu</a><br>
<a href="?action=notes">Setelit</a><br><br>
<a href="?page=public">Tarkastele yleisi&auml; tilastoja</a></a><br><br>
<a href="?action=logout"><< Kirjaudu ulos</a></a>
</td><td valign="top" width="400px">
<?php include("account/$page.php"); ?>
</td></tr>
</table>