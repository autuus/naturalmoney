<?php
if ($barcode) {
?>
<a href="?action=shownote&barcode=<?php echo $barcode; ?>">
<img width=300 height=150 src="?action=shownote&barcode=<?php echo $barcode; ?>"></a><br>
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
<form method="POST" action="?action=notes">
	<td>Koodi </td>
	<td><input type="text" name="deposit_note" size="12"></td>
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
$notes = $recursion->personal->account->note->get_notes();
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