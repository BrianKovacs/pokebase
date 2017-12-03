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

$cut = $fly = $surf = $strength = $flash = $type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $cut = isset($_POST['cut']) ? "1" : "0";
  $fly = isset($_POST['fly']) ? "1" : "0";
  $surf = isset($_POST['surf']) ? "1" : "0";
  $strength = isset($_POST['strength']) ? "1" : "0";
  $flash = isset($_POST['flash']) ? "1" : "0";
  $type = trim($_POST['type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style media="screen" type="text/css">
  .toggle {
    display:none;
  }
  .toggle + label {
    display: inline-block;
    cursor: pointer;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    text-align: center;
    border-radius: 34px;
    padding: 3px 12px 4px;
  }

  input:checked + label {
    background-color: #2196F3;
    color: #FFF;
  }

  .select-style {
    border: 1px solid #ccc;
    width: 110px;
    border-radius: 3px;
    overflow: hidden;
    background: #fafafa url("img/icon-select.png") no-repeat 90% 50%;
  }

  .select-style select {
    padding: 0px 8px;
    position: relative;
    left: 10px;
    width: 100%;
    height: 40px;
    border: none;
    box-shadow: none;
    background: transparent;
    background-image: none;
    -webkit-appearance: none;
    cursor: pointer;
  }

  .select-style i {
    position: absolute;
    padding: 10px 0 0 85px;
    z-index: 1;
    pointer-events: none
  }

  .select-style select:focus {
    outline: none;
  }

  </style>
</head>
<body class="w3-dark-grey" style="padding-top:100px;">

  <div class="w3-top">
    <div class="w3-bar w3-dark-grey">
      <a href="index.php" class="w3-bar-item w3-button">Home</a>
      <a href="test2.php" class="w3-bar-item w3-button">All Pokémon</a>
      <a href="add.php" class="w3-bar-item w3-button">My Pokémon</a>
      <a href="trade.php" class="w3-bar-item w3-button">Trade</a>
      <a href="complement.php" class="w3-bar-item w3-button">Complement</a>
      <a href="hm.php" class="w3-bar-item w3-button">HM</a>
    </div>
  </div>

  <div class="w3-container" style="margin:auto; width:450px;">

    <div class="w3-card-4">
      <div class="w3-container w3-blue">
        <h2>Find HM</h2>
      </div>

      <form class="w3-container w3-light-grey" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
          <tr>
            <td>HM: </td>
            <td colspan="2">
              <p>
                <input type="checkbox" id="cut" name="cut" class="toggle" <?php if($cut) echo "checked" ?>>
                <label for="cut">Cut</label>
                <input type="checkbox" id="fly" name="fly" class="toggle" <?php if($fly) echo "checked" ?>>
                <label for="fly">Fly</label>
                <input type="checkbox" id="surf" name="surf" class="toggle" <?php if($surf) echo "checked" ?>>
                <label for="surf">Surf</label>
                <input type="checkbox" id="strength" name="strength" class="toggle" <?php if($strength) echo "checked" ?>>
                <label for="strength">Strength</label>
                <input type="checkbox" id="flash" name="flash" class="toggle" <?php if($flash) echo "checked" ?>>
                <label for="flash">Flash</label>
              </p>
            </td>
          </tr>
          <tr>
            <td>Type: </td>
            <td>
              <div class="select-style">
                <i class="fa fa-caret-down" style='font-size:14px'></i>
                <select name="type" value="<?php echo $type; ?>">
                  <option value="%%" <?php if($type == "%%") echo "selected" ?>>Any</option>
                  <option value="%Bug%" <?php if($type == "%Bug%") echo "selected" ?>>Bug</option>
                  <option value="%Dragon%" <?php if($type == "%Dragon%") echo "selected" ?>>Dragon</option>
                  <option value="%Electric%" <?php if($type == "%Electric%") echo "selected" ?>>Electric</option>
                  <option value="%Fighting%" <?php if($type == "%Fighting%") echo "selected" ?>>Fighting</option>
                  <option value="%Fire%" <?php if($type == "%Fire%") echo "selected" ?>>Fire</option>
                  <option value="%Flying%" <?php if($type == "%Flying%") echo "selected" ?>>Flying</option>
                  <option value="%Ghost%" <?php if($type == "%Ghost%") echo "selected" ?>>Ghost</option>
                  <option value="%Grass%" <?php if($type == "%Grass%") echo "selected" ?>>Grass</option>
                  <option value="%Ground%" <?php if($type == "%Ground%") echo "selected" ?>>Ground</option>
                  <option value="%Ice%" <?php if($type == "%Ice%") echo "selected" ?>>Ice</option>
                  <option value="%Normal%" <?php if($type == "%Normal%") echo "selected" ?>>Normal</option>
                  <option value="%Poison%" <?php if($type == "%Poison%") echo "selected" ?>>Poison</option>
                  <option value="%Psychic%" <?php if($type == "%Psychic%") echo "selected" ?>>Psychic</option>
                  <option value="%Rock%" <?php if($type == "%Rock%") echo "selected" ?>>Rock</option>
                  <option value="%Water%" <?php if($type == "%Water%") echo "selected" ?>>Water</option>
                </select>
              </div>
            </td>
            <td><p><input type="submit" class="w3-input w3-button w3-blue" value="Search"></p></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

  <?php
  // Processing form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // print "<p>" . $cut . "</p>";
    // print "<p>" . $fly . "</p>";
    // print "<p>" . $surf . "</p>";
    // print "<p>" . $strength . "</p>";
    // print "<p>" . $flash . "</p>";
    // print "<p>" . $type . "</p>";

    // Prepare a select statement
    $sql =
    "SELECT DISTINCT
    ID, Name
    FROM
    Has_Type,
    (
      SELECT
      ID, Name
      FROM
      Pokemon
      WHERE
      Cut >= ? AND Fly >= ? AND Surf >= ? AND Strength >= ? AND Flash >= ?
    ) R1
    WHERE
    Has_Type.Pokemon_ID = R1.ID AND Type LIKE ?";


    if($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "iiiiis", $param_cut, $param_fly, $param_surf, $param_strength, $param_flash, $param_type);
      // Set parameters
      $param_cut = $cut;
      $param_fly = $fly;
      $param_surf = $surf;
      $param_strength = $strength;
      $param_flash = $flash;
      $param_type = $type;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) >= 1){
          // print
          mysqli_stmt_bind_result($stmt, $col1, $col2);
          print "<br><div class='w3-card-4 w3-white' style='margin:auto; width:420px;'>";
          print "<table class='w3-table w3-bordered'>";
          print "<tr align = 'center' class='w3-blue'>";
          print "<th colspan='2' style='text-align:center;'>Pokémon</th>";
          print "</tr>";
          while (mysqli_stmt_fetch($stmt)) {
            print "<tr style='vertical-align:middle; height:75px;'>";
            print "<td><img height='75px' src='images/pokemon/" . $col2 . ".jpg'></td> ";
            print "<td style='vertical-align:middle; text-align:left;'>" . $col2 . "</td> ";
            print "</tr>";
          }
          print "</table></div>";
        } else{
          print "<br><div class='w3-container' style='margin:auto; width:420px;'>";
          print "<p>No results</p>";
          print "</div>";
        }
      }
      // Close statement
      mysqli_stmt_close($stmt);
    }
  }
  ?>

</body>
</html>
