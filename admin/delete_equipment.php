<?php
if (isset($_GET['id'])) {
    include '../Components/DatabaseConnection.php';

    // Get the ID from URL
    $id = $_GET['id'];

    // Delete the equipment
    $sql = "DELETE FROM gym_equipment WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Equipment deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect to the dashboard
    header("Location: view_equipment.php");
}
?>
