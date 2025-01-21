<?php
session_start();
//connection
require_once('connection.php');

if(isset($_GET['ticketID'])){
  $ticketID = $_GET['ticketID'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("DELETE FROM ticket WHERE ticketID = ?");
  $stmt->bind_param("i", $ticketID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=ticket_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=ticket_list.php');
  }

  $stmt->close();
}

mysqli_close($conn);
?>
