<?php

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
    cursor: pointer;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
    text-align: center;
    border-radius: 34px;
    padding: 2px 6px 3px;
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

  <div class="w3-container" style="margin:auto; width:400px;">

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
                <input type="checkbox" id="Cut" class="toggle">
                <label for="Cut">Cut</label>
                <input type="checkbox" id="Fly" class="toggle">
                <label for="Fly">Fly</label>
                <input type="checkbox" id="Surf" class="toggle">
                <label for="Surf">Surf</label>
                <input type="checkbox" id="Strengeth" class="toggle">
                <label for="Strengeth">Strength</label>
                <input type="checkbox" id="Flash" class="toggle">
                <label for="Flash">Flash</label>
              </p>
            </td>
          </tr>
          <tr>
            <td>Type: </td>
            <td>
              <div class="select-style">
                <i class="fa fa-caret-down" style='font-size:14px'></i>
                <select class="" name="">
                  <option value="%%">Any</option>
                  <option value="%Bug%">Bug</option>
                  <option value="%Dragon%">Dragon</option>
                  <option value="%Electric%">Electric</option>
                  <option value="%Fighting%">Fighting</option>
                  <option value="%Fire%">Fire</option>
                  <option value="%Flying%">Flying</option>
                  <option value="%Ghost%">Ghost</option>
                  <option value="%Grass%">Grass</option>
                  <option value="%Ground%">Ground</option>
                  <option value="%Ice%">Ice</option>
                  <option value="%Normal%">Normal</option>
                  <option value="%Poison%">Poison</option>
                  <option value="%Psychic%">Psychic</option>
                  <option value="%Rock%">Rock</option>
                  <option value="%Water%">Water</option>
                </select>
              </div>
            </td>
            <td><p><input type="submit" class="w3-input w3-button w3-blue" value="Search"></p></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

</body>
</html>
