<?php
require_once('connection.php');
$username = $_SESSION['username'];

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT staffStatus FROM staff WHERE staffID = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$queryadminstatus = $row['staffStatus'];
?>
<?php if($queryadminstatus == "Admin"){ ?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Admin</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
    <?php
    require_once('connection.php');
    $username = $_SESSION['username'];
    ?>

    <center>
    <div id="tekan">
        <div id="welcome2">
            <p><?php echo "Welcome $username";?></p>
        </div>
        <ul><h3>Menu</h3>
            <li><a href="cinemakalla.php">Home</a></li>
            <h3>Registration</h3>
            <li><a href="signup.php">Register Users</a></li>
            <li><a href="film_add.php">Register Movies</a></li>
            <li><a href="showtiming_add.php">Register Schedule</a></li>
            <li><a href="hall_add.php">Register Cinema Hall</a></li>
            <li><a href="ticket_add.php">Register Tickets</a></li>
            <h3>Listing</h3>
            <li><a href="film_list.php">Movie Listing</a></li>
            <li><a href="user_list.php">Staff Listing</a></li>
            <li><a href="showtiming_list.php">Schedule Listing</a></li>
            <li><a href="hall_list.php">Cinema Hall Listing</a></li>
            <li><a href="ticket_list.php">Tickets Listing</a></li>
            <li><a href="sales_list.php">Sales</a></li>
            <h3>Sales Report & Log</h3>
            <li><a href="import.php">Import User Data</a></li>
            <li><a href="monthlysales.php">Query Sales Report</a></li>
            <li><a href="audit_log_table.php">Audit</a></li>
            <h3>Log Out</h3>
            <li><a href="logout.php" onclick="return checklogout()">Logout</a></li>
            <h3>Ip Address Whitelist</h3>
            <li><a href="ipaddress_list.php">Ip Address Whitelist</a></li>
            <li><a href="ipaddress_add.php">Add New Ip</a></li>
        </ul>
    </div>
    </center>
</body>
</html>

<?php
} else if ($queryadminstatus == "Staff"){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Menu</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
    <?php
    require_once('connection.php');
    $username = $_SESSION['username'];
    ?>

    <center>
    <div id="tekan">
        <div id="welcome2">
            <p><?php echo "Welcome $username";?></p>
        </div>
        <ul><h3>Menu</h3>
            <li><a href="cinemakalla.php">Home</a></li>
            <h3>Listing</h3>
            <li><a href="film_list.php">Movie Listing</a></li>
            <li><a href="user_list.php">Staff Listing</a></li>
            <li><a href="showtiming_list.php">Schedule Listing</a></li>
            <li><a href="hall_list.php">Cinema Hall Listing</a></li>
            <li><a href="ticket_list.php">Tickets Listing</a></li>
            <li><a href="sales_list.php">Sales</a></li>
            <h3>Report Query</h3>
            <li><a href="monthlysales.php">Query Sales Report</a></li>
            <h3>Log Out</h3>
            <li><a href="logout.php" onclick="return checklogout()">Logout</a></li>
        </ul>
    </div>
    </center>
</body>
</html>

<?php
}
?>
