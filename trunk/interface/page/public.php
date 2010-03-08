<p><font size=+2>Rahaa kierossa yhteens&auml; <?php echo $money_in_circulation ?>mk</font></p>
<p>Käyttäjiä yhteensä <?php echo $user_count; ?>kpl</p>
<a href="?action=info">Pelis&auml;&auml;nn&ouml;t</a><br><br><font size=+1>Valtion tulot ja menot</font><br><br>
<?php
echo "<table>";
echo "<tr><td>Päivämäärä</td><td>Rahasumma</td><td>Viesti</td>";
if ($public_account_log) {
    foreach ($public_account_log as $key => $value) {
        echo "<tr><td>" . $value["creation"] . "</td>";
        echo "<td bgcolor=\"lightblue\">" . $value["money"] . "</td>";
        echo "<td>" . $value["comment"] . "</td></tr>";
    }
}
echo "</table>"
?>