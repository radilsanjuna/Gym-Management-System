<?php
        include '../Components/DatabaseConnection.php';

        
if (isset($_POST['update_equipment'])) {
   

    // Get form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Update the equipment in the database
    $sql = "UPDATE gym_equipment 
            SET name='$name', type='$type', quantity='$quantity', description='$description' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Equipment updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect to the dashboard
    header("Location: admin_dashboard.php");
}
?>
