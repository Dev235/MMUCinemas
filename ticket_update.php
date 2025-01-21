<?php
error_reporting(0);
session_start();

require_once('connection.php');
//connect to database
include('keselamatan.php');

if(isset($_POST['update_btn'])){
  $ticketID = $_POST['ticketID'];
  $ticket = $_POST['ticket'];
  $price = $_POST['price'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE ticket SET ticket = ?, price = ? WHERE ticketID = ?");
  $stmt->bind_param("ssi", $ticket, $price, $ticketID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=ticket_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=ticket_list.php');
  }

  $stmt->close();
} else {
  $ticketID = $_GET['ticketID'];
  $stmt = $conn->prepare("SELECT * FROM ticket WHERE ticketID = ?");
  $stmt->bind_param("i", $ticketID);
  $stmt->execute();
  $data = $stmt->get_result();
  $row = $data->fetch_assoc();

  // Check if the query returned any results
  if ($row) {
    $ticketID = $row['ticketID'];
    $ticket = $row['ticket'];
    $price = $row['price'];
  } else {
    $ticketID = '';
    $ticket = '';
    $price = '';
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Ticket Update Form</title>
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
  <h1>Ticket Update Form</h1>
     <div id="borang">
        <form align="center" action="ticket_update.php" method="POST">
          <table>
            <tr>
                <td>Ticket ID</td>
                <td><input readonly type="text" name="ticketID" value="<?php echo htmlspecialchars($ticketID); ?>" size="25" required readonly></td>
            </tr>
            <tr>
                <td>Type of Ticket</td>
                <td><input type="text" name="ticket" value="<?php echo htmlspecialchars($ticket); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>" size="25" required></td>
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
// Close the database connection after including the menu
mysqli_close($conn);
?>
