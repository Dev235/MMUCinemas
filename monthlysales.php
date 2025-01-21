<?php
session_start();
include('keselamatan.php');
require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sales Report</title>
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
	<h1>Monthly Sales Report</h1>
     <div id= "borang">
        <form align= "center" action="monthlysalesprint.php" method="POST" enctype="multipart/form-data">
      <tr><b><p style="color:Black; text-decoration:underline;">Monthly Sales<p></b></tr>
        <th><select style="padding: 5px;" name="month" id="month">
					<option value="-">-</option>
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select></th>
      </tr>
			<tr>
				<th><input type="submit" name="Register" value=" Enter the month"></th>
			</tr>
         </table>
       </form>
     </div>
	</center>
	</div>


	<div id="footer">
			<?php
		include ('footer.php');
		?>
	</div>
</div>

</body>
<script>
  function checkdelete(){
    return confirm('Delete this Record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>
</html>
