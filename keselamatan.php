<?php
// Set the timeout duration (e.g., 15 minutes)
$timeout_duration = 10;

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check if the last activity timestamp is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the time elapsed since the last activity
    $elapsed_time = time() - $_SESSION['last_activity'];

    // If the elapsed time exceeds the timeout duration, log out the user and redirect to timeout page
    if ($elapsed_time > $timeout_duration) {
        session_destroy();
        header("Location: timeout.php");
        exit();
    }
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();
?>
