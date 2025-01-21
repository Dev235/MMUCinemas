<?php
session_start();

require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hall Registration Form</title>
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
    <h1>Hall Registration Form</h1>
     <div id="borang">
        <form align="center" action="hall_add.php" method="POST">
          <table>
            <tr>
                <td>Hall Name</td>
                <td><input type="text" name="Hall" placeholder="Enter Hall Name"></td>
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
    $HallName = $_POST['Hall'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO hall (hallID, hallName) VALUES (null, ?)");
    $stmt->bind_param("s", $HallName);
    $result = $stmt->execute();

    if($result){
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url= hall_add.php');
    } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url= hall_add.php');
    }

    $stmt->close();
}
mysqli_close($conn);
?>
