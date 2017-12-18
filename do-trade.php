<?php

// Include config file
require_once 'config.php';

// Initialize the session
session_start();

if (!isset($_SESSION['user_ID']) || empty($_SESSION['user_ID'])) {
  header("location: login.php");
  exit;
}

$firstPokemon;
$firstTrainer;
$secondPokemon;
$secondTrainer;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST["first"])) && !empty(trim($_POST['second']))){

  // Get UPID for first and second Pokemon that will be traded.
  $firstPokemon = trim($_POST["first"]);
  $secondPokemon = trim($_POST["second"]);

  // Switch off auto commit to allow transactions
  mysqli_autocommit($link, FALSE);
  $query_success = TRUE;

  // Get the first trainer's ID
  $sql = "SELECT Trainer_ID FROM Team WHERE UPID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $firstPokemon);
  if (!mysqli_stmt_execute($stmt)) {
  $query_success = FALSE;
  }
  mysqli_stmt_bind_result($stmt, $firstTrainer);
  if (!mysqli_stmt_fetch($stmt)) {
  $query_success = FALSE;
  }
  mysqli_stmt_close($stmt);

  // Get the second trainer's ID
  $sql = "SELECT Trainer_ID FROM Team WHERE UPID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $secondPokemon);
  if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
  }
  mysqli_stmt_bind_result($stmt, $secondTrainer);
  if (!mysqli_stmt_fetch($stmt)) {
    $query_success = FALSE;
  }
  mysqli_stmt_close($stmt);

  // Make the first Pokemon belong to the second trainer
  $sql = "UPDATE Team SET Trainer_ID = ? WHERE UPID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'ii', $secondTrainer, $firstPokemon);
  if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
  }
  mysqli_stmt_close($stmt);

  // Make the second Pokemon belong to the first trainer
  $sql = "UPDATE Team SET Trainer_ID = ? WHERE UPID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'ii', $firstTrainer, $secondPokemon);
  if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
  }
  mysqli_stmt_close($stmt);

  // Make the first and second pokemon not tradable
  $sql = "UPDATE Team SET Will_Trade = '0' WHERE UPID = ? OR UPID = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, 'ii', $firstPokemon, $secondPokemon);
  if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
  }
  mysqli_stmt_close($stmt);

  // Commit or rollback transaction
  if ($query_success) {
    echo 'Success';
    mysqli_commit($link);
    header("location: add.php");
    exit;
  } else {
    echo 'Error: Please try again later.';
    mysqli_rollback($link);
  }

} else {
  echo 'Error: Unknown';
  header("location: trade.php");
  exit;
}

?>
