<?php
// Include database connection
include '../Components/DatabaseConnection.php';
 include 'dashboard.php'; 

// Get the member_id from the URL
$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;

if ($member_id > 0) {
    // Fetch payment details for the user
    $sql = "SELECT m.username, p.training_type, p.period, p.amount, p.payment_date
            FROM memberregister AS m
            JOIN payments AS p ON m.member_id = p.member_id
            WHERE m.member_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment = $result->fetch_assoc();
    
    if (!$payment) {
        die('Payment not found');
    }
} else {
    die('Invalid member ID');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .receipt-container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .receipt-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .receipt-header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .receipt-details {
            margin-bottom: 30px;
        }
        .receipt-details p {
            font-size: 16px;
            margin: 8px 0;
        }
        .receipt-footer {
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        .btn-print {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-print:hover {
            background-color: #45a049;
        }
        @media print {
            .btn-print {
                display: none;
            }
            .receipt-container {
                width: 100%;
                margin: 0;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="receipt-header">
        <!-- Company Logo (optional) -->
        <img src="../img/logo.jpg" alt="Company Logo" style="max-width: 100px;">
        <h1>Payment Receipt</h1>
        <p><strong>FlexForge Gym</strong></p>
        <p><strong>Date:</strong> <?php echo date("F j, Y, g:i a"); ?></p>
    </div>

    <div class="receipt-details">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($payment['username']); ?></p>
        <p><strong>Training Type:</strong> <?php echo htmlspecialchars($payment['training_type']); ?></p>
        <p><strong>Period:</strong> <?php echo htmlspecialchars($payment['period']); ?></p>
        <p><strong>Amount Paid:</strong> $<?php echo number_format($payment['amount'], 2); ?></p>
        <p><strong>Payment Date:</strong> <?php echo htmlspecialchars($payment['payment_date']); ?></p>
    </div>

    <button class="btn-print" onclick="window.print()">Print</button>

    <div class="receipt-footer">
        <p>Thank you for your payment!</p>
        <p>Contact us: +1 234 567 890 | Email: info@gymmanagement.com</p>
    </div>
</div>

</body>
</html>
