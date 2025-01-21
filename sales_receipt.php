<?php
//Start
session_start();
//Connecting to database
require_once('connection.php');
//Cannot bypass
include('keselamatan.php');
$salesID = $_GET['salesID'];

//TABLE sales
$stmt = $conn->prepare("SELECT * FROM sales WHERE salesID = ?");
$stmt->bind_param("i", $salesID);
$stmt->execute();
$salesData = $stmt->get_result();
$salesInfo = $salesData->fetch_assoc();

//TABLE showtiming
$stmt = $conn->prepare("SELECT * FROM showtiming WHERE showtimingID = ?");
$stmt->bind_param("i", $salesInfo['showtimingID']);
$stmt->execute();
$showtimingData = $stmt->get_result();
$showtimingInfo = $showtimingData->fetch_assoc();

//TABLE film
$stmt = $conn->prepare("SELECT * FROM film WHERE filmID = ?");
$stmt->bind_param("i", $salesInfo['filmID']);
$stmt->execute();
$filmData = $stmt->get_result();
$filmInfo = $filmData->fetch_assoc();

//TABLE hall
$stmt = $conn->prepare("SELECT * FROM hall WHERE hallID = ?");
$stmt->bind_param("i", $salesInfo['hallID']);
$stmt->execute();
$hallData = $stmt->get_result();
$hallInfo = $hallData->fetch_assoc();

//TABLE ticket
$stmt = $conn->prepare("SELECT * FROM ticket WHERE ticketID = ?");
$stmt->bind_param("i", $salesInfo['ticketID']);
$stmt->execute();
$ticketData = $stmt->get_result();
$ticketInfo = $ticketData->fetch_assoc();

//TABLE staff
$stmt = $conn->prepare("SELECT * FROM staff WHERE staffID = ?");
$stmt->bind_param("s", $salesInfo['staffID']);
$stmt->execute();
$staffData = $stmt->get_result();
$staffInfo = $staffData->fetch_assoc();

//DECLARE DATE/TIME
$date = $salesInfo['salesDate'];
$showtimingDate = $showtimingInfo['showdate'];
$time = $salesInfo['salesTime'];
$showtimingTime = $showtimingInfo['starttime'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales Receipt</title>
    <link rel="stylesheet" type="text/css" href="style2.css">

    <script>
        function printContent(el){
        var restorepage = document.body.innerHTML;
        var printContent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = restorepage;
    }
    </script>

</head>

<body>
<div id="wrapper">
    <div id="header">
        <?php   include ('header.php');?>
    </div>
    <div id="menu">
        <?php include ('menu.php');?>
    </div>
<div id="main">
    <center>
<br><table border="1" cellspacing="0" style="background-color: white; color:black">
    <tr>
        <td valign="middle" align="center"><b>
        MMU Cinemas Sdn Bhd<br></td>
        <td valign="middle" align="center"><b>
        Ticket No: <?php echo $salesInfo['salesID'];?></b></td>
    </tr>
        <td witdh="300">Film Title: <br>
        <b><?php echo $filmInfo['title']; ?></td>
        <td width="300">Hall/Seat No: <br>
        <b><?php echo $hallInfo['hallName']; ?> / <?php echo $salesInfo['seatNumber']; ?></td>
    </tr>
    <tr>
        <td>Category:
    <?php echo $ticketInfo['ticket'];?> <br>Price: <b>RM<?php echo $ticketInfo['price'];?></td>
        <td>Date / Time:<br>
        <b><?php echo date("d-m-Y", strtotime($showtimingDate)); ?> / <?php echo date("h:i A", strtotime($showtimingTime)); ?>
    </tr>
    <tr>
        <td>Ticket Sales Time:</br>
        <?php echo date("d-m-Y", strtotime($date)); ?> / <?php echo date("h:i A", strtotime($time)); ?>
        </td>
        <td>Sales Done By:<br>
        <b><?php echo $staffInfo['name']; ?>
        </td>
    </tr>
    <tr>
        <td colspan="1">
        <font size="3"><b>TOTAL
        </td>
        <td><b>RM <?php echo number_format($ticketInfo['price'],2);?></td>
    </tr>

    </table>
    <h2 align="center">
            <input type="submit" name="print" value="Print" onclick="printContent('main');">
        </h2>
</div>



<div id="footer">
<?php
include ('footer.php');
?>
</div>
<script>
  function checkdelete(){
    return confirm('Delete this record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>
</div>
</body>
</html>
