<?php
include("curl.php");
for ($i = 0; $i < count($_GET["args"]); $i ++)
{
	if (strlen($_GET["args"][$i]) != 0) {
		$args[] = $_GET["args"][$i];
	}
}
echo send_request($_GET["call"], $args);
?>
<form method=GET action="">
<input type="text" name="call" value="<?php echo $_GET["call"] ?>">
<input type="text" name="args[]" value="<?php echo $_GET["args"][0] ?>">
<input type="text" name="args[]" value="<?php echo $_GET["args"][1] ?>">
<input type="text" name="args[]" value="<?php echo $_GET["args"][2] ?>">
<input type="text" name="args[]" value="<?php echo $_GET["args"][3] ?>">
<input type="submit" value="test">