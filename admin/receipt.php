<?php
// Include the database connection
include '../Components/DatabaseConnection.php';

// Get member_id from URL
$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;

if ($member_id > 0) {
    // Fetch member details
    $query = "SELECT m.username, m.exercise_plan, m.payment_plan, p.amount 
              FROM memberregister AS m
              LEFT JOIN payments AS p ON m.member_id = p.member_id
              WHERE m.member_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $member_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $member_data = $result->fetch_assoc();
                $username = $member_data['username'];
                $exercise_plan = $member_data['exercise_plan'];
                $payment_plan = $member_data['payment_plan'];
                $amount = $member_data['amount'] ? $member_data['amount'] : 0;
            } else {
                echo "No member found!";
                exit;
            }
        }
        $stmt->close();
    }
} else {
    echo "Invalid member ID!";
    exit;
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_payment'])) {
    $amount = $_POST['amount'];
    $payment_date = date('Y-m-d');

    // Insert payment into the database
    $insert_query = "INSERT INTO payments (member_id, amount, payment_date, payment_status) 
                     VALUES (?, ?, ?, 'paid')";
    $stmt = $conn->prepare($insert_query);
    if ($stmt) {
        $stmt->bind_param("ids", $member_id, $amount, $payment_date);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Payment successfully recorded.</div>";

            // Payment successful, show receipt
            $receipt_generated = true;
        } else {
            echo "<div class='alert alert-danger'>Error recording payment: " . $stmt->error . "</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <style>
        .receipt {
            display: none; /* Hide initially */
            border: 1px solid #000;
            padding: 20px;
            margin-top: 20px;
        }

        .receipt-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .receipt-body {
            font-size: 18px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 20px;
        }

        .print-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Make Payment</h1>

        <!-- Payment Form -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="training_type" class="form-label">Exercise Plan</label>
                <input type="text" class="form-control" id="training_type" value="<?php echo htmlspecialchars($exercise_plan); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="payment_plan" class="form-label">Payment Plan</label>
                <input type="text" class="form-control" id="payment_plan" value="<?php echo htmlspecialchars($payment_plan); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_payment">Submit Payment</button>
        </form>

        <!-- Receipt Section -->
        <?php if (isset($receipt_generated) && $receipt_generated) : ?>
        <div class="receipt" id="receipt">
            <div class="receipt-header">
                Payment Receipt
            </div>
            <div class="receipt-body">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Exercise Plan:</strong> <?php echo htmlspecialchars($exercise_plan); ?></p>
                <p><strong>Payment Plan:</strong> <?php echo htmlspecialchars($payment_plan); ?></p>
                <p><strong>Payment Amount:</strong> $<?php echo $amount; ?></p>
                <p><strong>Payment Date:</strong> <?php echo $payment_date; ?></p>
            </div>
            <div class="receipt-footer">
                Thank you for your payment!
            </div>
        </div>

        <!-- Print Receipt Button -->
        <button class="btn btn-secondary print-button" onclick="printReceipt()">Print Receipt</button>

        <script>
            function printReceipt() {
                var receipt = document.getElementById('receipt');
                receipt.style.display = 'block'; // Show receipt before printing
                window.print();
                receipt.style.display = 'none';  // Hide receipt after printing
            }
        </script>
        <?php endif; ?>
    </div>
</body>
</html>
