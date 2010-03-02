<table><tr><td><font size="-1">Tilinumero:
<?php print_r($recursion->personal->account->details["id"]); ?>
</font>
<th rowspan=2><font size="+4">
<?php print_r($recursion->personal->account->details["balance"]); ?> mk</font></th>
</td></tr><tr><td>
<font size="+2">Rahaa tilill&auml;</font>&nbsp;
</td></tr>
<tr>
<td>
Tapahtumat ajalta
</td>
<td>
</td>
</tr>
<tr>
<td colspan="2">
<form method="GET" action="">
<input type="text" name="from_date" value="<?php echo $from_date ?>" size=7>
-<input type="text" name="to_date" value="<?php echo $to_date ?>" size=7>
<input type="submit" value="N&auml;yt&auml;">
</form>
</td>
</tr>


<?php
	$log = $recursion->personal->account->show_log_by_date($from_date, $to_date);
	$color = 14;
	if ($log) {

	foreach ($log as $key=>$value){
	$color --;
		/*
		if ($color == 0) {
			echo "
<tr bgcolor=\"#".dechex($color).dechex($color).dechex($color)."\" align=\"right\">
	<td></td><td><a href=\"#\">Lis‰‰</a></td>
</tr>";
			break;
		   bgcolor=\"#".dechex($color).dechex($color).dechex($color)."\"
	}*/
	echo "
<tr align=\"right\">
	<td><a href=\"?action=accountlog&id=".$value["id"]."\">".$value["creation"]."</a></td><td><font size=\"+1\">".$value["money"]."</font></td>
</tr>";
	}
	}
?>
</table>