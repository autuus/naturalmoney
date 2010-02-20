<?php
include("curl.php");
echo send_request($_GET["call"], $_POST);
?>

<style type="text/css">
.center {
  position: absolute;
  width: 60%;
  height: 30%;
  left: 20%;
  top: 35%;
}
</style>
<div align="center" style="position: absolute; left: 40%;top: 40%;">
<?php include("page/page_".str_replace(".", "", $_GET["page"]).".php"); ?>
<a href="?page=register">rekister&ouml;idy</button>
</div>