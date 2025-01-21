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
    <title>IP Address List</title>
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
        <h1>IP Address List</h1>
            <center>
            <form id="borang" action="" method="POST" style="background-color: white; color:black">
                <table border="1" style="background-color: white; color:black">
                    <tr>
                        <td colspan="3">*Start typing and press enter to query</td>
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
                <th>IP Address</th>
                <th>Staff ID</th>
                <th colspan="2">Action</th>
            </tr>
            <?php
            //connect to database
            require_once("connection.php");

            $query = isset($_POST['query']) ? $_POST['query'] : '';

            // Prepare the SQL statement
            if ($query) {
                $stmt = $conn->prepare("SELECT * FROM ipaddress WHERE ipaddress LIKE ? OR staffID LIKE ? ORDER BY ipaddress ASC");
                $searchQuery = "%" . $query . "%";
                $stmt->bind_param("ss", $searchQuery, $searchQuery);
            } else {
                $stmt = $conn->prepare("SELECT * FROM ipaddress ORDER BY ipaddress ASC");
            }

            // Execute the statement
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $counter = 1;

                // Check if any rows are returned
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>

                        <tr>
                            <td align="center"> <?php echo $counter++; ?> </td>
                            <td> <?php echo $row['ipaddress'] ?> </td>
                            <td> <?php echo $row['staffID'] ?> </td>
                            <td align="center"><a href="ipaddress_update.php?ipaddress=<?php echo $row['ipaddress']; ?>"> Update</a></td>
                            <td align="center"><a href="ipaddress_delete.php?ipaddress=<?php echo $row['ipaddress']; ?>" onclick="return checkdelete()"> Delete</a></td>
                        </tr>

            <?php
                    }
                } else {
                    echo "<tr><td colspan='5' align='center'>No results found</td></tr>";
                }
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            $stmt->close();
            ?>

        </table>
        </center>
        <h2 align="center">
            <input type="submit" name="print" value="Print!" onclick="printContent('main')">
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
        return confirm('Log Out');
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

</html>
