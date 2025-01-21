<?php
error_reporting(0);
session_start();
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

// Check if the logged-in user is an Admin
$isAdmin = ($_SESSION['staffStatus'] == 'Admin');
$currentUser = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
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
            <p align="right">
                <button onclick="resizeFont(-1)">Smaller Font</button>
                <button onclick="resizeFont(1)">Bigger Font</button>
            </p>
            <center>
                <h1>MMU Cinemas Staff List</h1>
                <form id="borang" action="" method="POST" style="background-color: white; color:black">
                    <table border="1" style="background-color: white; color:black">
                        <tr>
                            <td colspan="3">*Type for query</td>
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
                        <?php if ($isAdmin) { ?>
                            <th>Username</th>
                        <?php } ?>
                        <th>Name</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                    <?php
                    //connect to database
                    require_once("connection.php");

                    $query = isset($_POST['query']) ? $_POST['query'] : '';

                    // Prepare the SQL statement
                    if ($query) {
                        if ($isAdmin) {
                            $stmt = $conn->prepare("SELECT * FROM staff WHERE name LIKE ? ORDER BY staffStatus ASC");
                        } else {
                            $stmt = $conn->prepare("SELECT * FROM staff_view WHERE name LIKE ? ORDER BY staffStatus ASC");
                        }
                        $searchQuery = "%" . $query . "%";
                        $stmt->bind_param("s", $searchQuery);
                    } else {
                        if ($isAdmin) {
                            $stmt = $conn->prepare("SELECT * FROM staff ORDER BY staffStatus ASC");
                        } else {
                            $stmt = $conn->prepare("SELECT * FROM staff_view ORDER BY staffStatus ASC");
                        }
                    }

                    // Execute the statement
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $bil = 1;

                        // Check if any rows are returned
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>

                                <tr>
                                    <td align="center"> <?php echo $bil++; ?> </td>
                                    <?php if ($isAdmin) { ?>
                                        <td> <?php echo $row['staffID'] ?> </td>
                                    <?php } else { ?>
                                        <td> <?php echo $row['masked_staffID'] ?> </td>
                                    <?php } ?>
                                    <td> <?php echo $row['name'] ?> </td>
                                    <td><?php echo $row['staffStatus'] ?></td>

                                    <?php if ($row['staffID'] == $currentUser && !$isAdmin) { ?>
                                        <td align="center"><a href="user_update.php?staffID=<?php echo $row['staffID']; ?>"> Update</a></td>
                                        <td align="center">Cannot delete own account</td>
                                    <?php } elseif ($isAdmin) { ?>
                                        <td align="center"><a href="user_update.php?staffID=<?php echo $row['staffID']; ?>"> Update</a></td>
                                        <td align="center"><a href="user_delete.php?staffID=<?php echo $row['staffID']; ?>" onclick="return checkdelete()"> Delete</a></td>
                                    <?php } else { ?>
                                        <td align="center" colspan="2">Requires elevated privileges</td>
                                    <?php } ?>

                                </tr>

                    <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' align='center'>No results found</td></tr>";
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
            <?php include('footer.php'); ?>
        </div>
        <script>
            function checkdelete() {
                return confirm('Delete this record');
            }

            function checklogout() {
                return confirm('Log out?');
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
