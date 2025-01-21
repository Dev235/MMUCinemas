<?php
session_start();

require_once('connection.php');

//cant bypass
include('keselamatan.php');

if(isset($_POST['Register'])){
    //declaring variables
  $screen = $_FILES['screen']['name'];
  $imageArr = explode('.', $screen);
  $random = rand(10000, 99999);
  $newnamepic = $imageArr[0] . $random . '.' . $imageArr[1];
  $uploadPath = "picture/" . $newnamepic;
  $isUploaded = move_uploaded_file($_FILES['screen']['tmp_name'], $uploadPath);
  $filmID = $_POST['filmID'];
  $language = $_POST['language'];
  $title = $_POST['title'];

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE film SET language = ?, title = ?, screen = ? WHERE filmID = ?");
  $stmt->bind_param("sssi", $language, $title, $newnamepic, $filmID);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh: 0; url=film_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh: 0; url=film_list.php');
  }

  $stmt->close();
}

$filmID = $_GET['filmID'];
$stmt = $conn->prepare("SELECT * FROM film WHERE filmID = ?");
$stmt->bind_param("i", $filmID);
$stmt->execute();
$data = $stmt->get_result();
$row = $data->fetch_assoc();

// Check if the query returned any results
if ($row) {
  $filmID = $row['filmID'];
  $language = $row['language'];
  $title = $row['title'];
  $screen = $row['screen'];
} else {
  $filmID = '';
  $language = '';
  $title = '';
  $screen = '';
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Film Information Update</title>
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
    <h1>Film Information Update</h1>
     <div id="borang">
        <form align="center" action="film_update.php" method="POST" enctype="multipart/form-data">
          <table>
            <tr>
                <td>FilmID</td>
                <td><input readonly type="text" name="filmID" value="<?php echo htmlspecialchars($filmID); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Language</td>
                <td>
                  <select name="language" id="Bahasa">
                    <option value="<?php echo htmlspecialchars($language); ?>">Previous Option: <?php echo htmlspecialchars($language); ?></option>
                    <option value="Eng">English</option>
                    <option value="Mly">Melayu</option>
                    <option value="Chn">Chinese</option>
                    <option value="Oth">Lain-Lain</option>
                  </select>
                </td>
            </tr>
            <tr>
                <td>Title</td>
                <td><input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" size="25" required></td>
            </tr>
            <tr>
                <td>Poster</td>
                <td>
                 <img src='picture/<?php echo htmlspecialchars($screen); ?>' width='200px' height='100px'/><br>
                <input type="file" name="screen" id="screen" value="">
              </td>
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
mysqli_close($conn);
?>
