<?php
extract($_POST);
if ($_POST["money"] && !$_POST["payment_permission"]) {
$_SESSION["payment_permission"] = true;
?>
<form method="POST" action="?action=payment">
<table>
<tr>
	<td>Tilinumero</td>
	<td bgcolor="#eeeeee">
		<?php echo $account_code ?>
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
		<input type="hidden" name="account_code" value="<?php echo $account_code ?>">
		<input type="hidden" name="comment" value="<?php echo $comment ?>">
		<input type="hidden" name="money" value="<?php echo $money ?>">
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
<tr><td>Tilinumero</td><td><input type="text" name="account_code" value="<?php echo $account_code ?>"></td></tr>
<tr><td>Viesti</td><td><textarea name="comment"><?php echo $comment ?></textarea></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Summa</td><td><input type="text" name="money" value="<?php echo $money ?>"></td></tr>
<tr><td></td><td><input type="submit" value="Seuraava"</td></tr>
</table>
</form>
<?php
}
?>