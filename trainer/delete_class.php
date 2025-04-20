<?php
session_start();
include '../Components/DatabaseConnection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL delete query
    $sql = "DELETE FROM gym_classes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Set success message and redirect back
        $_SESSION['successMessage'] = "Gym class successfully deleted.";
    } else {
        // If the query failed, you can set an error message here if desired
        $_SESSION['successMessage'] = "Error: Unable to delete gym class.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect to the manage gym classes page
header("Location: add_class.php");
exit;
?>
