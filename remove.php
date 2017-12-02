<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['userID']) || empty($_SESSION['userID'])){
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$upid = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(!empty(trim($_POST["upid"]))){
    $upid = trim($_POST["upid"]);
  }

  $sql = "DELETE FROM Team WHERE UPID = ?";

  if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_upid);
    // Set parameters
    $param_upid = $upid;

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){

      // Redirect to login page
      header("location: add.php");
      exit;
    }
    else {
      echo "Try again later";
    }
  }
}
?>
