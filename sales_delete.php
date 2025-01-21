<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['salesID'])){
  $salesID = $_GET['salesID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM sales WHERE salesID = ?");
  $stmt->bind_param("i", $salesID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=sales_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=sales_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
