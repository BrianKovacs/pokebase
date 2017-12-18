<?php

// Include config file
require_once 'config.php';

// Initialize the session
session_start();

if (!isset($_SESSION['user_ID']) || empty($_SESSION['user_ID'])) {
  header("location: login.php");
  exit;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

  $user_ID = trim($_SESSION["user_ID"]);

  // Delete the current user's account.
  $sql = "DELETE FROM Trainer WHERE ID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $user_ID);
  if (!mysqli_stmt_execute($stmt)) {
    echo 'Error: Please try again later.';
  }
  mysqli_stmt_close($stmt);
  // Unset all of the session variables
  $_SESSION = array();
  // Destroy the session.
  session_destroy();
  // Redirect to login page
  header("location: login.php");
  exit;

} else {
  header("location: index.php");
  exit;
}

?>
