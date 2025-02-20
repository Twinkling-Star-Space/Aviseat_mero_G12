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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the seat number from the form
    $seat = $_POST["s1"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO seats (seat) VALUES (?)");
    $stmt->bind_param("s", $seat);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Seat number '$seat' inserted successfully.";
    } else {
        echo "Error inserting seat number '$seat': " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>