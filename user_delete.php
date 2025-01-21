<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['staffID'])){
  $username = $_GET['staffID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM staff WHERE staffID = ?");
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=user_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=user_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
