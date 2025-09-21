<?php
// Database connection
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
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

    // Validation
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

    // Insert data
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
        // Get the last inserted ID
        $last_id = $stmt->insert_id;

        // Fetch the inserted ticket
        $result = $conn->query("SELECT * FROM passengerbooking WHERE id = $last_id");

        if ($result && $row = $result->fetch_assoc()) {
            // Display ticket
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Your Ticket</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background: #f4f4f4;
                        display: flex;
                        justify-content: center;
                        padding: 40px;
                    }

                    .ticket {
                        background: #fff;
                        padding: 30px 40px;
                        border: 2px dashed #333;
                        width: 500px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }

                    .ticket h2 {
                        margin-top: 0;
                        text-align: center;
                        color: #0059b3;
                    }

                    .ticket-info {
                        margin-top: 20px;
                        font-size: 16px;
                        line-height: 1.8;
                    }

                    .label {
                        font-weight: bold;
                    }

                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 14px;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class="ticket">
                    <h2>🎟️ Travel Ticket</h2>
                    <div class="ticket-info">
                        <div><span class="label">Passenger:</span> <?= htmlspecialchars($row['PassengerName']) ?></div>
                        <div><span class="label">Age:</span> <?= htmlspecialchars($row['Age']) ?></div>
                        <div><span class="label">Citizenship:</span> <?= htmlspecialchars($row['Citizen']) ?></div>
                        <div><span class="label">Email:</span> <?= htmlspecialchars($row['Email']) ?></div>
                        <div><span class="label">Phone:</span> <?= htmlspecialchars($row['Phone']) ?></div>
                        <div><span class="label">Departure:</span> <?= htmlspecialchars($row['Departure']) ?></div>
                        <div><span class="label">Arrival:</span> <?= htmlspecialchars($row['Arrival']) ?></div>
                        <div><span class="label">Seats:</span> <?= htmlspecialchars($row['Seats']) ?></div>
                        <div><span class="label">Class:</span> <?= htmlspecialchars($row['Class']) ?></div>
                        <div><span class="label">Payment Method:</span> <?= htmlspecialchars($row['PaymentMethod']) ?></div>
                        <div><span class="label">Booking ID:</span> <?= htmlspecialchars($row['id']) ?></div>
                    </div>
                    <div class="footer">
                        Thank you for booking with us!
                    </div>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "✅ Booking successful, but failed to fetch ticket details.";
        }
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
