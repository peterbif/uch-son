<?php
$servername = "localhost";
$username = "root";
$password = "1245";
$dbname = "son";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
