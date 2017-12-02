<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['user_ID']) || empty($_SESSION['user_ID'])){
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$username = "";
$user_ID = trim($_SESSION["user_ID"]);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-dark-grey" style="padding-top:50px;">

  <div class="w3-top">
    <div class="w3-bar w3-dark-grey">
      <a href="index.php" class="w3-bar-item w3-button">Home</a>
      <a href="test2.php" class="w3-bar-item w3-button">All Pokémon</a>
      <a href="add.php" class="w3-bar-item w3-button">My Pokémon</a>
      <a href="trade.php" class="w3-bar-item w3-button">Trade</a>
      <a href="logout.php" class="w3-bar-item w3-button" style="float:right;">Sign Out</a>
    </div>
  </div>

  <h1 style="text-align:center">Trade Pokémon</h1>
  <hr>

  <div class="w3-card-4 w3-white" style='margin:auto; width:700px;'>
    <?php

    // Prepare a select statement
    $sql =
    "SELECT
    	Defender, SUM(Multiplier) AS Result
    FROM
    	Effectiveness,
        (
    		SELECT
    			Has_Type.Type
    		FROM
    			Team, Has_Type
    		WHERE
    			Trainer_ID = ? AND Team.Pokemon_ID = Has_Type.Pokemon_ID
    	) R1
    WHERE
    	Attacker = R1.Type
    GROUP BY
    	Defender;";

    if($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_user_ID);

      // Set parameters
      $param_user_ID = $user_ID;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) >= 1){
          // Create table
          mysqli_stmt_bind_result($stmt, $col1, $col2);

          print "<table class='w3-table w3-bordered'>";
          print "<tr align = 'center' class='w3-blue'>";
          print "<th style='text-align:center;'>Type</th>";
          print "<th style='text-align:center;'>Effectiveness</th>";
          print "</tr>";
          while (mysqli_stmt_fetch($stmt)) {
            print "<tr align = 'center'>";
            print "<td>" . $col1 . "</td> ";
            print "<td>" . $col2 . "</td> ";
            print "</tr>";
          }
          print "</table>";
        } else{
          // Display an error message if username doesn't exist
          print "<div class='w3-container w3-red'><h3>No trainers willing to trade " . $search . ".</h3></div>";
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
      // Close statement
      mysqli_stmt_close($stmt);
      // Close connection
      mysqli_close($link);
    }
    ?>
  </div>
</body>
</html>
