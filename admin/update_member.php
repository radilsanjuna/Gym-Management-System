<?php
include '../Components/DatabaseConnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'member_id' exists in the POST request
    if (!isset($_POST['member_id'])) {
        header("Location: ManageMembers.php?error=No member ID provided.");
        exit();
    }

    $member_id = intval($_POST['member_id']); // Use member_id for consistency
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $exercise_plan = htmlspecialchars(trim($_POST['exercise_plan']));
    $payment_plan = htmlspecialchars(trim($_POST['payment_plan']));

    // Update the member data in the database
    $stmt = $conn->prepare("UPDATE MemberRegister SET fullname = ?, username = ?, dob = ?, gender = ?, contact = ?, email = ?, address = ?, exercise_plan = ?, payment_plan = ? WHERE member_id = ?");

    // Bind the parameters correctly
    $stmt->bind_param("sssssssssi", $fullname, $username, $dob, $gender, $contact, $email, $address, $exercise_plan, $payment_plan, $member_id);

    if ($stmt->execute()) {
        header("Location: ManageMembers.php?success=Member updated successfully.");
        exit();
    } else {
        // Capture and log the error message for debugging
        $error = $stmt->error;
        header("Location: ManageMembers.php?error=Failed to update member. Error: $error");
        exit();
    }
}
?>
