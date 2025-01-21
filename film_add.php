<?php
session_start();

require_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Film Registration Form</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
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
    <center>
    <h1>Film Registration Form</h1>
     <div id="borang">
        <form align="center" action="film_add.php" method="POST" enctype="multipart/form-data">
          <table>
            <tr>
                <td>Language</td>
                <td>
                  <select name="language" id="Bahasa">
                    <option value="Eng">English</option>
                    <option value="Mly">Melayu</option>
                    <option value="Chn">Chinese</option>
                    <option value="Tal">Tamil</option>
                    <option value="Oth">Others</option>
                  </select>
                </td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type="text" name="title" placeholder="Insert a title" size="25" required></td>
            </tr>
            <tr>
                <td>Poster</td>
                <td><input type="file" name="screen" id="screen"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="Register" value="Enter Details"></td>
            </tr>
         </table>
       </form>
     </div>
    </center>
    </div>

    <div id="footer">
        <?php include('footer.php'); ?>
    </div>
</div>
<script>
  function checkdelete(){
    return confirm('Delete this record?');
  }

  function checklogout(){
    return confirm('Log Out?');
  }
</script>
</body>
</html>

<?php
//cant bypass
include('keselamatan.php');
//connect
require_once('connection.php');

if(isset($_POST['Register'])){
    //declaring variables
  $screen = $_FILES['screen']['name'];
  $imageArr = explode('.', $screen);
  $random = rand(10000, 99999);
  $newnamepic = $imageArr[0] . $random . '.' . $imageArr[1];
  $uploadPath = "picture/" . $newnamepic;
  $isUploaded = move_uploaded_file($_FILES['screen']['tmp_name'], $uploadPath);

  $language = $_POST['language'];
  $title = $_POST['title'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("INSERT INTO film (language, title, screen) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $language, $title, $newnamepic);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh: 0; url=film_add.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh: 0; url=film_add.php');
  }

  $stmt->close();
}
mysqli_close($conn);
?>
