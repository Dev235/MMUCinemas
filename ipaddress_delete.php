<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['ipaddress'])){
  $ipaddress = $_GET['ipaddress'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM ipaddress WHERE ipaddress = ?");
  $stmt->bind_param("s", $ipaddress);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=ipaddress_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=ipaddress_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
