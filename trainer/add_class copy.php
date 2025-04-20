<?php 
session_start(); // Start the session
include '../Components/DatabaseConnection.php'; 


// Initialize a variable for the success message
$successMessage = '';

// Check if there is a success message in the session
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']); // Clear the message from the session after displaying it
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gym Class</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
          margin-top: 100px;
          margin-left:200px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-heading {
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="form-heading">Add Gym Class</h2>
            <form action="class_process.php" method="post">
                <div class="form-group">
                    <label for="class_name">Class Name:</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Enter Class Name" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_time">Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_time">End Time:</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="trainer_name">Trainer Name:</label>
                    <input type="text" class="form-control" id="trainer_name" name="trainer_name" placeholder="Enter Trainer Name" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add Class</button>
            </form>
            
            <!-- Show Success Message if exists -->
            <?php if ($successMessage): ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
