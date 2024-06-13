<?php
$servername = "localhost";
$username = "root"; // change to your database username
$password = ""; // change to your database password
$dbname = "Assignment1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
