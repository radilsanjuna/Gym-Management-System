<?php
include '../Components/DatabaseConnection.php';

$message = ''; // Variable to hold the message

// Check if the trainer ID is provided in the URL
if (isset($_GET['id'])) {
    $trainer_id = $_GET['id'];

    // Prepare SQL DELETE query (update 'id' to the actual column name in your table)
    $sql = "DELETE FROM trainers WHERE trainer_id = ?"; // Change 'trainer_id' to match your actual column name
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trainer_id);

    // Execute the query and check if the deletion was successful
    if ($stmt->execute()) {
        // If successful, store success message
        $message = "Trainer deleted successfully.";
    } else {
        // If there was an error during deletion, store error message
        $message = "Error deleting trainer: " . $conn->error;
    }

    $stmt->close();
} else {
    $message = "No trainer ID provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Trainer</title>
    <style>
        /* Simple styling for the message */
        .message {
            padding: 10px;
            margin: 20px 0;
            font-size: 18px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <h1>Delete Trainer</h1>

    <!-- Display the message -->
    <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

</body>
</html>
