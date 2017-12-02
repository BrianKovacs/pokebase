<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['user_ID']) || empty($_SESSION['user_ID'])){
  header("location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PokeBase PHP Test</title>
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

<?php
require_once 'config.php';

// Prepare a select statement
$sql = "SELECT * FROM Pokemon";

if($stmt = mysqli_prepare($link, $sql)) {

  // Attempt to execute the prepared statement
  if(mysqli_stmt_execute($stmt)){
    // Store result
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13);
    print "<table style='margin:auto;' class='w3-table w3-card-4 w3-white w3-bordered'>";
    print "<tr align = 'center' class='w3-blue'>";
    print "<th colspan='2'>Pokémon</th>";
    print "<th>HP</th>";
    print "<th>Attack</th>";
    print "<th>Defense</th>";
    print "<th>Sp_Attack</th>";
    print "<th>Sp_Defense</th>";
    print "<th>Speed</th>";
    print "<th>Cut</th>";
    print "<th>Fly</th>";
    print "<th>Surf</th>";
    print "<th>Strength</th>";
    print "<th>Flash</th>";
    print "</tr>";
    while (mysqli_stmt_fetch($stmt)) {
      print "<tr>";
      print "<td><img height='32px' src='images/pokemon/" . $col2 . ".jpg'></td> ";
      print "<td>" . $col2 . "</td> ";
      print "<td>" . $col3 . "</td> ";
      print "<td>" . $col4 . "</td> ";
      print "<td>" . $col5 . "</td> ";
      print "<td>" . $col6 . "</td> ";
      print "<td>" . $col7 . "</td> ";
      print "<td>" . $col8 . "</td> ";
      print "<td>" . $col9 . "</td> ";
      print "<td>" . $col10 . "</td> ";
      print "<td>" . $col11 . "</td> ";
      print "<td>" . $col12 . "</td> ";
      print "<td>" . $col13 . "</td> ";
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
