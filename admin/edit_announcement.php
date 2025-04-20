<?php
// edit_announcement.php

include '../Components/DatabaseConnection.php'; 
include 'dashboard.php'; 

$message = ''; // Variable to store messages

if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];
    
    // Fetch announcement data by ID
    $sql = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
    } else {
        echo "Announcement not found.";
        exit;
    }
    
    // Handle form submission for editing announcement
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $content = $_POST['content']; // Use 'content' instead of 'message'
        $recipient_type = $_POST['recipient_type'];

        // Update query
        $update_sql = "UPDATE announcements SET title = ?, content = ?, recipient_type = ?, updated_at = NOW() WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param('sssi', $title, $content, $recipient_type, $announcement_id);

        if ($update_stmt->execute()) {
            $message = "<div class='alert alert-success'>Announcement updated successfully.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating announcement.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Announcement</title>
</head>
<body>

<div class="container mt-5">
    <h2>Edit Announcement</h2>
    
    <!-- Display message here -->
    <?php if (!empty($message)): ?>
        <?php echo $message; ?>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($announcement['title'] ?? '', ENT_QUOTES); ?>" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Message:</label>
            <textarea name="content" class="form-control" rows="4" required><?php echo htmlspecialchars($announcement['content'] ?? '', ENT_QUOTES); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="recipient_type" class="form-label">Recipient Type:</label>
            <select name="recipient_type" class="form-select" required>
                <option value="member" <?php echo ($announcement['recipient_type'] ?? '') == 'member' ? 'selected' : ''; ?>>Member</option>
                <option value="trainer" <?php echo ($announcement['recipient_type'] ?? '') == 'trainer' ? 'selected' : ''; ?>>Trainer</option>
                <option value="both" <?php echo ($announcement['recipient_type'] ?? '') == 'both' ? 'selected' : ''; ?>>Both</option>
            </select>
        </div>

        <input type="submit" name="update" value="Update Announcement" class="btn btn-primary">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
