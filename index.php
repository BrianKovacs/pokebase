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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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

  <h1 style="text-align:center">Hi, <b><?php echo $username; ?></b>.<br> Welcome to Pokébase.</h1>
  <hr>
  <p style="text-align:center;"><a href="logout.php" class="w3-button w3-blue" style="width:225px;">Sign Out</a></p>
  <p style="text-align:center;"><button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-red" style="width:225px;">Delete Account</button></p>

  <div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:500px;">
      <header class="w3-container w3-red">
        <span onclick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">&times;</span>
        <h2>Delete Account</h2>
      </header>
      <div class="w3-container w3-white">
        <h4><b><?php echo $username; ?></b>, you are about to permanetly delete your account. Are you sure you want to continue? If so, click the button below to delete your account. This action cannot be undone.</h4>
        <form action="delete.php" method="post">
          <p style="text-align:center;"><input type="submit" name="delete" value="Permanently Delete My Account" class="w3-button w3-red"></p>
        </form>
      </div>
      <footer class="w3-container w3-red">
        <p>Warning: <em>This will also delete all the Pokémon on your team!</em></p>
      </footer>
    </div>
  </div>

</body>
</html>
