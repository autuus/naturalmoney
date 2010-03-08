<?php
extract($_POST);
if ($_POST && $validate_payment) {
?>
<form method="POST" action="?action=payment">
<table>
<tr>
	<td>Tilinumero</td>
	<td bgcolor="#eeeeee">
		<?php echo $account_id ?>
	</td>
</tr>
<tr>
	<td>Saajan nimi</td>
	<td bgcolor="#eeeeee">
		<?php echo $account_owner ?>
	</td>
</tr>
<tr>
	<td>Viesti</td>
	<td bgcolor="#eeeeee">
		<?php echo $comment ?>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td bgcolor="#eeeeee"></td>
</tr>
<tr>
	<td>Summa</td>
	<td bgcolor="#eeeeee">
		<?php echo $money ?>
	</td>
</tr>
<tr>
	<td>
	</td>
	<td bgcolor="#eeeeee">
		<input type="hidden" name="account_id" value="<?php echo $account_id ?>">
		<input type="hidden" name="account_owner" value="<?php echo $account_owner ?>">
		<input type="hidden" name="comment" value="<?php echo $comment ?>">
		<input type="hidden" name="money" value="<?php echo $money ?>">
		<input type="hidden" name="permission" value="true">
		<input type="submit" value="Maksa">
	</td>
</tr>
</table>
</form>
<?php
	} else {
?>
<form method="POST" action="?action=payment">
<table>
<tr><td>Tilinumero</td><td><input type="text" name="account_id" value="<?php echo $account_id ?>"></td></tr>
<tr><td>Saajan nimi</td><td><input type="text" name="account_owner" value="<?php echo $account_owner ?>"></td></tr>
<tr><td>Viesti</td><td><textarea name="comment"><?php echo $comment ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Summa</td><td><input type="text" name="money" value="<?php echo $money ?>"></td></tr>
<tr><td></td><td><input type="submit" value="Seuraava"</td></tr>
</table>
</form>
<?php
}
?>