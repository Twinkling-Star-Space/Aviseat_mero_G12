<?php
// Database connection parameters
$servername = "localhost"; // Server name (usually 'localhost' in XAMPP)
$username = "root";         // Default username for XAMPP
$password = "";             // Default password for XAMPP is empty
$dbname = "seat_number";    // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to the database successfully.<br>";

// SQL query to create the 'seats' table
$sql = "CREATE TABLE IF NOT EXISTS seats (
    seat_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    seat_number VARCHAR(10) NOT NULL UNIQUE
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table 'seats' created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>