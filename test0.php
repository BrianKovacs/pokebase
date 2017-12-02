<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PokeBase PHP Test</title>
    <style type = "text/css">
      html {font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;}
      table {border-collapse: collapse;}
      th {padding: 15px; text-align: left;}
      td {padding: 5px; text-align: left;}
      th {background-color: #4CAF50; color: white;}
      tr:nth-child(even) {background-color: #f2f2f2}
    </style>
  </head>
  <body>
<?php

// Connect to MySQL
//$db = mysql_connect("db1.cs.uakron.edu:3306", "xiaotest", "wpdb");
$db = mysqli_connect("db1.cs.uakron.edu:3306", "xiaotest", "wpdb");
//$db = mysqli_connect("db1.cs.uakron.edu:3306", "xiaotest", "wpdb","xiaotest");
if (!$db) {
 print "Error - Could not connect to MySQL";
 exit;
} else {
  print "<p>Connection good</p>";
}

// Select the database
$er = mysqli_select_db($db,"xiaotest");
if (!$er) {
  print "Error - Could not select the database";
  exit;
} else {
  print "<p>Selection good</p>";
}

// Final Display of All Entries
$query = "SELECT * FROM Corvettes";
$result = mysqli_query($db,$query);
if (!$result) {
  print "Error - the query could not be executed";
  $error = mysqli_error();
  print "<p>" . $error . "</p>";
  exit;
}

// Get the number of rows in the result, as well as the first row
//  and the number of fields in the rows
$num_rows = mysqli_num_rows($result);
//print "Number of rows = $num_rows <br />";

print "<table><caption> <h2> Cars ($num_rows) </h2> </caption>";
print "<tr align = 'center'>";

$row = mysqli_fetch_array($result);
$num_fields = mysqli_num_fields($result);

// Produce the column labels
$keys = array_keys($row);
for ($index = 0; $index < $num_fields; $index++)
  print "<th>" . $keys[2 * $index + 1] . "</th>";
print "</tr>";

// Output the values of the fields in the rows
for ($row_num = 0; $row_num < $num_rows; $row_num++) {
  print "<tr align = 'center'>";
  $values = array_values($row);
  for ($index = 0; $index < $num_fields; $index++){
    $value = htmlspecialchars($values[2 * $index + 1]);
    print "<td>" . $value . "</td> ";
  }
  print "</tr>";
  $row = mysqli_fetch_array($result);
}
print "</table>";

?>
  </body>
</html>
