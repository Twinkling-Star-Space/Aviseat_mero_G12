<?php
$servername="localhost";               // Database connection parameter
$username="root"; // The name of the database you want to create or use
$password ="";
// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    echo "Your server Connected successfully";
}
$conn->close();
?>