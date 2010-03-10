<?php
if ($note) {
?>
<a href="shownote/shownote.php?<?php echo http_build_query($note); ?>">
<img width=300 height=150 src="shownote/shownote.php?<?php echo http_build_query($note); ?>"></a><br>
<?php
}
?>
<table>
<tr>
<form method="POST" action="?action=notes">
	<td>Summa </td>
	<td><input type="text" name="create_note" size="12"></td>
	<td><input type="submit" value="Luo seteli"></td>
</form>
</tr>
<tr>
	<td>
	&nbsp;
	</td>
</tr>
<tr>
<form method="GET" action="?">
	<td>Koodi </td>
    <input type="hidden" name="action" value="notes" size="12">
	<td><input type="text" name="redeem" size="12"></td>
	<td><input type="submit" value="Lunasta seteli"></td>
</form>
</tr>
<tr>
	<td>
	&nbsp;
	</td>
</tr>
<tr>
<?php
if ($notes) {

foreach ($notes as $key=>$value){

?>
	<td>Seteli </td>
	<td><a href="?action=notes&barcode=<?php echo $value["barcode"];?>"><?php echo $value["money"];?>mk</a></td>
	<td><a href="?action=notes&redeem=<?php echo $value["barcode"];?>">Lunasta</a></td>
</tr>
<?php

}
}
?>
</table>