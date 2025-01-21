<?php
error_reporting(0);
session_start();

require_once('connection.php');

//connect to database
include('keselamatan.php');

if(isset($_POST['update_btn'])){
  $ipaddress = $_POST['ipaddress'];
  $staffID = $_POST['staffID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE ipaddress SET staffID = ? WHERE ipaddress = ?");
  $stmt->bind_param("ss", $staffID, $ipaddress);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=ipaddress_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=ipaddress_list.php');
  }

  $stmt->close();
} else {
  $ipaddress = $_GET['ipaddress'];
  $stmt = $conn->prepare("SELECT * FROM ipaddress WHERE ipaddress = ?");
  $stmt->bind_param("s", $ipaddress);
  $stmt->execute();
  $data = $stmt->get_result();
  $row = $data->fetch_assoc();

  // Check if the query returned any results
  if ($row) {
    $ipaddress = $row['ipaddress'];
    $staffID = $row['staffID'];
  } else {
    $ipaddress = '';
    $staffID = '';
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update IP Address</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
<div id="wrapper">

  <div id="header">
    <?php include('header.php'); ?>
  </div>

  <div id="menu">
    <?php include('menu.php'); ?>
  </div>

  <div id="main">
  <center>
  <h1>IP Address Update Form</h1>
     <div id="borang">
        <form align="center" action="ipaddress_update.php" method="POST">
          <table>
            <tr>
                <td>IP Address</td>
                <td><input readonly type="text" name="ipaddress" value="<?php echo htmlspecialchars($ipaddress); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Staff ID</td>
                <td><input type="text" name="staffID" value="<?php echo htmlspecialchars($staffID); ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="update_btn" value="Enter Details"></td>
            </tr>
          </table>
        </form>
     </div>
  </center>
  </div>

  <div id="footer">
    <?php include('footer.php'); ?>
  </div>
</div>
<script>
  function checkdelete(){
    return confirm('Delete this record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>
</body>
</html>
