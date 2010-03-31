<?php
$_SESSION["session_id"] = rand(1,10000);
?>
<br>
<br>
<br>
<br>
<form method=POST action="?action=login">
<input type="hidden" name="session_id" value="<?php echo $_SESSION["session_id"] ?>">
<input type="text" name="username"><br>
<input type="password" name="password"><br>
<input type="submit" value="Kirjaudu sisään"><br><br>
</form>