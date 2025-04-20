<?php
// Include database connection
include '../Components/DatabaseConnection.php';

// Check if `member_id` is set in the URL
if (isset($_GET['member_id'])) {
    $member_id = intval($_GET['member_id']); // Securely get the member_id

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM memberregister WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    
    if ($stmt->execute()) {
        // If deletion is successful, redirect with success message
        header("Location: ManageMembers.php?success=Member deleted successfully.");
        exit();
    } else {
        // If deletion fails, redirect with error message
        header("Location: ManageMembers.php?error=Failed to delete member.");
        exit();
    }
    $stmt->close(); // Close the statement
} else {
    // If `member_id` is not set, redirect with an error message
    header("Location: ManageMembers.php?error=No member selected.");
    exit();
}
?>
