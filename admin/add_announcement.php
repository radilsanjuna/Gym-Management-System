<?php
// add_announcement.php
include '../Components/DatabaseConnection.php'; 
include 'dashboard.php'; 

$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $recipient_type = $_POST['recipient_type']; // 'member', 'trainer', or 'both'
    $sender_type = 'admin'; // This can be dynamic based on logged-in user type
    $sender_id = 1; // Example admin ID (fetch the actual logged-in admin's ID dynamically)

    // Insert the announcement into the database
    $sql = "INSERT INTO announcements (sender_type, sender_id, recipient_type, title, content) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sisss', $sender_type, $sender_id, $recipient_type, $title, $content);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Announcement sent successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch announcements sent by the admin (Example admin ID 1)
$sql = "SELECT * FROM announcements WHERE sender_id = 1"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Announcement</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .delete-btn {
            color: red;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Create Announcement</h2>
    
    <?php if ($message) { echo $message; } ?> <!-- Display message here -->

    <form method="POST" action="add_announcement.php" class="mt-4">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Message:</label>
            <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="recipient_type" class="form-label">Send To:</label>
            <select id="recipient_type" name="recipient_type" class="form-select" required>
                <option value="member">Members</option>
                <option value="trainer">Trainers</option>
                <option value="both">Both Members and Trainers</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Send Announcement</button>
    </form>

    <h2 class="mt-5">Your Announcements</h2>

    <?php if (isset($_GET['message'])) { ?>
        <div class="message"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php } ?>

    <table border="1" class="mt-3">
        <tr>
            <th>Title</th>
            <th>Message</th>
            <th>Recipient Type</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td>
                <?php echo isset($row['content']) ? htmlspecialchars($row['content']) : 'No message available'; ?>
            </td>
            <td>
                <?php echo isset($row['recipient_type']) ? ucfirst(htmlspecialchars($row['recipient_type'])) : 'Unknown'; ?>
            </td>
            <td>
                <a href="edit_announcement.php?id=<?php echo $row['id']; ?>">Edit</a>
                |
                <a href="delete_announcement.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
