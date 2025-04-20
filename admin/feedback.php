<?php
session_start();
// Include your database connection
include '../Components/DatabaseConnection.php';
include 'dashboard.php'; 
// Start a session


// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch feedback from the database
$feedbackQuery = "SELECT f.feedback_id, f.feedback_text, f.feedback_date, mr.fullname 
                  FROM feedback f 
                  JOIN memberregister mr ON f.member_id = mr.member_id
                  ORDER BY f.feedback_date DESC";

$feedbackResult = mysqli_query($conn, $feedbackQuery);

// Error handling for the query
if (!$feedbackResult) {
    die("Query failed: " . mysqli_error($conn));
}

// Handle deletion request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_feedback_id'])) {
    $feedbackId = $_POST['delete_feedback_id'];

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM feedback WHERE feedback_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $feedbackId);

    if ($stmt->execute()) {
        // Set a session variable to show the message
        $_SESSION['message'] = 'Feedback deleted successfully.';
    } else {
        $_SESSION['message'] = 'Failed to delete feedback: ' . mysqli_error($conn);
    }

    $stmt->close();
    // Redirect to avoid resubmission of the form
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Check for session message and clear it after displaying
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Feedback</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Member Feedback</h2>

        <!-- Display the message if set -->
        <?php if ($message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Feedback List -->
        <div class="list-group">
            <?php while ($row = mysqli_fetch_assoc($feedbackResult)): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5"><?php echo htmlspecialchars($row['fullname']); ?></h3>
                        <!-- Delete Button -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_feedback_id" value="<?php echo htmlspecialchars($row['feedback_id']); ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</button>
                        </form>
                    </div>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($row['feedback_text'])); ?></p>
                    <small class="text-muted"><?php echo date('F j, Y, g:i a', strtotime($row['feedback_date'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>