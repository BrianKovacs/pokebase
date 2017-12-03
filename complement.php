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
  <style media="screen" type="text/css">

  /* Three column layout */
  #bars * {
    box-sizing: border-box;
  }

  .side {
    float: left;
    width: 15%;
    margin-top:10px;
  }

  .middle {
    margin-top:10px;
    float: left;
    width: 70%;
  }

  /* Place text to the right */
  .right {
    text-align: right;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* The bar container */
  .bar-container {
    width: 100%;
    background-color: #f1f1f1;
    text-align: center;
    color: white;
  }

  /* Individual bars */
  .bar-5 {width: 60%; height: 18px; background-color: #4CAF50;}
  .bar-4 {width: 30%; height: 18px; background-color: #2196F3;}
  .bar-3 {width: 10%; height: 18px; background-color: #00bcd4;}
  .bar-2 {width: 4%; height: 18px; background-color: #ff9800;}
  .bar-1 {width: 15%; height: 18px; background-color: #f44336;}

  /* Responsive layout - make the columns stack on top of each other instead of next to each other */
  @media (max-width: 400px) {
    .side, .middle {
        width: 100%;
    }
    .right {
        display: none;
    }
  }
  </style>
</head>
<body class="w3-dark-grey" style="padding-top:50px;">

  <div class="w3-top">
    <div class="w3-bar w3-dark-grey">
      <a href="index.php" class="w3-bar-item w3-button">Home</a>
      <a href="test2.php" class="w3-bar-item w3-button">All Pokémon</a>
      <a href="add.php" class="w3-bar-item w3-button">My Pokémon</a>
      <a href="trade.php" class="w3-bar-item w3-button">Trade</a>
      <a href="complement.php" class="w3-bar-item w3-button">Complement</a>
      <a href="hm.php" class="w3-bar-item w3-button">HM</a>
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

  <br>
  <div class="w3-card-4 w3-white" style='margin:auto; width:700px;' id="bars">
    <div class="row">
      <div class="side">
        <div>5 star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-5"></div>
        </div>
      </div>
      <div class="side right">
        <div>150</div>
      </div>
      <div class="side">
        <div>4 star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-4"></div>
        </div>
      </div>
      <div class="side right">
        <div>63</div>
      </div>
      <div class="side">
        <div>3 star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-3"></div>
        </div>
      </div>
      <div class="side right">
        <div>15</div>
      </div>
      <div class="side">
        <div>2 star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-2"></div>
        </div>
      </div>
      <div class="side right">
        <div>6</div>
      </div>
      <div class="side">
        <div>1 star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
          <div class="bar-1"></div>
        </div>
      </div>
      <div class="side right">
        <div>20</div>
      </div>
    </div>
  </div>

</body>
</html>
