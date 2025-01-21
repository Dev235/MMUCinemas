<?php
error_reporting(1);// connect dan keselamtan
session_start();
include('keselamatan.php');
require_once('connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Sales Report</title>
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
    <table width="800" border="0">
    <tr>
        <td width="400" align="left" style="background-color:white; color:black;">
        <strong>MMU Cinemas Sdn. Bhd.</strong><br/><br/>
        No 2 Lorong Limau Manis,<br/>
        14000 Bukit Mertajam,<br/>
        Pulau Pinang<br/>
        <br/></td>
        <td width="400" valign="bottom" align="right" style="background-color:white; color:black;"><br/>
        Printed Date: <?php echo date("d-m-Y"); ?></td>
    </tr>
    <tr>
        <td colspan="3" valign="top"><hr /></td>
    </tr>
    </table>
    <div id="laporan">
    <?php
    //INITIAL VALUE & VARIABLE
    $month = $_POST['month'];
    if ($month && $month != "-") {
        $dateObj = DateTime::createFromFormat('!m', $month);
        if ($dateObj) {
            $monthName = $dateObj->format('F');
        } else {
            echo "<script type='text/javascript'>alert('Invalid month!')</script>";
            header('Refresh: 0; url=monthlysales.php');
            exit();
        }
    } else {
        echo "<script type='text/javascript'>alert('Select a month!')</script>";
        header('Refresh: 0; url=monthlysales.php');
        exit();
    }
    ?>
    <p align="center" style="background-color:white; color:black;"><strong>Sales Report for The Month : <?php echo $monthName;?></strong></p><br>
    </div>
    <table width="800" border="1" align="center" style="background-color: white; color: black;">
        <tr style="color:black;">
        <th>No</th>
        <th>Staff</th>
        <th>Title</th>
        <th>Date</th>
        <th>Time</th>
        <th>Chair Number</th>
        <th>Type of Ticket</th>
        <th>Price</th>

        </tr>
      <?php
//GET THE QUERY RECORD
$stmt = $conn->prepare("SELECT * FROM sales WHERE (MONTH(salesDate)=?) ORDER BY salesDate");
$stmt->bind_param("i", $month);
$stmt->execute();
$data = $stmt->get_result();

$record_count = $data->num_rows;
$no = 1;
$sum = 0;
while ($info = $data->fetch_assoc()) {

//Film Data
$filmStmt = $conn->prepare("SELECT * FROM film WHERE filmID=?");
$filmStmt->bind_param("i", $info['filmID']);
$filmStmt->execute();
$filmData = $filmStmt->get_result();
$filmInfo = $filmData->fetch_assoc();

//Staff Data
$staffStmt = $conn->prepare("SELECT * FROM staff WHERE staffID=?");
$staffStmt->bind_param("s", $info['staffID']);
$staffStmt->execute();
$staffData = $staffStmt->get_result();
$staffInfo = $staffData->fetch_assoc();

//Ticket Data
$ticketStmt = $conn->prepare("SELECT * FROM ticket WHERE ticketID=?");
$ticketStmt->bind_param("i", $info['ticketID']);
$ticketStmt->execute();
$ticketData = $ticketStmt->get_result();
$ticketInfo = $ticketData->fetch_assoc();

//Showtiming Data
$showtimingStmt = $conn->prepare("SELECT * FROM showtiming WHERE hallID=?");
$showtimingStmt->bind_param("i", $info['hallID']);
$showtimingStmt->execute();
$showtimingData = $showtimingStmt->get_result();
$showtimingInfo2 = $showtimingData->fetch_assoc();

//Time Data
$date = $info['salesDate'];
$showDate = $showtimingInfo2['showDate'];
$time = $info['salesTime'];
$showTime = $showtimingInfo2['starttime'];

?>


<tr>
    <td align=center><?php echo $no;?></td>
    <td align=center><?php echo $staffInfo['name']; ?></td>
    <td align=center><?php echo $filmInfo['title']; ?></td>
    <td align=center><?php echo date('d-m-Y', strtotime($date)); ?></td>
    <td align=center><?php echo date('h:i A', strtotime($time)); ?></td>
    <td align=center><?php echo $info['seatNumber']; ?></td>
    <td align=center><?php echo $ticketInfo['ticket'] ?></td>
    <td align=center>RM <?php echo number_format($ticketInfo['price'],2);
    $sum += $ticketInfo['price']; ?></td>
</tr>
<?php $no++;
}
?>


<tr>
    <th colspan="7" align="right" style="background-color:white; color:black;">Gross Total : </td>
    <th style="background-color:white; color:black;">RM <?php echo number_format($sum,2); ?></td>
</tr>

    </table>


      <h2 align="center">
        <input type="submit" name="print" value="Print" onclick="printContent('main')">
      </h2>
    </div>

    <div id="footer">
            <?php
        include ('footer.php');
        ?>
    </div>


</div>
</body>
<script>
  function checkdelete(){
    return confirm('Delete this record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>
</html>
