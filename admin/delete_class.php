<?php
include '../Components/DatabaseConnection.php';

// Check if the ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare and execute the SQL statement for deletion
    $stmt = $conn->prepare("DELETE FROM gym_classes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to the display page after deletion
        header("Location: add_class.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting gym class: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect to the display page if no ID is provided
    header("Location: display_classes.php");
    exit();
}

// Close the database connection
$conn->close();
?>
