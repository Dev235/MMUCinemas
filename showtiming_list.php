<?php
error_reporting(0);
session_start();
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Showtiming List</title>
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
        <h1>Show Timing List MMU Cinemas</h1>
            <form id="borang" action="" method="POST" style="background-color: white; color:black">
                <table border="1" style="background-color: white; color:black">
                    <tr>
                        <td colspan="3">*Type & Enter to Query</td>
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
        <table border="1" style="background-color: white; color:black">
            <tr>
                <th>No</th>
                <th>Show Time</th>
                <th>Show Date</th>
                <th>Poster</th>
                <th>Hall</th>
                <th>Film</th>
                <th colspan="3">Action</th>
            </tr>
            <?php
            //connect to database
            require_once("connection.php");

            $query = isset($_POST['query']) ? $_POST['query'] : '';

            // Prepare the SQL statement
            if ($query) {
                $stmt = $conn->prepare("SELECT * FROM showtiming WHERE showDate LIKE ? ORDER BY showDate ASC");
                $searchQuery = "%" . $query . "%";
                $stmt->bind_param("s", $searchQuery);
            } else {
                $stmt = $conn->prepare("SELECT * FROM showtiming ORDER BY showDate ASC");
            }

            // Execute the statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $no = 1;

                // Check if any rows are returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $showtimingID = $row['showtimingID'];

                        $hallID = $row['hallID'];
                        $hallStmt = $conn->prepare("SELECT * FROM hall WHERE hallID = ?");
                        $hallStmt->bind_param("i", $hallID);
                        $hallStmt->execute();
                        $hallData = $hallStmt->get_result();
                        $hallInfo = $hallData->fetch_assoc();
                        $hallName = $hallInfo['hallName'];

                        $filmID = $row['filmID'];
                        $filmStmt = $conn->prepare("SELECT * FROM film WHERE filmID = ?");
                        $filmStmt->bind_param("i", $filmID);
                        $filmStmt->execute();
                        $filmData = $filmStmt->get_result();
                        $filmInfo = $filmData->fetch_assoc();
                        $filmName = $filmInfo['title'];
            ?>

                        <tr>
                            <td align="center"> <?php echo $no++; ?> </td>
                            <td> <?php echo $row['starttime']; ?> </td>
                            <td> <?php echo $row['showdate']; ?> </td>
                            <td> <img src="picture\<?php echo $row['screen']; ?>" height=100 width=175></td>
                            <td> <?php echo $hallName; ?> </td>
                            <td> <?php echo $filmName; ?> </td>
                            <td align="center"><a href="showtiming_update.php?showtimingID=<?php echo $row['showtimingID']; ?>"> Update</a></td>
                            <td align="center"><a href="showtiming_delete.php?showtimingID=<?php echo $row['showtimingID']; ?>" onclick="return checkdelete()"> Delete</a></td>
                            <td align="center"><a href="sales.php?showtimingID=<?php echo $row['showtimingID']; ?>"> Booking!</a></td>
                        </tr>

            <?php
                    }
                } else {
                    echo "<tr><td colspan='9' align='center'>No results found</td></tr>";
                }
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
            ?>

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
