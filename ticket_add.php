<?php
error_reporting(0);
session_start();

require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Registration Form</title>
    <link rel="stylesheet" type="text/css" href="style2.css">

</head>

<body>
<div id="wrapper">

    <div id="header">
        <?php
        include ('header.php');
        ?>
    </div>

    <div id="menu">
        <?php
        include ('menu.php');
        ?>
    </div>

    <div id="main">
    <center>
    <h1>Ticket Registration Form</h1>
     <div id= "borang">
        <form align= "center" action="ticket_add.php" method="POST">
          <table>
            <tr>
                <td>Ticket Type</td>
                <td><input type="text" name="ticket" oninput="this.setcustomvalidity('Two Decimal Points. Eg : 0.00')" placeholder="Enter Type Of Ticket">
            </tr>
            <tr>
                <td>Price</td>
                <td><input id="Harga" name="price" type="money" pattern="(\d{2})([\.])(\d{2})" placeholder="**.**" oninvalid="this.setCustomValidity('Sila Masukkan 2 Digit dan 2 titik perpuluhan')" oninput="this.setCustomValidity('')" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Register" value=" Enter Details "></td>
            </tr>
         </table>

       </form>
     </div>
    </center>
    </div>


    <div id="footer">
            <?php
        include ('footer.php');
        ?>
    </div>
</div>

</body>
</html>

<?php
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

if(isset($_POST['Register'])){
    //declaring variables
    $ticket = $_POST['ticket'];
    $price = $_POST['price'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO ticket (ticketID, ticket, price) VALUES (null, ?, ?)");
    $stmt->bind_param("ss", $ticket, $price);
    $result = $stmt->execute();

    if($result){
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url= ticket_add.php');
    } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url= ticket_add.php');
    }

    $stmt->close();
}

mysqli_close($conn);
?>
