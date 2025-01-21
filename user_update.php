<?php
session_start();
//connect to database
require_once('connection.php');
include('keselamatan.php');

// Function to encrypt the password using AES-128-CTR
function encryptString($string)
{
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '2003050612345678';
    $encryption_key = "CINEMAMANAGEMENTSYSTEM";
    // Encrypt the string
    $encrypted_string = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encrypted_string;
}
// Function to decrypt the password using AES-128-CTR
function decryptString($encrypted_string)
{
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '2003050612345678';
    $encryption_key = "CINEMAMANAGEMENTSYSTEM";
    // Decrypt the string
    $decrypted_string = openssl_decrypt($encrypted_string, $ciphering, $encryption_key, $options, $encryption_iv);
    return $decrypted_string;
}

if(isset($_POST['update_btn'])){
  $username = $_POST['username'];
  $password = $_POST['pwd'];
  $name = $_POST['name'];
  $staffStatus = $_POST['staffStatus'];

  // Encrypt the password
  $encrypted_password = encryptString($password);

  // Prepare the SQL statement
  $stmt = $conn->prepare("UPDATE staff SET name = ?, staffpassword = ?, staffStatus = ? WHERE staffID = ?");
  $stmt->bind_param("ssss", $name, $encrypted_password, $staffStatus, $username);
  $result = $stmt->execute();

  if($result){
    echo "<script>alert('Successful')</script>";
    header('Refresh:0 ; url=user_list.php');
  } else {
    echo "<script>alert('Failed')</script>";
    header('Refresh:0 ; url=user_list.php');
  }

  $stmt->close();
} else {
  $username = $_GET['staffID'];
  $stmt = $conn->prepare("SELECT * FROM staff WHERE staffID = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $data = $stmt->get_result();
  $row = $data->fetch_assoc();

  // Check if the query returned any results
  if ($row) {
    $staffID = $row['staffID'];
    $name = $row['name'];
    $staffpassword = decryptString($row['staffpassword']);
    $staffStatus = $row['staffStatus'];
  } else {
    $staffID = '';
    $name = '';
    $staffpassword = '';
    $staffStatus = '';
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule List</title>
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
    <!--Menyediakan Borang Login-->
    <h1 style="color: black;" >Staff Information Update Form</h1>
    <div id="borang">

      <form action="" method="POST">
        <table width="90%" border="0" cellpadding="15" cellspacing="20">
        <tr>
          <td align="right" style="color:black;">StaffID:</td>
          <td><input type="text" name="username" value="<?php echo $staffID;?>" readonly required=""></td>
        </tr>
         <tr>
           <td align="right"  style="color:black;">Name:</td>
           <td><input type="text" name="name" value="<?php echo $name;?>" required></td>
        </tr>
        <tr>
            <td align="right"  style="color:black;">Password:</td>
            <td><input type="text" name="pwd" value="<?php echo $staffpassword;?>" required></td>
        </tr>
        <tr>
            <td align="right" style="color:black;">Staff Status:</td>
            <td>
              <select name="staffStatus" required>
                <option value="Staff" <?php if($staffStatus == 'Staff') echo 'selected'; ?>>Staff</option>
                <option value="Admin" <?php if($staffStatus == 'Admin') echo 'selected'; ?>>Admin</option>
              </select>
            </td>
        </tr>
           <tr>
            <td></td>
            <td align="left"><input type="submit" name="update_btn" value="Update"></td>
          </tr>
        </table>

      </form>
        </center>
      </div>


  <div id="footer">
        <?php include('footer.php'); ?>
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

<?php
mysqli_close($conn);
?>
