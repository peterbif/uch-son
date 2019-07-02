<?php
$servername = "localhost";
$username = "peterbif";
$password = "pe12te34r";
$dbname = "employment";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>