<p><font size=+2>Rahaa kierossa yhteens&auml; <?php echo $recursion->publical->money_in_circulation() ?>mk</font></p>
<a href="?page=info">Pelis&auml;&auml;nn&ouml;t</a><br><br><font size=+1>Valtion tulot ja menot</font><br><br>
<?php
$publiclog = $recursion->publical->show_log();
echo "<table>";
echo "<tr><td>P‰iv‰m‰‰r‰</td><td>Rahasumma</td><td>Viesti";
foreach ($publiclog as $key=>$value)
{
	echo "<tr><td>".$value["creation"]."</td>";
	echo "<td bgcolor=\"lightblue\">".$value["money"]."</td>";
	echo "<td>".$value["comment"]."</td></tr>";
}
echo "</table>"
?>
