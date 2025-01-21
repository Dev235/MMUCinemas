<?php
session_start();
include('keselamatan.php');
require_once('connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Form</title>
    <link rel="stylesheet" type="text/css" href="style_main.css">
</head>

<body>
<div id="wrappers">
  <div id="header">
     <?php include('header.php');?>
  </div>
  <div id="menu">
     <?php include('menu.php');?>
  </div>
  <div id="main">
    <center>
      <h1>Register New Users Using Import</h1>
      <hr>

      <form id='borang' enctype='multipart/form-data' action='' method='post'>
        <table>
          <tr>
            <td align='right'>Import User File (*.csv) : </td>
            <td>
                <input type='file' name='filename' required>
            </td>
            </tr>

            <tr>
              <td colspan='2' align='center'>
              <input class='btn'  type='submit' name='submit' value='Import'>
              </td>
            </tr>
          </table>
        </form>
      </center>
  </div><!-- #main -->
  <div id="footer">
     <?php include('footer.php');?>
  </div>
</div><!-- #wrapper -->

</body>
</html>

<?php
//File Upload
if (isset($_POST['submit']))
{
  //Import the uploaded file to the database
  $handle = fopen($_FILES['filename']['tmp_name'], "r");

  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
  {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO staff (staffID, staffpassword, name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data[0], $data[1], $data[2]);
    $stmt->execute();
  }
  fclose($handle);

  echo "<script>alert('Successful Import!');
        window.location='user_list.php'</script>";
}
mysqli_close($conn);
?>
