<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'paymentdata';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table
$sql = "CREATE TABLE IF NOT EXISTS payment_details (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    card_type VARCHAR(50) NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_date DATE NOT NULL,
    reason VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'payment_details' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>
