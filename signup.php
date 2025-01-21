<!DOCTYPE html>
<html>

<head>
  <title>MMU Cinemas Management System Sdn Bhd</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    .error {
      color: red;
      font-size: 12px;
    }
  </style>
</head>

<body>

  <div id="header">
    <?php include('header.php'); ?>
  </div>
  <div id="wrapper">
    <div id="login">
      <ul>
        <li><a href="index.php">Home</a></li>
      </ul>
    </div>

    <div id="Borang">
      <center>
        <p>&nbsp;&nbsp;</p>
        <!--Menyediakan Borang Login-->
        <h1 style="color: black;">Staff Registration Form</h1>
        <div id="masuk">
          <form action="signup.php" method="POST">
            <table width="90%" border="0" cellpadding="15" cellspacing="20">
              <tr>
                <td align="right" style="color:black;">Staff ID</td>
                <td><input type="text" name="username" required=""></td>
              </tr>
              <tr>
                <td align="right" style="color:black;">Password:</td>
                <td><input type="password" name="pwd" required="">
                  <div class="error" id="passwordError"></div>
                </td>
              </tr>
              <tr>
                <td align="right" style="color:black;">Confirm Password:</td>
                <td><input type="password" name="cpwd" required="">
                  <div class="error" id="confirmPasswordError"></div>
                </td>
              </tr>
              <tr>
                <td align="right" style="color:black;">Full Name:</td>
                <td><input type="text" name="nama" required></td>
              </tr>
              <tr>
                <td align="right" style="color:black;">Staff Status:</td>
                <td>
                  <select name="staffStatus" required>
                    <option value="Staff">Staff</option>
                    <option value="Admin">Admin</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td align="left"><input type="submit" name="signup_btn" value="Register"></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><a href="login.php">Already Registered? Click Here to Login</a></td>
              </tr>
            </table>
            <button onclick="goBack()">Go Back</button>
            <script>
              function goBack() {
                window.history.back();
              }
            </script>
          </form>
        </div>
        <p>&nbsp;&nbsp;</p>
      </center>
    </div>
  </div>

  <footer id="footer">
    <?php include('footer.php'); ?>
  </footer>

</body>

</html>

<?php
session_start();
//Sambung ke database
include('keselamatan.php');
require_once('connection.php');

// Function to sanitize user input
function sanitizeInput($input) {
  return htmlspecialchars(strip_tags(trim($input)));
}

if (isset($_POST['signup_btn'])) {
  //Declare variables
  $username = sanitizeInput($_POST['username']);
  $password = sanitizeInput($_POST['pwd']);
  $cpassword = sanitizeInput($_POST['cpwd']);
  $nama = sanitizeInput($_POST['nama']);
  $staffStatus = sanitizeInput($_POST['staffStatus']);

  function encryptString($string) {
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '2003050612345678';
    $encryption_key = "CINEMAMANAGEMENTSYSTEM";
    // Encrypt the string
    $encrypted_string = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv);
    return $encrypted_string;
  }

  // Password policy
  $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

  // Validate password
  if (!preg_match($passwordPattern, $password)) {
    echo "<script>document.getElementById('passwordError').innerText = 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.';</script>";
  } elseif ($password !== $cpassword) {
    echo "<script>document.getElementById('confirmPasswordError').innerText = 'Passwords do not match!';</script>";
  } else {
    // Encrypt the password
    $encrypted_password = encryptString($password);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM staff WHERE staffID = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "Username already exists...Please choose another username";
    } else {
      // Prepare the SQL statement for insertion
      $stmt = $conn->prepare("INSERT INTO staff (staffID, staffpassword, name, staffStatus) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $username, $encrypted_password, $nama, $staffStatus);
      $result = $stmt->execute();

      if ($result) {
        echo "<script>alert('Successful')</script>";
        header('Refresh: 0; url=user_list.php');
      } else {
        echo "<script>alert('Failed')</script>";
        header('Refresh: 0; url=user_list.php');
      }
    }
  }
}
mysqli_close($conn);
?>
