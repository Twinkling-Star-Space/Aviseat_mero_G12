<?php
// Database connection parameters
include "../connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input data
    $card_type = htmlspecialchars(trim($_POST["cards"]));
    $card_number = htmlspecialchars(trim($_POST["Card_number"]));
    $amount = htmlspecialchars(trim($_POST["Amount"]));
    $payment_date = htmlspecialchars(trim($_POST["payment_date"]));
    $payment_reason = htmlspecialchars(trim($_POST["payment_reason"]));

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO payment_details (card_type, card_number, amount, payment_date, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $card_type, $card_number, $amount, $payment_date, $payment_reason);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Payment details inserted successfully.";
    } else {
        echo "Error inserting payment details: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>