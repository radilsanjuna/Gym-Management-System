<?php
// delete_announcement.php

include '../Components/DatabaseConnection.php';

if (isset($_GET['id'])) {
    $announcement_id = intval($_GET['id']);

    // Prepare and execute the SQL statement to delete the announcement
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $announcement_id);

    if ($stmt->execute()) {
        // Redirect back to the announcements list with a success message (optional)
        header('Location: add_announcement.php?message=Announcement deleted successfully');
        exit();
    } else {
        // Handle error
        echo "Error deleting announcement: " . $conn->error;
    }
} else {
    // If no ID is passed, redirect back with an error
    header('Location: add_announcement.php?message=Invalid request');
    exit();
}
