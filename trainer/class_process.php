<?php 
session_start(); // Start the session
include '../Components/DatabaseConnection.php'; 

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $className = $_POST['class_name'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $date = $_POST['date'];
    $trainerName = $_POST['trainer_name'];

    // Your database insertion logic here
    // Example:
    $stmt = $conn->prepare("INSERT INTO gym_classes (class_name, start_time, end_time, date, trainer_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $className, $startTime, $endTime, $date, $trainerName);

    if ($stmt->execute()) {
        // Set success message in session
        $_SESSION['successMessage'] = "Gym class added successfully!";
    } else {
        $_SESSION['successMessage'] = "Error adding gym class.";
    }

    // Redirect back to the form
    header("Location: add_class.php");
    exit();
}
?>
