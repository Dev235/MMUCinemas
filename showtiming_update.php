<?php
session_start();
require_once('connection.php');
//connect to database
include('keselamatan.php');

if(isset($_POST['update_btn'])){
  $showtimingID = $_POST['showtimingID'];
  $starttime = $_POST['starttime'];
  $showdate = $_POST['showdate'];

  $formatteddate = date("Y-m-d", strtotime($showdate));
  $formattedtime = date("H:i:s", strtotime($starttime));

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE showtiming SET starttime = ?, showdate = ? WHERE showtimingID = ?");
  $stmt->bind_param("ssi", $formattedtime, $formatteddate, $showtimingID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=showtiming_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=showtiming_list.php');
  }

  $stmt->close();
} else {
  $showtimingID = $_GET['showtimingID'];
  $stmt = $conn->prepare("SELECT * FROM showtiming WHERE showtimingID = ?");
  $stmt->bind_param("i", $showtimingID);
  $stmt->execute();
  $data = $stmt->get_result();
  $row = $data->fetch_assoc();

  // Check if the query returned any results
  if ($row) {
    $showtimingID = $row['showtimingID'];
    $starttime = $row['starttime'];
    $showdate = $row['showdate'];
  } else {
    $showtimingID = '';
    $starttime = '';
    $showdate = '';
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Showtime Update Form</title>
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
  <h1>Showtime Update Form</h1>
     <div id="borang">
        <form align="center" action="" method="POST">
          <table>
            <tr>
                <td>Table ID</td>
                <td><input readonly type="text" name="showtimingID" value="<?php echo htmlspecialchars($showtimingID); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Start Time</td>
                <td><input type="time" name="starttime" value="<?php echo htmlspecialchars($starttime); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Show Date</td>
                <td><input type="date" name="showdate" value="<?php echo htmlspecialchars($showdate); ?>" size="25" required></td>
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

<?php
mysqli_close($conn);
?>
