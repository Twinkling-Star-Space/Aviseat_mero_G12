<?php
// Database connection parameters
$servername = "localhost"; // Server name (usually 'localhost' in XAMPP)
$username = "root";         // Default username for XAMPP
$password = "";             // Default password for XAMPP is empty
$dbname = "seat_number";    // Name of the database you want to create

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Your server connected successfully.<br>";

// SQL query to create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the connection (only after all queries are executed)
$conn->close();
?>