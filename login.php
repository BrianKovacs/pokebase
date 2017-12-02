<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(empty(trim($_POST["username"]))){
    $username_err = 'Please enter username.';
  } else{
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if(empty(trim($_POST['password']))){
    $password_err = 'Please enter your password.';
  } else{
    $password = trim($_POST['password']);
  }

  // Validate credentials
  if(empty($username_err) && empty($password_err)){
    // Prepare a select statement
    $sql = "SELECT Name, Password, ID FROM Trainer WHERE Name = ?";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = $username;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $username, $hashed_password, $ID);
          if(mysqli_stmt_fetch($stmt)){
            if($password == $hashed_password){
              // if(password_verify($password, $hashed_password)){
              /* Password is correct, so start a new session and
              save the username to the session */
              session_start();
              $_SESSION['user_ID'] = $ID;
              header("location: index.php");
            } else{
              // Display an error message if password is not valid
              $password_err = 'The password you entered was not valid.';
            }
          }
        } else{
          // Display an error message if username doesn't exist
          $username_err = 'No account found with that username.';
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

  // Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-dark-grey" style="padding-top:100px;">

  <div class="w3-top">
    <div class="w3-bar w3-dark-grey">
      <a href="index.php" class="w3-bar-item w3-button">Home</a>
      <a href="test2.php" class="w3-bar-item w3-button">All Pokémon</a>
      <a href="add.php" class="w3-bar-item w3-button">My Pokémon</a>
      <a href="trade.php" class="w3-bar-item w3-button">Trade</a>
    </div>
  </div>

  <div class="w3-container" style="margin:auto; width:400px;">

    <div class="w3-card-4">
      <div class="w3-container w3-blue">
        <h2>Sign In</h2>
        <p>Please fill in your credentials.</p>
      </div>

      <form class="w3-container w3-light-grey" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <p>
          <label>Userame</label>
          <input class="w3-input" type="text" name="username" value="<?php echo $username; ?>">
          <span class="help-block"><?php echo $username_err; ?></span>
        </p>
        <p>
          <label>Password</label>
          <input class="w3-input" type="password" name="password" class="form-control">
          <span class="help-block"><?php echo $password_err; ?></span>
        </p>
        <p>
          <input type="submit" class="w3-input w3-button w3-blue" value="Submit">
        </p>
      </form>
    </div>
    <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
  </div>

</body>
</html>
