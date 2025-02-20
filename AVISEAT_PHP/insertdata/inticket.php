<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ticketdata';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = htmlspecialchars($_POST['name'] ?? '');
    $age = htmlspecialchars($_POST['age'] ?? '');
    $citizen = htmlspecialchars($_POST['citizen'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $departure = htmlspecialchars($_POST['departure'] ?? '');
    $arrival = htmlspecialchars($_POST['arrival'] ?? '');
    $seats = htmlspecialchars($_POST['seats'] ?? '');
    $class = htmlspecialchars($_POST['class'] ?? '');
    $payment_method = htmlspecialchars($_POST['card'] ?? '');

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO tickets (name, age, citizen, email, phone, departure, arrival, seats, class, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssssss", $name, $age, $citizen, $email, $phone, $departure, $arrival, $seats, $class, $payment_method);

    if ($stmt->execute()) {
        echo "Ticket successfully booked!";
    } 
    else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
