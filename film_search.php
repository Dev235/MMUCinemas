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
    <title>Movie List</title>
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
        <?php include('header.php'); ?>
    </div>

    <div id="menu">
        <?php include('menu.php'); ?>
    </div>

    <div id="main">
        <p align="right">
            <button onclick="resizeFont(-1)">Bigger Font</button>
            <button onclick="resizeFont(1)">Smaller Font</button>
        </p>
        <center>
        <h1>Carian Wayang Kallaboi Cinemas</h1>
            <form id="borang" action="" method="POST">
                <table border="1">
                    <tr>
                        <td colspan="3">*Type for query</td>
                    </tr>
                    <tr>
                        <td>Movie Name :</td>
                        <td><input type="text" name="query" required autofocus /></td>
                        <td><input type="submit" name="submit" value="Search"></td>
                    </tr>
                    <tr>
                        
                    </tr>
                </table>
            </form>
        

        <table border="1">
            <tr>
                <th>No</th>
                <th>FilmID</th>
                <th>Language</th>
                <th>Title</th>
                <th colspan="2">Action</th>
            </tr>
            <?php
            //connect to database
            require_once("connection.php");

            $query = isset($_POST['query']) ? $_POST['query'] : '';

            // Prepare the SQL statement
            $stmt = $conn->prepare("SELECT * FROM film WHERE title LIKE ? ORDER BY filmID");
            $searchQuery = "%" . $query . "%";
            $stmt->bind_param("s", $searchQuery);
            $stmt->execute();
            $data = $stmt->get_result();
            $no = 1;

            while ($row = $data->fetch_assoc()){
                ?>

                <tr>
                    <td align="center"> <?php echo $no++; ?> </td>
                    <td> <?php echo $row['filmID']; ?> </td>
                    <td> <?php echo $row['language']; ?> </td>
                    <td> <?php echo $row['title']; ?> </td>
                    <td align="center"><a href="film_update.php?filmID=<?php echo $row['filmID']; ?>">Update</a></td>
                    <td align="center"><a href="film_delete.php?filmID=<?php echo $row['filmID']; ?>" onclick="return checkdelete()">Delete</a></td>
                </tr>

                <?php
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
