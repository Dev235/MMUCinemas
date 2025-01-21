<?php
error_reporting(0);
session_start();

require_once('connection.php');

//connect to database
include('keselamatan.php');

if(isset($_POST['update_btn'])){
  $hallID = $_POST['hallID'];
  $hall = $_POST['hallName'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE hall SET hallName = ? WHERE hallID = ?");
  $stmt->bind_param("si", $hall, $hallID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=hall_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=hall_list.php');
  }

  $stmt->close();
} else {
  $hallID = $_GET['hallID'];
  $stmt = $conn->prepare("SELECT * FROM hall WHERE hallID = ?");
  $stmt->bind_param("i", $hallID);
  $stmt->execute();
  $data = $stmt->get_result();
  $row = $data->fetch_assoc();

  // Check if the query returned any results
  if ($row) {
    $hallID = $row['hallID'];
    $hallName = $row['hallName'];
  } else {
    $hallID = '';
    $hallName = '';
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Form</title>
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
  <h1>Hall Update Form</h1>
     <div id="borang">
        <form align="center" action="hall_update.php" method="POST">
          <table>
            <tr>
                <td>Hall ID</td>
                <td><input readonly type="text" name="hallID" value="<?php echo htmlspecialchars($hallID); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Hall Name</td>
                <td><input type="text" name="hallName" value="<?php echo htmlspecialchars($hallName); ?>"></td>
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
