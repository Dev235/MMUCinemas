<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Kuala_Lumpur');
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>Ticket List</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <script>
        function printContent(el) {
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
            <?php include('header.php'); ?>
        </div>

        <div id="menu">
            <?php include('menu.php'); ?>
        </div>

        <div id="main">
            <?php

            require_once('connection.php');

            $showtimingID = $_GET['showtimingID'];

            $stmt = $conn->prepare("SELECT filmID FROM showtiming WHERE showtimingID = ?");
            $stmt->bind_param("i", $showtimingID);
            $stmt->execute();
            $data = $stmt->get_result();
            $filmInfo = $data->fetch_assoc();
            $filmID = $filmInfo['filmID'];

            $stmt2 = $conn->prepare("SELECT * FROM film WHERE filmID = ?");
            $stmt2->bind_param("i", $filmID);
            $stmt2->execute();
            $data2 = $stmt2->get_result();
            $fileminfo2 = $data2->fetch_assoc();
            $title = $fileminfo2['title'];

            $stmt3 = $conn->prepare("SELECT hallID FROM showtiming WHERE showtimingID = ?");
            $stmt3->bind_param("i", $showtimingID);
            $stmt3->execute();
            $data3 = $stmt3->get_result();
            $hallInfo = $data3->fetch_assoc();
            $hallID = $hallInfo['hallID'];

            $stmt4 = $conn->prepare("SELECT * FROM hall WHERE hallID = ?");
            $stmt4->bind_param("i", $hallID);
            $stmt4->execute();
            $data4 = $stmt4->get_result();
            $hallInfo2 = $data4->fetch_assoc();
            $hallName = $hallInfo2['hallName'];

            ?>
            <?php
            require_once('connection.php');
            $username = $_SESSION['username'];
            $staffStmt = $conn->prepare("SELECT * FROM staff WHERE staffID = ?");
            $staffStmt->bind_param("s", $username);
            $staffStmt->execute();
            $staffData = $staffStmt->get_result();
            $staffInfo = $staffData->fetch_assoc();
            $staffName = $staffInfo['name'];
            ?>
            <center>
                <h1>Sales Registration</h1>


                <div id="borang">
                    <form align="center" action="" method="POST" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Staff Name</td>
                                <td><input type="text" name="staff" value="<?php echo $staffName; ?>" readonly>
                                <td>
                            </tr>
                            <tr>
                                <td>Film Name</td>
                                <td><input type="text" name="film" value="<?php echo $title; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Hall Name</td>
                                <td><input type="text" name="hall" value="<?php echo $hallName; ?>" readonly></td>
                            </tr>
                            <tr>
                                <td>Type of Ticket</td>
                                <td><select name="ticket" placeholder="Type of Ticket">
                                        <?php
                                        $tickettype = mysqli_query($conn, "SELECT * FROM ticket");
                                        while ($findticket = mysqli_fetch_array($tickettype)) {
                                            echo "<option hidden selected>Choose type of ticket</option>";
                                            echo "<option value='$findticket[ticket]'>$findticket[ticket]</option>";
                                        }
                                        ?>
                                </td>

                            </tr>
                            <tr>
                                <td>Seat Number</td>
                                <td><select name="seat" style="padding: 5px;">


                                        <?php
                                        //List of seats
                                        for ($v = 1; $v <= 40; $v++) {
                                            $showtimingID3 = $_GET['showtimingID'];
                                            $seatStmt = $conn->prepare("SELECT * FROM sales WHERE showtimingID = ? AND seatNumber = ?");
                                            $seatNumber = "A$v";
                                            $seatStmt->bind_param("is", $showtimingID3, $seatNumber);
                                            $seatStmt->execute();
                                            $seatquery = $seatStmt->get_result();
                                            $num = $seatquery->num_rows;

                                            if ($num == 0) {
                                                echo "<option>A$v</option>";
                                            }
                                        }
                                        ?>
                                    </select></td>

                            </tr>
                            <tr>
                                <td><input type="Submit" name="Click" value=" Enter Details "></td>
                            </tr>
                        </table>
                    </form>
                </div>
        </div>
        <div id="footer">
            <?php include('footer.php'); ?>
        </div>
        <script>
            function checkdelete() {
                return confirm('Delete this record?');
            }

            function checklogout() {
                return confirm('Log Out?');
            }
        </script>
    </div>
    <!--Aight time to do the function to resize the font-->
    <script>
        function resizeFont(multiplier) {
            if (document.body.style.fontSize == "") {
                document.body.style.fontSize = "1.0em";
            }
            document.body.style.fontSize = parseFloat(document.body.style.fontSize) + (multiplier * 0.1) + "em";
        }
    </script>

</body>

</html>

<?php
require_once('connection.php');

if (isset($_POST['Click'])) {

    $showtimingID = $_GET['showtimingID'];
    $staffID = $_SESSION['username'];
    $date = date("Y-m-d");
    $time = date("H:i:s");

    $film = $_POST['film'];
    $hall = $_POST['hall'];
    $ticket = $_POST['ticket'];
    $seat = $_POST['seat'];

    $stmt1 = $conn->prepare("SELECT * FROM ticket WHERE ticket = ?");
    $stmt1->bind_param("s", $ticket);
    $stmt1->execute();
    $convert1 = $stmt1->get_result();
    $converteddata1 = $convert1->fetch_assoc();
    $ticketID2 = $converteddata1['ticketID'];

    $stmt2 = $conn->prepare("SELECT * FROM hall WHERE hallName = ?");
    $stmt2->bind_param("s", $hall);
    $stmt2->execute();
    $convert2 = $stmt2->get_result();
    $converteddata2 = $convert2->fetch_assoc();
    $hallID2 = $converteddata2['hallID'];

    $stmt3 = $conn->prepare("SELECT * FROM film WHERE title = ?");
    $stmt3->bind_param("s", $film);
    $stmt3->execute();
    $convert3 = $stmt3->get_result();
    $converteddata3 = $convert3->fetch_assoc();
    $filmID2 = $converteddata3['filmID'];

    $stmt4 = $conn->prepare("INSERT INTO sales (showtimingID, salesDate, salesTime, hallID, ticketID, filmID, staffID, seatNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt4->bind_param("isssiiss", $showtimingID, $date, $time, $hallID2, $ticketID2, $filmID2, $staffID, $seat);
    $result = $stmt4->execute();

    if ($result) {
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url= sales.php');
    } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url= sales.php');
    }

    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
}
mysqli_close($conn);
?>
