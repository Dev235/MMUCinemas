<?php
session_start();

require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>IP Address Registration Form</title>
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
    <h1>IP Address Registration Form</h1>
     <div id="borang">
        <form align="center" action="ipaddress_add.php" method="POST">
          <table>
            <tr>
                <td>IP Address</td>
                <td><input type="text" name="ipaddress" placeholder="Enter IP Address" required></td>
            </tr>
            <tr>
                <td>Staff ID</td>
                <td><input type="text" name="staffID" placeholder="Enter Staff ID" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Register" value="Enter Details"></td>
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

<?php
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

if(isset($_POST['Register'])){
    //declaring variables
    $ipaddress = $_POST['ipaddress'];
    $staffID = $_POST['staffID'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO ipaddress (ipaddress, staffID) VALUES (?, ?)");
    $stmt->bind_param("ss", $ipaddress, $staffID);
    $result = $stmt->execute();

    if($result){
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url= ipaddress_add.php');
    } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url= ipaddress_add.php');
    }

    $stmt->close();
}
mysqli_close($conn);
?>
