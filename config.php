<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'db1.cs.uakron.edu:3306');
define('DB_USERNAME', 'bck25');
define('DB_PASSWORD', 'AusahL1e');
define('DB_NAME', 'DB_bck25');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
