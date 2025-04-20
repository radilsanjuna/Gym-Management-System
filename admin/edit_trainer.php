<?php
include '../Components/DatabaseConnection.php';

// Get the trainer ID from the URL query string
if (isset($_GET['id'])) {
    $trainer_id = $_GET['id'];

    // Prepare and execute a SQL query to fetch the trainer's details
    $stmt = $conn->prepare("SELECT * FROM trainers WHERE trainer_id = ?");
    $stmt->bind_param("i", $trainer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a trainer was found
    if ($result->num_rows > 0) {
        $trainer = $result->fetch_assoc();
    } else {
        echo "No trainer found with the given ID.";
        exit;
    }

    // Close the statement
    $stmt->close();
}

// Handle form submission for updating trainer details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $date_of_birth = $_POST['date_of_birth'];
    $specialization = trim($_POST['specialization']);
    $years_of_experience = (int) trim($_POST['years_of_experience']);
    $certifications = trim($_POST['certifications']);
    $availability = $_POST['availability'];

    // Prepare SQL query for updating the trainer's details
    $update_stmt = $conn->prepare("UPDATE trainers SET full_name = ?, username = ?, email = ?, phone_number = ?, address = ?, date_of_birth = ?, specialization = ?, years_of_experience = ?, certifications = ?, availability = ? WHERE trainer_id = ?");
    
    // Bind the parameters
    $update_stmt->bind_param("ssssssssssi", $full_name, $username, $email, $phone_number, $address, $date_of_birth, $specialization, $years_of_experience, $certifications, $availability, $trainer_id);
    
    // Execute the update statement
    if ($update_stmt->execute()) {
        echo "Trainer details updated successfully!";
    } else {
        echo "Error updating trainer: " . $conn->error;
    }

    // Close the update statement
    $update_stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trainer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: auto;
            padding: 20px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Edit Trainer Details</h2>
    <form action="" method="post">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $trainer['full_name']; ?>" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $trainer['username']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $trainer['email']; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="tel" id="phone_number" name="phone_number" value="<?php echo $trainer['phone_number']; ?>">

        <label for="address">Address:</label>
        <textarea id="address" name="address"><?php echo $trainer['address']; ?></textarea>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $trainer['date_of_birth']; ?>">

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" value="<?php echo $trainer['specialization']; ?>">

        <label for="years_of_experience">Years of Experience:</label>
        <input type="number" id="years_of_experience" name="years_of_experience" value="<?php echo $trainer['years_of_experience']; ?>" min="0">

        <label for="certifications">Certifications:</label>
        <textarea id="certifications" name="certifications"><?php echo $trainer['certifications']; ?></textarea>

        <label for="availability">Availability:</label>
        <select id="availability" name="availability">
            <option value="weekdays" <?php if ($trainer['availability'] == 'weekdays') echo 'selected'; ?>>Weekdays</option>
            <option value="weekends" <?php if ($trainer['availability'] == 'weekends') echo 'selected'; ?>>Weekends</option>
            <option value="both" <?php if ($trainer['availability'] == 'both') echo 'selected'; ?>>Both</option>
        </select>

        <button type="submit">Update Trainer</button>
    </form>
</body>
</html>
