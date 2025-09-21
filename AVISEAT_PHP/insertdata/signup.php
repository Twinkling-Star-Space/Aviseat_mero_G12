<?php
include "../connect.php";

// Get POST data
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

// Basic validation
if ($password !== $confirm) {
  die("Passwords do not match.");
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO signup (fullname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullname, $email, $hashedPassword);

// Execute
if ($stmt->execute()) {
  echo "Account created successfully!";
} else {
  echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
