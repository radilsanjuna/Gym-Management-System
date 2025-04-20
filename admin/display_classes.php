<?php
include '../Components/DatabaseConnection.php';

// Fetch gym classes from the database
$sql = "SELECT * FROM gym_classes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Gym Classes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Gym Classes</h2>

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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
