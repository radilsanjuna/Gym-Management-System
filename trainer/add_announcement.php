<?php
include '../Components/DatabaseConnection.php';
include 'trainer_dashboard.php';

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $recipient_type = $_POST['recipient_type'];

    $sender_id = 2; 
    $sender_type = 'trainer';

    $sql = "INSERT INTO announcements (sender_type, sender_id, recipient_type, title, content, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $sender_type, $sender_id, $recipient_type, $title, $content);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Announcement added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$sql = "SELECT * FROM announcements WHERE sender_type = 'admin' OR sender_id = 2"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add and View Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Announcement</h2>

    <!-- Display message here -->
    <?php if (!empty($message)) echo $message; ?>

    <form action="add_announcement.php" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Message:</label>
            <textarea name="content" rows="4" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="recipient_type" class="form-label">Send to:</label>
            <select name="recipient_type" class="form-select" required>
                <option value="member">Members</option>
            </select>
        </div>
        <input type="submit" value="Send Announcement" class="btn btn-primary">
    </form>

    <h2>Announcements</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>Recipient Type</th>
                <th>Sender</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title'] ?? 'No title available'); ?></td>
                <td><?php echo isset($row['content']) ? htmlspecialchars($row['content']) : 'No message available'; ?></td>
                <td><?php echo isset($row['recipient_type']) ? ucfirst(htmlspecialchars($row['recipient_type'])) : 'Unknown'; ?></td>
                <td><?php echo ucfirst(htmlspecialchars($row['sender_type'])); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
