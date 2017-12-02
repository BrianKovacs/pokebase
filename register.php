<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Validate username
  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
  } else{
    // Prepare a select statement
    $sql = "SELECT ID FROM Trainer WHERE Name = ?";
    $stmt = mysqli_prepare($link, $sql);

    if($stmt){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = trim($_POST["username"]);

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $username_err = "This username is already taken.";
        } else{
          $username = trim($_POST["username"]);
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

  // Validate password
  if(empty(trim($_POST['password']))){
    $password_err = "Please enter a password.";
  } elseif(strlen(trim($_POST['password'])) < 6){
    $password_err = "Password must have atleast 6 characters.";
  } else{
    $password = trim($_POST['password']);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = 'Please confirm password.';
  } else{
    $confirm_password = trim($_POST['confirm_password']);
    if($password != $confirm_password){
      $confirm_password_err = 'Password did not match.';
    }
  }

  // Check input errors before inserting in database
  if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

    // Prepare an insert statement
    $sql = "INSERT INTO Trainer (Name, Password) VALUES (?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    if($stmt){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

      // Set parameters
      $param_username = $username;
      $param_password = $password; // Creates a password hash
      //$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Redirect to login page
        header("location: login.php");
      } else{
        echo "Something went wrong. Please try again later.";
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
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
      </div>

      <form class="w3-container w3-light-grey" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <p>
          <label>Userame</label>
          <input class="w3-input" type="text" name="username" value="<?php echo $username; ?>">
          <span class="help-block"><?php echo $username_err; ?></span>
        </p>
        <p>
          <label>Password</label>
          <input class="w3-input" type="password" name="password" class="form-control" value="<?php echo $password; ?>">
          <span class="help-block"><?php echo $password_err; ?></span>
        </p>
        <p>
          <label>Confirm Password</label>
          <input class="w3-input" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
          <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </p>
        <p>
          <input type="submit" class="w3-input w3-button w3-blue" value="Submit">
        </p>
      </form>
    </div>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </div>
      
</body>
</html>
