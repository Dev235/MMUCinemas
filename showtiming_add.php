<?php
session_start();
include('keselamatan.php');
date_default_timezone_set('Asia/Kuala_Lumpur');
require_once('connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Showtime New Registration Form</title>
    <link rel="stylesheet" type="text/css" href="style2.css">

</head>

<body>
    <div id="wrapper">

        <div id="header">
            <?php
            include('header.php');
            ?>
        </div>

        <div id="menu">
            <?php
            include('menu.php');
            ?>
        </div>

        <div id="main">
            <center>
                <h1>Showtime Registration Form</h1>
                <div id="borang">
                    <form align="center" action="showtiming_add.php" method="POST">
                        <table>
                            <tr>
                                <td>Show Start Time</td>
                                <td><input type="time" name="starttime" placeholder="Show start time" size="25" required></td>
                            </tr>
                            <tr>
                                <td>Show Date</td>
                                <td><input type="date" name="showdate" placeholder="Show Date" size="25" required></td>
                            </tr>
                            <tr>
                                <td>Name of the film</td>
                                <td><select name="filmName" style="width: 160px; margin-bottom: 20px;">
                                        <?php
                                        $filmdata = mysqli_query($conn, "SELECT * FROM film ORDER BY title");
                                        while ($filminfo = mysqli_fetch_array($filmdata)) {
                                            echo "<option hidden selected> Select A Film Title  </option>";
                                            echo "<option value='$filminfo[title]'>$filminfo[title]</option>";
                                        }
                                        ?>
                                    </select>
                            </tr>
                            <tr>
                                <td>Hall Name</td>
                                <td><select name="HallName" style="width: 160px; margin-bottom: 20px;">
                                        <?php
                                        $hallData = mysqli_query($conn, "SELECT * FROM hall ORDER BY hallName");
                                        while ($hallInfo = mysqli_fetch_array($hallData)) {
                                            echo "<option hidden selected>Select A Hall Name</option>";
                                            echo "<option value='$hallInfo[hallName]'>$hallInfo[hallName]</option>";
                                        }
                                        ?>
                                    </select>
                            </tr>


                            <tr>
                                <td><input type="submit" name="Register" value=" Enter Details "></td>
                            </tr>
                        </table>

                    </form>
                </div>
            </center>
        </div>


        <div id="footer">
            <?php
            include('footer.php');
            ?>
        </div>
    </div>
    <script>
        function checkdelete() {
            return confirm('Padam rekod ini?');
        }

        function checklogout() {
            return confirm('Log Keluar?');
        }
    </script>
</body>

</html>

<?php

if (isset($_POST['Register'])) {
    //declaring variables

    $starttime = $_POST['starttime'];
    $showdate = $_POST['showdate'];
    $hallName = $_POST['HallName'];
    $filmName = $_POST['filmName'];

    // Prepare the SQL statement for film
    $stmt = $conn->prepare("SELECT * FROM film WHERE title = ?");
    $stmt->bind_param("s", $filmName);
    $stmt->execute();
    $data = $stmt->get_result();
    $result = $data->fetch_assoc();
    $filmID = $result['filmID'];
    $newnamepic = $result['screen'];

    // Prepare the SQL statement for hall
    $stmt2 = $conn->prepare("SELECT * FROM hall WHERE hallName = ?");
    $stmt2->bind_param("s", $hallName);
    $stmt2->execute();
    $data2 = $stmt2->get_result();
    $result2 = $data2->fetch_assoc();
    $hallID = $result2['hallID'];

    $formatteddate = date("Y-m-d", strtotime($showdate));
    $formattedtime = date("H:i:s", strtotime($starttime));

    // Prepare the SQL statement for insertion
    $stmt3 = $conn->prepare("INSERT INTO showtiming (starttime, showdate, screen, filmID, hallID) VALUES (?, ?, ?, ?, ?)");
    $stmt3->bind_param("sssii", $formattedtime, $formatteddate, $newnamepic, $filmID, $hallID);
    $result3 = $stmt3->execute();

    if ($result3) {
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url= showtiming_add.php');
    } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url= showtiming_add.php');
    }

    $stmt->close();
    $stmt2->close();
    $stmt3->close();
}
mysqli_close($conn);

?>
