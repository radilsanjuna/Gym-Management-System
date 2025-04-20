<?php
session_start();
include '../Components/DatabaseConnection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $class_name = $_POST['class_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $date = $_POST['date'];
    $trainer_id = $_POST['trainer_name'];

    // Insert data into the classes table
    $query = "INSERT INTO gym_classes (class_name, start_time, end_time, date, trainer_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $class_name, $start_time, $end_time, $date, $trainer_id);

    if ($stmt->execute()) {
        // Set success message and redirect
        $_SESSION['successMessage'] = "Class added successfully!";
    } else {
        // Handle error
        $_SESSION['successMessage'] = "Failed to add class. Please try again.";
    }

    // Redirect back to the form
    header('Location: add_gym_class.php');
    exit();
}
?>
