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
$search = "";
$search_err = "";
$do_search = false;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(empty(trim($_POST["search"]))){
    $search_err = 'Please enter a Pokémon.';
  } else{
    $search = trim($_POST["search"]);
  }

  // Validate Pokemon name
  if(empty($search_err)) {
    // Prepare a select statement
    $sql = "SELECT Name FROM Pokemon WHERE Name = ?";

    if($stmt = mysqli_prepare($link, $sql)){
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trade</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
  body{ font: 14px sans-serif;}
  table {border-collapse: collapse;}
  th {padding: 15px; text-align: left;}
  td {padding: 5px; text-align: left;}
  th {background-color: #4CAF50; color: white;}
  tr:nth-child(even) {background-color: #f2f2f2}
  .wrapper{ width: 350px; padding: 20px; }
  </style>
</head>
<body>
  <div style="text-align: center;">
    <div class="page-header">
      <h1>Trade Pokémon.</h1>
    </div>
    <p><a href="index.html">Home</a></p>
    <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
    <p>Search: <?php echo $search; ?></p>
  </div>

  <hr>
  <div class="wrapper">
    <form action="trade2.php" method="post">
      <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <label>Search for:</label>
        <input type="text" name="search"class="form-control" value="<?php echo $search; ?>">
        <span class="help-block"><?php echo $search_err; ?></span>
      </div>
    </form>
  </div>

  <div class="wrapper">
    <?php

    if ($do_search) {
      // Prepare a select statement
      $sql = "SELECT Name FROM Trainer WHERE ID = (SELECT Trainer_ID FROM Pokemon, Team WHERE Pokemon.Name=? AND Pokemon.ID = Pokemon_ID AND Will_Trade='1');";

      if($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_search);

        // Set parameters
        $param_search = $search;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
          // Store result
          mysqli_stmt_store_result($stmt);
          mysqli_stmt_bind_result($stmt, $col1);
          print "<table>";
          print "<tr align = 'center'>";
          print "<th>Willing to Trade</th>";
          print "</tr>";
          while (mysqli_stmt_fetch($stmt)) {
            print "<tr align = 'center'>";
            print "<td>" . $col1 . "</td> ";
            print "</tr>";
          }
          print "</table>";

        } else{
          echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
      }
    }
    ?>
  </div>

  <?php
  // Close connection
  mysqli_close($link);
  ?>

</body>
</html>
