<?php
include("../server/main.php");
print_r($_GET);
if ($_GET["page"] == "register") {
	$page = "register";
	echo "page/page_$page.php";
}
elseif ($recursion->personal->logged_in()) {
}
?>

<style type="text/css">
.center {
  position: absolute;
  width: 60%;
  height: 30%;
  left: 20%;
  top: 20%;
}
</style>
<div align="center" style="position: absolute; left: 30%;top: 30%;">
<font color="red"><?php echo $return; ?></font><br>
<?php include("page/page_$page.php"); ?>
</div>