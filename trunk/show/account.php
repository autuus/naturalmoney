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
if ($_GET["action"] == "info") {
	$page = "../info";
}
if ($_GET["action"] == "public") {
	$page = "../public";
}
if ($_GET["action"] == "tax") {
	$page = "../tax";
}
?>
<table>
<tr><td valign="top" width="130px">
<a href="?">Oma tili</a><br>
<a href="?action=payment">Uusi maksu</a><br>
<a href="?action=notes">Setelit</a><br><br>
<a href="?action=public">Tarkastele yleisi&auml; tilastoja</a></a><br><br>
<font size=-1 color="gray">Kirjautuneena <br></font><font size=-1>
<?php echo $recursion->personal->details["name"]; ?><br></font>
<a href="?action=logout"><< Kirjaudu ulos</a></a><br>
</td><td valign="top" width="500px">
<?php include("account/$page.php"); ?>
</td></tr>
</table>