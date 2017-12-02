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

/*
// Prepare a select statement
$sql = "SELECT * FROM Team WHERE Trainer_ID = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);

    // Set parameters
    $param_username = $_SESSION['username'];

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);


    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
}
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Pokemon</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body{ font: 14px sans-serif; text-align: center; }
    table {border-collapse: collapse;}
    th {padding: 15px; text-align: left;}
    td {padding: 5px; text-align: left;}
    th {background-color: #4CAF50; color: white;}
    tr:nth-child(even) {background-color: #f2f2f2}
  </style>
</head>
<body>
  <div class="page-header">
    <h1><b><?php echo $_SESSION['username']; ?></b>'s Pokémon.</h1>
  </div>
  <p><a href="index.html">Home</a></p>
  <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
  <hr>

  <?php
  // Prepare a select statement
  $sql = "SELECT Pokemon.Name, Time_Captured, Will_Trade FROM Team, Pokemon, Trainer WHERE Trainer.Name = ? AND Trainer.ID = Trainer_ID AND Pokemon.ID = Team.Pokemon_ID";

  if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = $_SESSION['username'];

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
          // Store result
          mysqli_stmt_store_result($stmt);
          echo "Hey there!";
          mysqli_stmt_bind_result($stmt, $col1, $col2, $col3);
          print "<table><caption> <h2> My Pokémon </h2> </caption>";
          print "<tr align = 'center'>";
          print "<th> Pokémon </th>";
          print "<th> Captured </th>";
          print "<th> Will trade? </th>";
          print "</tr>";
          while (mysqli_stmt_fetch($stmt)) {
            print "<tr align = 'center'>";
            print "<td>" . $col1 . "</td> ";
            print "<td>" . $col2 . "</td> ";
            print "<td>" . $col3 . "</td> ";
            print "</tr>";
          }
          print "</table>";

      } else{
          echo "Oops! Something went wrong. Please try again later.";
      }
  }
  ?>
</body>
</html>
