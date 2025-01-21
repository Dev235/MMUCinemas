<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['showtimingID'])){
  $showtimingID = $_GET['showtimingID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM showtiming WHERE showtimingID = ?");
  $stmt->bind_param("i", $showtimingID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=showtiming_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh: 0; url=showtiming_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
