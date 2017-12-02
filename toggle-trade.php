<?php
// Include config file
require_once 'config.php';
// header("location: login.php");
// exit;

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$trade = "";
$upid = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(!empty(trim($_POST["trade"]))){
    $trade = trim($_POST["trade"]);
  }
  if(!empty(trim($_POST["upid"]))){
    $upid = trim($_POST["upid"]);
  }

  // Toggle trade2
  if ($trade == 0)
    $trade = '1';
  else
    $trade = '0';

  $sql = "UPDATE Team SET Will_Trade = ? WHERE UPID = ?";
  echo $sql;
  echo $trade;
  echo $upid;

  if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ss", $param_trade, $param_upid);
    // Set parameters
    $param_trade = $trade;
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
