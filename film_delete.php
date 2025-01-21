<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['filmID'])){
  $filmID = $_GET['filmID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM film WHERE filmID = ?");
  $stmt->bind_param("i", $filmID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=film_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=film_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
