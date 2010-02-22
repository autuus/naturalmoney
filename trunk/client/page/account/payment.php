<?php
if ($account_owner) {
extract($_POST);
?>
<form method="POST" action="?action=payment">
<table>
<tr>
	<td>tilinumero</td>
	<td bgcolor="#eeeeee">
		<?php echo $account_id ?>
	</td>
</tr>
<tr>
	<td>saajan nimi</td>
	<td bgcolor="#eeeeee">
		<?php echo $owner_name ?>
	</td>
</tr>
<tr>
	<td>viesti</td>
	<td bgcolor="#eeeeee">
		<?php echo $comment ?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td bgcolor="#eeeeee"></td>
</tr>
<tr>
	<td>summa</td>
	<td bgcolor="#eeeeee">
		<?php echo $money ?>
	</td>
</tr>
<tr>
	<td>
	</td>
	<td bgcolor="#eeeeee">
		<input type="hidden" name="account_id" value="<?php echo $account_id ?>">
		<input type="hidden" name="owner_name" value="<?php echo $account_id ?>">
		<input type="hidden" name="comment" value="<?php echo $comment ?>">
		<input type="hidden" name="money" value="<?php echo $money ?>">
		<input type="submit" value="maksa">
	</td>
</tr>
</table>
</form>
<?php
	} else {
?>
<form method="POST" action="?action=payment">
<table>
<tr><td>tilinumero</td><td><input type="text" name="account_id"></td></tr>
<tr><td>saajan nimi</td><td><input type="text" name="owner_name"></td></tr>
<tr><td>viesti</td><td><textarea name="comment"></textarea></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>summa</td><td><input type="text" name="money"></td></tr>
<tr><td></td><td><input type="submit" value="seuraava"</td></tr>
</table>
</form>
<?php
}
?>