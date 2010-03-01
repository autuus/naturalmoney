<table><tr><td><font size="-1">Tilinumero:
<?php print_r($recursion->personal->account->details["id"]); ?></font>
<th rowspan=2><font size="+4">
<?php print_r($recursion->personal->account->details["balance"]); ?> mk</font></TH>
</td></tr><tr><td>
<font size="+2">Rahaa tilill&auml;</font>&nbsp;
</td></tr>
<?php
	$log = $recursion->personal->account->show_log();
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