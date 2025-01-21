<?php
session_start();
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php')

?>

<!DOCTYPE html>
<html>
<head>
	<title>Template Utama</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
<div id="wrapper">

	<div id="header">
		<?php
		include ('header.php');
		?>
	</div>

	<div id="menu">
		<?php
		include ('menu.php');
		?>
	</div>

	<div id="main">
	<center>
	<h1>Template Page Here</h1>
	</center>
	</div>


	<div id="footer">
			<?php
		include ('footer.php');
		?>
	</div>
</div>

</body>
</html>