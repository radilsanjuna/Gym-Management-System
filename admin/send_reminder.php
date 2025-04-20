<?php
include '../Components/DatabaseConnection.php'; // Include database connection

// Check if member_id is set
if (isset($_GET['member_id'])) {
    $member_id = (int)$_GET['member_id'];

    // Fetch the payment details for the selected member
    $sql = "SELECT due_date FROM payments WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
        $due_date = $payment['due_date'];

        // Create the notification message
        $message = "Your payment plan expires on " . date('Y-m-d', strtotime($due_date)) . ".";

        // Insert the notification into the notifications table
        $sql = "INSERT INTO notifications (member_id, message) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $member_id, $message);
        $stmt->execute();

        // Redirect back to the make payment page or show a success message
        header("Location: make_payment.php?notification=success");
        exit();
    } else {
        echo "No payment information found for this member.";
    }
} else {
    echo "Invalid member ID.";
}
?>
