<?php
// Include database connection
include '../Components/DatabaseConnection.php'; 

// Get form data
$member_id = isset($_POST['member_id']) ? intval($_POST['member_id']) : 0;
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
$payment_status = 'Paid'; // Default payment status

// Check if all required fields are provided
if ($member_id > 0 && $amount > 0 && !empty($due_date)) {
    // Insert payment details into the payments table
    $sql = "INSERT INTO payments (member_id, training_type, period, amount, payment_date, due_date, payment_status) 
            VALUES (?, ?, ?, ?, NOW(), ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issdss', $member_id, $_POST['exercise_plan'], $_POST['payment_plan'], $amount, $due_date, $payment_status);
    
    if ($stmt->execute()) {
        // Payment inserted successfully
        echo "Payment successful! <a href='print_receipt.php?member_id=" . $member_id . "'>Print Receipt</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid input. Please try again.";
}
?>
