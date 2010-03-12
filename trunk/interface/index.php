<?php
// the engine is designed to work without cookies, so sessions are handled here
session_start();
header('Content-Type:text/html; charset=UTF-8');
$_POST["session"] = $_SESSION["session"];
$_POST["payment_permission"] = $_SESSION["payment_permission"];
include("../heart/interface.php");
extract($return);
if ($session) {
	$_SESSION["session"] = $session;
}
$_SESSION["payment_permission"] = false;
if ($redirect) {
	header("Location: $redirect");
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
body {
	font-family:"Arial",Georgia,Serif;
}
A:link {text-decoration: none; color: blue;}
A:visited {text-decoration: none; color: blue;}
A:active {text-decoration: none; color: blue;}
A:hover {text-decoration: none; color: orange;}
table {border-width: 0px; border-spacing: 0;}
p1 {
    font-size:20px;
    font-weight:bold;
}
p {
    font-size:11px;;
}
</style>
</head>
<body>
<div align="center" style="position: absolute; left: 10%;top: 10%; width: 80%">
<font size=-1>Rahajärjestelmä on toistaiseksi testikäyt&ouml;ssä</font><br>
<font color="red"><?php echo $error; ?></font><br>
<?php
if ($logged_in)
	include("logged_in.php");
else
	include("page/$page.php"); ?>
</div>
</body>
</html>