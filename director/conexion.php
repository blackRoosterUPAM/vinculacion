<?php
$servername = "localhost";
$database = "vinculacion";
$username = "root";
$password = "galloUPAM2023.";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
;
?>
