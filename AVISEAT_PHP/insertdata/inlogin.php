<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Invalid request method.");
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';


// Validate inputs
if (!$username || !$password) {
    exit("All fields are required.");
}
if (strlen($password) < 6) {
    exit("Password must be at least 6 characters.");
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "diplal");
if ($conn->connect_error) {
    exit("Database connection failed: " . $conn->connect_error);
}

// Check if username already exists
$stmt = $conn->prepare("SELECT id FROM login_details WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    exit("Username/email already exists.");
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO login_details (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    // On success, redirect to login page with success flag
    header("Location: login.html?registered=1");
    exit();
} else {
    exit("Error during registration: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
