Rahaa kierossa yhteensä <?php echo $public["overall_money"] ?>mk<br>
Hallituksen tilillä <?php echo $public["government_balance"] ?>mk<br>
Käyttäjiä yhteensä <?php echo $public["accounts"]; ?>kpl, joista tunnistautuneita <?php echo $public["full_members"]; ?>kpl<br>
Hallituksen ostovoima <?php echo $public["government_buypower"]; ?> per henkilö<br>
Rahan tasapaino <?php echo $public["equalibrium"]; ?>mk, henkilön paino <?php echo $public["mans_worth"]; ?>mk<br>
Vero prosentti <?php echo $public["tax_percent"]; ?>% / 30 päivää<br>


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