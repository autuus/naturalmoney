<table><tr><td><font size="-1">Tilinumero:
<?php echo $details["account_id"]; ?>
</font>
<th rowspan=2><font size="+4">
<?php echo $details["balance"]; ?> mk</font></th>
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
$color = 14;
if ($account_log) {
    foreach ($account_log as $key => $value) {
        $color --;
        /*
		if ($color == 0) {
			echo "
<tr bgcolor=\"#".dechex($color).dechex($color).dechex($color)."\" align=\"right\">
	<td></td><td><a href=\"#\">Lisنن</a></td>
</tr>";
			break;
		   bgcolor=\"#".dechex($color).dechex($color).dechex($color)."\"
	}*/
        echo "
<tr align=\"right\">
	<td><a href=\"?action=accountlog&id=" . $value["id"] . "\">" . $value["creation"] . "</a></td><td><font size=\"+1\">" . $value["money"] . "</font></td>
</tr>";
    }
}

?>
</table>