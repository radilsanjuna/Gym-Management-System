<?php
// view_announcements.php

include '../Components/DatabaseConnection.php'; 

// Fetch announcements sent by the admin (Example admin ID 1)
$sql = "SELECT * FROM announcements WHERE sender_id = 1"; 
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
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

<h2>Your Announcements</h2>

<?php if (isset($_GET['message'])) { ?>
    <div class="message"><?php echo htmlspecialchars($_GET['message']); ?></div>
<?php } ?>

<table border="1">
    <tr>
        <th>Title</th>
        <th>Message</th>
        <th>Recipient Type</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>

        <!-- Check if 'message' exists before displaying -->
        <td>
            <?php echo isset($row['content']) ? htmlspecialchars($row['content']) : 'No message available'; ?>
        </td>

        <!-- Capitalize recipient_type if it exists -->
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

</body>
</html>
