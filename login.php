<!DOCTYPE html>
<html>

<head>
  <title>MMU Cinemas Sdn Bhd</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

  <div id="header">
    <?php include('header.php'); ?>
  </div>
  <div id="wrapper">
    <div id="login">
      <ul>
        <li align="center"><a href="index.php">Home</a></li>
      </ul>
    </div>

    <div id="Borang">

      <center>
        <p>&nbsp;&nbsp;</p>
        <!--Menyediakan Borang Login-->
        <h1 style="color: black;">Login Form</h1>
        <div id="masuk">
          <form action="" method="POST">
            <table width="90%" border="0" cellpadding="15" cellspacing="20">
              <tr>
                <td align="right" style="color:black;">Staff ID:</td>
                <td><input type="text" name="username" required></td>
              </tr>
              <tr>
                <td align="right" style="color:black;">Password:</td>
                <td><input type="password" name="pwd" required></td>
              </tr>
              <tr>
                <td></td>
                <td align="left"><input type="submit" name="login_btn" value="Login"></td>
              </tr>
              <!--    <tr>
            <td></td>
            <td style="color: black" colspan="" align="left" ><a href="signup.php">Belum daftar? Klik sini</a></td>
          </tr>
      -->
            </table>
          </form>

          <?php
          session_start();

          // Connection to the database
          require_once('connection.php');

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

          // Function to sanitize user input
          function sanitizeInput($input)
          {
            return htmlspecialchars(strip_tags(trim($input)));
          }

          if (isset($_POST['login_btn'])) {
            $username = sanitizeInput($_POST['username']);
            $password = sanitizeInput($_POST['pwd']);
            $client_ip = $_SERVER['REMOTE_ADDR'];

            // Check if the client's IP address is allowed
            $stmt = $conn->prepare("SELECT * FROM ipaddress WHERE ipaddress = ? AND staffID = ?");
            $stmt->bind_param("ss", $client_ip, $username);
            $stmt->execute();
            $ip_check = $stmt->get_result();

            if ($ip_check->num_rows > 0) {
              // Prepare the SQL statement
              $stmt = $conn->prepare("SELECT * FROM staff WHERE staffID = ?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $query_run = $stmt->get_result();

              if ($query_run->num_rows > 0) {
                $row = $query_run->fetch_assoc();
                $decrypted_password = decryptString($row['staffpassword']);

                if ($password === $decrypted_password) {
                  // Correct password if statement

                  $_SESSION['username'] = $username;
                  $_SESSION['staffStatus'] = $row['staffStatus'];

                  // Update the app_current_user table 
                  $conn->query("TRUNCATE TABLE app_current_user");
                  // Clear the table 
                  $stmt = $conn->prepare("INSERT INTO app_current_user (username) VALUES (?)");
                  $stmt->bind_param("s", $username);
                  $stmt->execute();
                  echo "<script> alert ('Welcome $username')</script> ";
                  header('Refresh: 0; url=cinemakalla.php');
                } else {
                  // Else statement
                  echo "<script> alert ('Wrong Password Or No Such Account Exists')</script> ";
                }
              } else {
                echo "<script> alert ('Wrong Password Or No Such Account Exists')</script> ";
              }
            } else {
              echo "<script> alert ('Your IP address is not allowed to access this system')</script> ";
            }
            $stmt->close();
            mysqli_close($conn);
          }
          ?>

        </div>
        <p>&nbsp;&nbsp;</p>

      </center>

    </div>

  </div>

  <footer id="footer">
    <?php include('footer.php'); ?>
  </footer>

</body>

</div>

</html>
