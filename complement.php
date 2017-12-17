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

  @-webkit-keyframes fadeIn { from { width:0%; } to { width:100%; } }
  @-moz-keyframes fadeIn { from { width:0%; } to { width:100%; } }
  @keyframes fadeIn { from { width:0%; } to { width:100%; } }

  .fade-in {
    width:0%;  /* make things invisible upon start */
    -webkit-animation:fadeIn ease-out 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
    -moz-animation:fadeIn ease-out 1;
    animation:fadeIn ease-out 1;

    -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
    -moz-animation-fill-mode:forwards;
    animation-fill-mode:forwards;

    -webkit-animation-duration:0.5s;
    -moz-animation-duration:0.5s;
    animation-duration:0.5s;
  }

  .fade-in.delay1 {
    -webkit-animation-delay: 0.1s;
    -moz-animation-delay: 0.1s;
    animation-delay: 0.1s;
  }
  .fade-in.delay2 {
    -webkit-animation-delay: 0.2s;
    -moz-animation-delay: 0.2s;
    animation-delay: 0.2s;
  }
  .fade-in.delay3 {
    -webkit-animation-delay: 0.3s;
    -moz-animation-delay: 0.3s;
    animation-delay: 0.3s;
  }
  .fade-in.delay4 {
    -webkit-animation-delay: 0.4s;
    -moz-animation-delay: 0.4s;
    animation-delay: 0.4s;
  }
  .fade-in.delay5 {
    -webkit-animation-delay: 0.5s;
    -moz-animation-delay: 0.5s;
    animation-delay: 0.5s;
  }
  .fade-in.delay6 {
    -webkit-animation-delay: 0.6s;
    -moz-animation-delay: 0.6s;
    animation-delay: 0.6s;
  }
  .fade-in.delay7 {
    -webkit-animation-delay: 0.7s;
    -moz-animation-delay: 0.7s;
    animation-delay: 0.7s;
  }
  .fade-in.delay8 {
    -webkit-animation-delay: 0.8s;
    -moz-animation-delay: 0.8s;
    animation-delay: 0.8s;
  }
  .fade-in.delay9 {
    -webkit-animation-delay: 0.9s;
    -moz-animation-delay: 0.9s;
    animation-delay: 0.9s;
  }
  .fade-in.delay10 {
    -webkit-animation-delay: 1s;
    -moz-animation-delay: 1s;
    animation-delay: 1s;
  }
  .fade-in.delay11 {
    -webkit-animation-delay: 1.1s;
    -moz-animation-delay: 1.1s;
    animation-delay: 1.1s;
  }
  .fade-in.delay12 {
    -webkit-animation-delay: 1.2s;
    -moz-animation-delay: 1.2s;
    animation-delay: 1.2s;
  }
  .fade-in.delay13 {
    -webkit-animation-delay: 1.3s;
    -moz-animation-delay: 1.3s;
    animation-delay: 1.3s;
  }
  .fade-in.delay14 {
    -webkit-animation-delay: 1.4s;
    -moz-animation-delay: 1.4s;
    animation-delay: 1.4s;
  }
  .fade-in.delay15 {
    -webkit-animation-delay: 1.5s;
    -moz-animation-delay: 1.5s;
    animation-delay: 1.5s;
  }



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
  .bar-4 {width: 30%; height: 18px; }
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

  <h1 style="text-align:center">Complement</h1>
  <hr>


  <br>
  <div class="w3-card-4 w3-white" style='margin:auto; width:700px;' id="bars">
    <div class="w3-container w3-blue">
      <h2>Team Effectiveness</h2>
    </div>
    <div class="row" style="padding:20px;">
      <?php

      // Prepare a select statement
      $sql =
      "SELECT Defender, SUM(M) as Result FROM
      	(SELECT
      		UPID, Name, Defender, ROUND(EXP(SUM(LOG(Multiplier))),1) AS M
      	FROM
      		Effectiveness,
      		(SELECT
      			UPID, Name, Has_Type.Type
      		FROM
      			Team, Has_Type, Pokemon
      		WHERE
      			Trainer_ID = ? AND Team.Pokemon_ID = Has_Type.Pokemon_ID AND Team.Pokemon_ID = Pokemon.ID
      		) R1
      	WHERE
      		R1.Type = Effectiveness.Attacker
      	GROUP BY
      		UPID, Name, Defender) R2
      GROUP BY Defender;";

      if($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_user_ID);

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
            $count = 1;

            while (mysqli_stmt_fetch($stmt)) {
              if (is_null($col2))
                $col2 = 0;
              print
              "<div class='side'>
                <div>" . $col1 . "</div>
              </div>
              <div class='middle'>
                <div class='bar-container'>
                  <div class='bar-4' style='background:none; width: " . ($col2 / 0.24) . "%'><div class='bar-4 fade-in delay" . $count++ . " w3-";
                    if ($col2 >= 12) print "blue";
                    else if ($col2 >= 9) print "green";
                    else if ($col2 >= 6) print "yellow";
                    else if ($col2 >= 3) print "orange";
                    else print "red";
                  print "' style='width: 0%;'></div></div>
                </div>
              </div>
              <div class='side right'>
                <div>" . $col2 . "</div>
              </div>";
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
  </div>

</body>
</html>
