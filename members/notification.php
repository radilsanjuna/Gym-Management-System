<?php
// member_notifications.php
session_start(); // Start the session to use session variables

include '../Components/DatabaseConnection.php'; // Include database connection

// Check if the user is logged in and get the member ID from the session
if (!isset($_SESSION['member_id'])) {
    // Redirect to login if the member is not logged in
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id']; // Get the logged-in member's ID from the session

// Fetch general announcements for members or both members and trainers
$announcement_sql = "SELECT * FROM announcements WHERE recipient_type = 'member' OR recipient_type = 'both'";
$announcement_result = $conn->query($announcement_sql);

// Fetch personal notifications for the logged-in user
$notification_sql = "SELECT message, date_sent FROM notifications WHERE member_id = ? ORDER BY date_sent DESC";
$notification_stmt = $conn->prepare($notification_sql);
$notification_stmt->bind_param("i", $member_id);
$notification_stmt->execute();
$notification_result = $notification_stmt->get_result();

// Fetch schedules for the logged-in member
$schedule_sql = "SELECT schedule_file, upload_date FROM schedules WHERE member_id = ?";
$schedule_stmt = $conn->prepare($schedule_sql);
$schedule_stmt->bind_param("i", $member_id);
$schedule_stmt->execute();
$schedule_result = $schedule_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Notifications</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            font-family: 'Arial', sans-serif;
            color: #fff;
            margin-top: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #ff4b2b;
            text-align: center;
        }

        .section {
            margin-bottom: 40px;
        }

        .card {
            background-color: #222;
            border: 1px solid #444;
            margin-bottom: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            color: #ff4b2b;
            font-weight: bold;
        }

        .card-text {
            color: #ddd;
        }

        .table {
            color: #fff;
        }

        .table th, .table td {
            vertical-align: middle;
            border-top-color: #444;
        }

        .table-dark {
            background-color: #333;
        }

        .btn-primary {
            background-color: #ff4b2b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff3a1a;
        }

        .list-group-item {
            background-color: #222;
            border-color: #444;
            color: #ddd;
        }

        .badge {
            background-color: #ff4b2b;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
        }

        .footer {
            background-color: #111;
            padding: 30px;
            text-align: center;
            color: #888;
            margin-top: 40px;
        }

        .footer a {
            color: #ff4b2b;
            text-decoration: none;
        }

        .footer a:hover {
            color: #ff3a1a;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- General Announcements Section -->
    <div class="section">
        <h2>General Announcements</h2>
        <div>
            <?php if ($announcement_result->num_rows > 0) { ?>
                <?php while ($row = $announcement_result->fetch_assoc()) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                            <p class="text-muted"><small><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></small></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="no-data">No announcements found.</p>
            <?php } ?>
        </div>
    </div>

    <!-- Personal Notifications Section -->
    <div class="section">
        <h2>Your Personal Notifications</h2>
        <ul class="list-group">
            <?php if ($notification_result->num_rows > 0) { ?>
                <?php while ($row = $notification_result->fetch_assoc()) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <strong><?php echo htmlspecialchars($row['message']); ?></strong>
                        </div>
                        <span class="badge"><?php echo date('Y-m-d H:i', strtotime($row['date_sent'])); ?></span>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li class="list-group-item no-data">No notifications found.</li>
            <?php } ?>
        </ul>
    </div>

    <!-- Uploaded Schedules Section -->
    <div class="section">
        <h2>Your Uploaded Schedules</h2>
        <?php if ($schedule_result->num_rows > 0) { ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Schedule File</th>
                        <th>Upload Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $schedule_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars(basename($row['schedule_file'])); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($row['upload_date'])); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="showImage('<?php echo htmlspecialchars(basename($row['schedule_file'])); ?>')">View</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-data">No schedules uploaded yet.</p>
        <?php } ?>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Schedule Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="scheduleImage" src="" alt="Schedule Image" class="img-fluid" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showImage(fileName) {
        // Update the path to the uploaded schedule images
        const imagePath = '/uploads/schedules/' + fileName; // Ensure this path is correct
        document.getElementById('scheduleImage').src = imagePath; // Set the src of the image in the modal
        document.getElementById('scheduleImage').alt = "Schedule Image"; // Set alt text for accessibility
        $('#imageModal').modal('show'); // Show the modal
    }
</script>

<!-- Close the statements and connection -->
<?php
// Close the statements and connection
$notification_stmt->close();
$schedule_stmt->close();
$conn->close();
?>

</body>
</html>
