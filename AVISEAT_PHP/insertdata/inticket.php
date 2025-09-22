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

                    .pay-btn {
  text-align: center;
  margin-top: 30px;
}

.btn {
  padding: 2px 2px;
  background: #287ba7ff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background 0.3s ease;
  display:flex;
  justify-content:center;
  align-items:center;
  
}

.btn2 {
  padding: 4px 4px;
  background: #287ba7ff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background 0.3s ease;
  margin: 10px;
   display:flex;
  justify-content:center;
  align-items:center;
  border:none;
}

.btns{
    display:flex;
    flex-direction:horizontal;
  justify-content:center;
    gap:1pc;
    margin-top:1pc;

}

.company_details {
    text-align: center;
    padding: 10px 5px;
    background: linear-gradient(135deg, #e0f7fa, #ffffff);
    border-bottom: 2px solid #0077b6;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.company_name {
    font-size: 36px;
    color: #0077b6;
    margin-bottom: 10px;
    letter-spacing: 2px;
    font-weight: bold;
    text-transform: uppercase;
}

.ticket_title {
    font-size: 28px;
    color: #023e8a;
    margin-bottom: 10px;
}

.note {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    font-style: italic;
}

.wish {
    font-size: 15px;
    color: #555;
}






</style>
            </head>
            <body>
                <div class="ticket">
                   <div class="company_details">
    <h1 class="company_name">AVISEAT</h1>
    <h2 class="ticket_title">🎟️ Travel Ticket</h2>
    <p class="note">Please bring this ticket on your day of flight.</p>
    <p class="wish">Have a safe and joyous journey!</p>
</div>

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
                    <div class="btns">
                    <a href="../../payment.html?id=<?= $row['id'] ?>" class="btn">💳 Proceed to Payment</a>
             
                     <button class="btn2" onclick="printTicket()">🖨️ Print Ticket</button>
                    <button class="btn2" onclick="downloadPDF()">⬇️ Download Ticket</button>
                </div>
                </div>
                

                    <!-- Include jsPDF via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    // Print the ticket
    function printTicket() {
        const printContents = document.querySelector('.ticket').outerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload page to restore content
    }

    // Download ticket as PDF
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const ticket = document.querySelector('.ticket');

        // Use html2canvas to render the ticket to an image, then add to PDF
        await html2canvas(ticket).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            const imgProps = doc.getImageProperties(imgData);
            const pdfWidth = doc.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            doc.save("travel_ticket.pdf");
        });
    }
</script>

<!-- Add html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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
