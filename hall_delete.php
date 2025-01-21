<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['hallID'])){
  $hallID = $_GET['hallID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM hall WHERE hallID = ?");
  $stmt->bind_param("i", $hallID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=hall_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=hall_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
