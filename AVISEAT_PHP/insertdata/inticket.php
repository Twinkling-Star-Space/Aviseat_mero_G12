<?php
// Database connection settings
include "../connect.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data safely
    $name = trim($_POST['PassengerName'] ?? '');
    $age = intval($_POST['Age'] ?? 0);
    $citizen = trim($_POST['citizen'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $departure = trim($_POST['departure'] ?? '');
    $arrival = trim($_POST['arrival'] ?? '');
    $seats = intval($_POST['seats'] ?? 0);
    $class = trim($_POST['class'] ?? '');
    $payment_method = trim($_POST['payment'] ?? '');

    // ---------------------------
    // Server-side validation
    // ---------------------------
    $errors = [];

    if (empty($name)) $errors[] = "Passenger name is required.";
    if ($age <= 0) $errors[] = "Age must be greater than 0.";
    if (empty($citizen)) $errors[] = "Citizenship is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) $errors[] = "Invalid phone number.";
    if (empty($departure)) $errors[] = "Departure location is required.";
    if (empty($arrival)) $errors[] = "Arrival location is required.";
    if ($seats <= 0) $errors[] = "Number of seats must be greater than 0.";
    if (!in_array($class, ['Economy', 'Business', 'First Class'])) $errors[] = "Invalid travel class.";
    if (!in_array($payment_method, ['Credit/Debit Card', 'Cash'])) $errors[] = "Invalid payment method.";

    if (!empty($errors)) {
        echo "Booking failed:<br>" . implode("<br>", $errors);
        exit;
    }

    // ---------------------------
    // Insert data into the database
    // ---------------------------
    $stmt = $conn->prepare("INSERT INTO passengerbooking 
        (PassengerName, Age, Citizen, Email, Phone, Departure, Arrival, Seats, Class, PaymentMethod) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "sissssisss",
        $name,
        $age,
        $citizen,
        $email,
        $phone,
        $departure,
        $arrival,
        $seats,
        $class,
        $payment_method
    );

    if ($stmt->execute()) {
        echo "✅ Ticket successfully booked!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
