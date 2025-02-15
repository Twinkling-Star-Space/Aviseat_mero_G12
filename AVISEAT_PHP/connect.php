<?php
// Database connection parameters
include 'connect.php';                           // Default password for MySQL
$dbname = "seat_number"; // The name of the database you want to create or use

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");

if ($result->num_rows == 0) {
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Your Seat database recently createad";
    } else {
        echo "Error creating database: " . $conn->error;
    }
} else {
    echo "Your Seat database already exists";
}
$conn->select_db($dbname);

$conn->close();
?>