<?php
extract($accountlog);
?>
<table>
<tr>
	<td>Raha</td>
	<td bgcolor="#eeeeee">
		<?php echo $money ?>
	</td>
</tr>
<tr>
	<td>Viesti</td>
	<td bgcolor="#eeeeee">
		<?php echo $comment ?>
	</td>
</tr>
<tr>
	<td>Ajankohta</td>
	<td bgcolor="#eeeeee">
		<?php echo $creation ?>
	</td>
</tr>
</table>