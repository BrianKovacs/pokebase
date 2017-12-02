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
$username = $add = $add_err = "";
$user_ID = trim($_SESSION["user_ID"]);

// Get username
// Prepare a select statement
$sql = "SELECT Name FROM Trainer WHERE ID = ?";

if($stmt = mysqli_prepare($link, $sql)){
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "s", $param_user_ID);

  // Set parameters
  $param_user_ID = $user_ID;

  // Attempt to execute the prepared statement
  if(mysqli_stmt_execute($stmt)){
    // Store result
    mysqli_stmt_store_result($stmt);

    // Check if username exists, if yes then verify password
    if(mysqli_stmt_num_rows($stmt) == 1){
      // Bind result variables
      mysqli_stmt_bind_result($stmt, $username);
      mysqli_stmt_fetch($stmt);
    } else{
      // Display an error message if username doesn't exist
      $username_err = 'No account found with that username.';
    }
  } else{
    echo "Oops! Something went wrong. Please try again later.";
  }
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(empty(trim($_POST["add"]))){
    $add_err = 'Please enter a Pokémon.';
  } else{
    $add = trim($_POST["add"]);
  }

  // Validate Pokemon name
  if(empty($add_err)) {
    // Prepare a select statement
    $sql = "SELECT Name FROM Pokemon WHERE Name = ?";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_add);
      // Set parameters
      $param_add = $add;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1) {
          // Close statement
          mysqli_stmt_close($stmt);

          // Add Pokemon to Team
          $sql = "INSERT INTO Team (Pokemon_ID, Trainer_ID) SELECT Pokemon.ID, Trainer.ID FROM Pokemon, Trainer WHERE Pokemon.Name = ? AND Trainer.ID = ?";

          if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_add, $param_user_ID);
            // Set parameters
            $param_add = $add;
            $param_user_ID = $user_ID;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              // Store result
              //echo "Pokemon added!";
              $add = "";
            } else {
              echo $sql; // "Could not add pokemon.";
            }
          }

        } else{
          // Display an error message if username doesn't exist
          $add_err = 'Please enter a valid Pokémon name.';
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }
    // Close statement
    mysqli_stmt_close($stmt);
  }
}
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
        <a href="complement.php" class="w3-bar-item w3-button">Complement</a>
        <a href="hm.php" class="w3-bar-item w3-button">HM</a>
        <a href="logout.php" class="w3-bar-item w3-button" style="float:right;">Sign Out</a>
      </div>
    </div>

    <h1 style="text-align:center"><b><?php echo $username; ?></b>'s Pokémon</h1>
    <hr>

    <div class="w3-card-4 w3-white" style='margin:auto; width:700px;'>
      <?php
      // Prepare a select statement
      $sql = "SELECT Pokemon.Name, Will_Trade, UPID FROM Team, Pokemon WHERE Trainer_ID = ? AND Pokemon.ID = Team.Pokemon_ID";

      if($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_ID);

        // Set parameters
        $param_user_ID = trim($_SESSION["user_ID"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          // Store result
          mysqli_stmt_store_result($stmt);
          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3);
          print "<table class='w3-table w3-bordered'>";
          print "<tr align = 'center' class='w3-blue'>";
          print "<th colspan='2' style='text-align:center;'>Pokémon</th>";
          print "<th>Will trade?</th>";
          print "<th>Remove</th>";
          print "</tr>";
          while (mysqli_stmt_fetch($stmt)) {
            print "<tr style='vertical-align:middle; height:75px;'>";
            print "<td><img height='75px' src='images/pokemon/" . $col1 . ".jpg'></td> ";
            print "<td style='vertical-align:middle; text-align:left;'>" . $col1 . "</td> ";
            // print "<td style='vertical-align:middle;'>";
            // echo ($col2 == '1') ? 'Yes' : 'No';
            // print "</td> ";
            print "<td style='vertical-align:middle;'> <form action='toggle-trade.php' method='post'> <input type='hidden' value='" . $col2 . "' name='trade' /> <input type='hidden' value='" . $col3 . "' name='upid' /> <button type='submit' class='w3-button w3-xlarge w3-circle w3-white' value='Submit'><i class='";
            echo ($col2 == '1') ? 'fa fa-check-square-o' : 'fa fa-square-o';
            print "' style='font-size:24px'></i></button></form> </td> ";
            print "<td style='vertical-align:middle;'> <form action='remove.php' method='post'> <input type='hidden' value='" . $col3 . "' name='upid' /> <button type='submit' class='w3-button w3-xlarge w3-circle w3-white' value='Submit'><i class='fa fa-remove' style='font-size:24px'></i></button></form> </td> ";
            print "</tr>";
          }
          print "</table>";

        } else{
          echo "Oops! Something went wrong. Please try again later.";
        }
        //class="form-group <?php echo (!empty($username_err)) ? 'has-error' : '';
      }
      ?>

      <form action="add.php" method="post">
        <div class="w3-container" style="padding:16px;">
          <label>Add:</label>
          <input type="text" name="add"class="form-control" value="<?php echo $add; ?>">
          <span class="help-block"><?php echo $add_err; ?></span>
        </div>
      </form>
    </div>

  </body>
</ht
