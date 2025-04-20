<?php 
session_start();
include '../Components/DatabaseConnection.php'; 
include 'dashboard.php';

$successMessage = '';

// Check for a success message in the session
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']);
}

// Fetch gym classes from the database
$sql = "SELECT * FROM gym_classes";
$result = $conn->query($sql);

// Fetch trainers from the database for the dropdown
$trainerSql = "SELECT trainer_id, full_name FROM trainers";
$trainersResult = $conn->query($trainerSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gym Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Form to Add a New Class -->
        <h2 class="text-center mb-4">Add Gym Class</h2>
        <form action="class_process.php" method="post">
            <div class="mb-3">
                <label for="class_name" class="form-label">Class Name:</label>
                <input type="text" class="form-control" id="class_name" name="class_name" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time:</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="end_time" class="form-label">End Time:</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="trainer_name" class="form-label">Trainer Name:</label>
                <select class="form-select" id="trainer_name" name="trainer_name" required>
                    <option value="" selected disabled>Select Trainer</option>
                    <?php if ($trainersResult->num_rows > 0): ?>
                        <?php while($trainer = $trainersResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($trainer['full_name']); ?>">
                                <?php echo htmlspecialchars($trainer['full_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="" disabled>No trainers available</option>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Class</button>
        </form>
        
        <!-- Success Message -->
        <?php if ($successMessage): ?>
            <div class="alert alert-success mt-3">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Display List of Gym Classes -->
        <h2 class="mt-5">Gym Classes</h2>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['class_name']); ?></h5>
                                <p class="card-text">
                                    <strong>Start Time:</strong> <?php echo htmlspecialchars($row['start_time']); ?><br>
                                    <strong>End Time:</strong> <?php echo htmlspecialchars($row['end_time']); ?><br>
                                    <strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?><br>
                                    <strong>Trainer:</strong> <?php echo htmlspecialchars($row['trainer_name']); ?>
                                </p>
                                <a href="edit_class.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_class.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info" role="alert">No gym classes found.</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
