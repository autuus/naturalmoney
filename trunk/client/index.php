<?php
include("../logic/interface.php");
extract($return);
if ($redirect) {
	header("Location: $redirect");
}
?>

<style type="text/css">
body {
	font-family:"Arial",Georgia,Serif;
}
A:link {text-decoration: none; color: blue;}
A:visited {text-decoration: none; color: blue;}
A:active {text-decoration: none; color: blue;}
A:hover {text-decoration: none; color: orange;}
table {border-width: 0px; border-spacing: 0; }
</style>
<div align="center" style="position: absolute; left: 10%;top: 10%; width: 80%">
<font size=-1>Rahaj&auml;rjestelm&auml; on toistaiseksi testik&auml;yt&ouml;ss&auml;</font><br>
<font color="red"><?php echo $error; ?></font><br>
<?php
if ($logged_in)
	include("logged_in.php");
else
	include("page/$page.php"); ?>
</div>