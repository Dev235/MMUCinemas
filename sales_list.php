<?php
session_start();
//cant bypass
include('keselamatan.php');
//conn
require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket List</title>
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
        <?php include('header.php');?>
    </div>

    <div id="menu">
            <?php include('menu.php');?>
    </div>

    <div id="main">
        <p align="right">
            <button onclick="resizeFont(-1)">Smaller Font</button>
            <button onclick="resizeFont(1)">Bigger Font</button>
        </p>
        <center>
        <h1>Ticket Sales List MMU Cinemas</h1>
        <form id="borang" action="" method="POST" style="background-color: white; color:black">
            <table border="1" style="background-color: white; color:black">
                <tr>
                    <td colspan="3">*Type to query</td>
                </tr>
                <tr>
                    <td>Search</td>
                    <td><input type="text" name="query" required autofocus /></td>
                    <td><input type="submit" name="submit" value="Search"></td>
                </tr>
                <tr>
                </tr>
            </table>
        </form>
        <table border="1">
            <tr style="background-color:white; color:black">
                <th>No</th>
                <th>Date & Time of Sales</th>
                <th>Staff</th>
                <th>Film Title</th>
                <th>Showtime and date</th>
                <th>Seat Number</th>
                <th>Hall</th>
                <th>Ticket</th>
                <th>Price</th>
                <th colspan="2">Tindakan</th>
            </tr>
            <?php
            $query = isset($_POST['query']) ? $_POST['query'] : '';

            // Prepare the SQL statement
            if ($query) {
                $stmt = $conn->prepare("SELECT * FROM sales WHERE salesDate LIKE ? ORDER BY salesID");
                $searchQuery = "%" . $query . "%";
                $stmt->bind_param("s", $searchQuery);
            } else {
                $stmt = $conn->prepare("SELECT * FROM sales ORDER BY salesID");
            }

            // Execute the statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $no = 1;
                $totalprice = 0;

                // Check if any rows are returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $newdate = date("d-m-Y", strtotime($row['salesDate']));
                        $newtime = date("h:i:A", strtotime($row['salesTime']));
                        $salesID = $row['salesID'];

                        // Import Maklumat
                        $ticket = mysqli_query($conn, "SELECT * FROM sales WHERE salesID='$salesID'");
                        $ticketInfo = mysqli_fetch_array($ticket);
                        $ticketID = $ticketInfo['ticketID'];

                        $ticket2 = mysqli_query($conn, "SELECT ticket FROM ticket WHERE ticketID ='$ticketID'");
                        $ticketInfo2 = mysqli_fetch_array($ticket2);
                        $tickettype = $ticketInfo2['ticket'];

                        $data2 = mysqli_query($conn, "SELECT price FROM ticket WHERE ticket='$tickettype'");
                        $priceInfo = mysqli_fetch_array($data2);

                        $showtiming = mysqli_query($conn, "SELECT showtimingID FROM sales WHERE salesID='$salesID'");
                        $showtimingInfo = mysqli_fetch_array($showtiming);
                        $showtimingID = $showtimingInfo['showtimingID'];

                        $hall = mysqli_query($conn, "SELECT * FROM sales WHERE salesID='$salesID'");
                        $hallInfo = mysqli_fetch_array($hall);
                        $hallID = $hallInfo['hallID'];

                        $hall2 = mysqli_query($conn, "SELECT * FROM hall WHERE hallID='$hallID'");
                        $hallInfo2 = mysqli_fetch_array($hall2);
                        $hallType = $hallInfo2['hallName'];

                        $data3 = mysqli_query($conn, "SELECT * FROM showtiming WHERE showtimingID='$showtimingID'");
                        $showtimingInfo2 = mysqli_fetch_array($data3);
            ?>

                        <tr style="background-color:white; color:black">
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $newdate; ?><br><?php echo $newtime; ?></td>
                            <td align="center"><?php $staffID = $row['staffID'];
                                $data4 = mysqli_query($conn, "SELECT name FROM staff WHERE staffID='$staffID'");
                                $staffInfo = mysqli_fetch_array($data4);
                                echo $staffInfo['name']; ?></td>
                            <td align="center"><?php $filmID = $row['filmID'];
                                $data5 = mysqli_query($conn, "SELECT title FROM film WHERE filmID='$filmID'");
                                $filmInfo = mysqli_fetch_array($data5);
                                echo $filmInfo['title']; ?></td>
                            <?php
                            $newshowdate = date("d-m-Y", strtotime($showtimingInfo2['showdate']));
                            $newshowtime = date("h:i:A", strtotime($showtimingInfo2['starttime']));
                            ?>
                            <td align="center"><?php echo $newshowdate; ?><br><?php echo $newshowtime; ?></td>
                            <td align="center"><?php echo $row['seatNumber']; ?></td>
                            <td align="center"><?php echo $hallType; ?></td>
                            <td align="center"><?php echo $tickettype; ?></td>
                            <td align="center">RM<?php echo $priceInfo['price']; ?></td>
                            <td align="center"><a href="sales_receipt.php?salesID=<?php echo $row['salesID']; ?>" title="Receipt">Receipt</a></td>
                            <td align="center"><a href="sales_delete.php?salesID=<?php echo $row['salesID']; ?>" onclick="return checkdelete()">Delete</a></td>
                            <?php $totalprice += $priceInfo['price']; ?>
                        </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='11' align='center'>No results found</td></tr>";
                }
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
            ?>
            <tr>
                <th colspan="9" style="background-color:white; color:black" align="right">
                    <b>Total Price</b>
                </th>
                <th colspan="1" align="center" style="background-color:white; color:black"><b>RM <?php echo number_format($totalprice, 2); ?></th>
                <th colspan="2" align="center" style="background-color:white; color:black"><b>--</th>
            </tr>
        </table>
        </center>
        <h2 align="center">
            <input type="submit" name="print" value="Print" onclick="printContent('main')">
        </h2>
    </div>

    <div id="footer">
        <?php include('footer.php');?>
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
<!--Aight time to do the function to resize the font-->
<script>
    function resizeFont(multiplier){
        if(document.body.style.fontSize == ""){
            document.body.style.fontSize = "1.0em";
        }
        document.body.style.fontSize = parseFloat(document.body.style.fontSize) + (multiplier * 0.1) + "em";
    }
</script>

</body>
</html>
