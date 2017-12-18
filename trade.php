<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION['user_ID']) || empty($_SESSION['user_ID'])) {
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$search = "";
$search_err = "";
$do_search = false;
$user_ID = trim($_SESSION["user_ID"]);

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty
  if (empty(trim($_POST["search"]))){
    $search_err = 'Please enter a Pokémon.';
  } else {
    $search = trim($_POST["search"]);
  }

  // Validate Pokemon name
  if (empty($search_err)) {
    // Prepare a select statement
    $sql = "SELECT Name FROM Pokemon WHERE Name = ?";

    if($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_search);
      // Set parameters
      $param_search = $search;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){
          $do_search = true;
        } else{
          // Display an error message if username doesn't exist
          $search_err = 'Please enter a valid Pokémon name.';
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
    <div class='w3-table w3-bordered'>
      <div class='w3-container w3-blue'>
        <h2>Trade Pokémon</h2>
      </div>

      <div >
        <form class="w3-container w3-light-grey" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <p>
            <label>Search for:</label>
            <input class="w3-input" type="text" name="search" value="<?php echo $search; ?>">
            <span class="help-block"><?php echo $search_err; ?></span>
          </p>
        </form>
      </div>

      <?php

      if ($do_search) {
        // Prepare a select statement
        $sql = "SELECT Trainer.Name, UPID FROM Trainer, Pokemon, Team WHERE Pokemon.Name=? AND Pokemon.ID = Pokemon_ID AND Trainer.ID = Trainer_ID AND Will_Trade='1';";

        if($stmt = mysqli_prepare($link, $sql)) {
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "s", $param_search);

          // Set parameters
          $param_search = $search;

          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) >= 1){
              // Create table
              mysqli_stmt_bind_result($stmt, $col1, $col2);
              print "<form class='w3-container w3-light-grey' action='do-trade.php' method='post'>";
              print "<div style='float:left; width:50%;'>";
              print "<p>Willing to trade " . $search . ":<br>";
              while (mysqli_stmt_fetch($stmt)) {
                print "&nbsp;&nbsp;<label><input type='radio' name='first' onclick='if ($(\"input[name=second]:checked\").length > 0) { document.getElementById(\"doTrade\").disabled = false; };' value='" . $col2 . "'</input> " . $col1 . "<br></label>";
              }
              print "</p></div>";
              print "<div style='float:left; width:50%;'>";
              print "<p>In exchange for:<br>";

              $sql = "SELECT Name, UPID FROM Pokemon, Team WHERE ID = Pokemon_ID AND Trainer_ID = ? AND Will_Trade = True;";
              if($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_user_ID);
                // Set parameters
                $param_user_ID = $user_ID;
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                  // Store result
                  mysqli_stmt_store_result($stmt);
                  if(mysqli_stmt_num_rows($stmt) >= 1){
                    mysqli_stmt_bind_result($stmt, $col1, $col2);
                    while (mysqli_stmt_fetch($stmt)) {
                      print "&nbsp;&nbsp;<label><input type='radio' name='second' onclick='if ($(\"input[name=first]:checked\").length > 0) { document.getElementById(\"doTrade\").disabled = false; };' value='" . $col2 . "'</input> " . $col1 . "<br></label>";
                    }
                  }
                  else {
                    print "<em>&nbsp;&nbsp;You don't have any tradable Pokémon!</em>";
                  }
                }
              }

              print "</p></div>";
              print "<p><input type='submit' id='doTrade' class='w3-input w3-button w3-blue' disabled='disabled' value='Initiate Trade'></p>";
              print "</form>";
            } else{
              // Display an error message if username doesn't exist
              print "<div class='w3-container w3-red'><h3>No trainers willing to trade " . $search . ".</h3></div>";
            }
          } else{
            echo "Oops! Something went wrong. Please try again later.";
          }
          // Close statement
          mysqli_stmt_close($stmt);
        }
      }
      ?>
    </div>

  </div>

  <?php
  // Close connection
  mysqli_close($link);
  ?>

</body>
</html>
