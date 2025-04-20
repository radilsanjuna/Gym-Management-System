<?php
include '../Components/DatabaseConnection.php';
include 'trainer_dashboard.php';

// Check if the ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Fetch the class data
    $stmt = $conn->prepare("SELECT * FROM gym_classes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $class = $result->fetch_assoc();
} else {
    // Redirect to the display page if no ID is provided
    header("Location: display_classes.php");
    exit();
}

// Fetch trainers from the database
$trainerQuery = "SELECT full_name FROM trainers";
$trainerResult = $conn->query($trainerQuery);

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['class_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $date = $_POST['date'];
    $trainer_name = $_POST['trainer_name'];

    // Prepare and bind the SQL statement for updating
    $stmt = $conn->prepare("UPDATE gym_classes SET class_name = ?, start_time = ?, end_time = ?, date = ?, trainer_name = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $class_name, $start_time, $end_time, $date, $trainer_name, $id);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        // Success message and redirect
        header("Location: add_class.php");
        exit();
    } else {
        // Error message
        echo "<div class='alert alert-danger' role='alert'>Error updating gym class: " . $stmt->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gym Class</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Gym Class</h2>
        <form action="edit_class.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="class_name">Class Name:</label>
                <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time:</label>
                <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo htmlspecialchars($class['start_time']); ?>" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time:</label>
                <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo htmlspecialchars($class['end_time']); ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($class['date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="trainer_name">Trainer Name:</label>
                <select class="form-control" id="trainer_name" name="trainer_name" required>
                    <option value="" disabled>Select Trainer</option>
                    <?php
                    if ($trainerResult->num_rows > 0) {
                        while ($trainer = $trainerResult->fetch_assoc()) {
                            $selected = ($trainer['full_name'] == $class['trainer_name']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($trainer['full_name']) . "' $selected>" . htmlspecialchars($trainer['full_name']) . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No trainers available</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Class</button>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
