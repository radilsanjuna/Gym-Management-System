<?php
// trainer/view_announcements.php

include '../Components/DatabaseConnection.php'; 

// Fetch announcements sent by the admin or the current trainer (Example trainer ID 2)
$sql = "SELECT * FROM announcements WHERE sender_type = 'admin' OR sender_id = 2"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements</title>
</head>
<body>

<h2>Announcements</h2>

<table border="1">
    <tr>
        <th>Title</th>
        <th>Message</th>
        <th>Recipient Type</th>
        <th>Sender</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title'] ?? 'No title available'); ?></td>

        <!-- Check if 'content' exists before displaying -->
        <td>
            <?php echo isset($row['content']) ? htmlspecialchars($row['content']) : 'No message available'; ?>
        </td>

        <!-- Capitalize recipient_type if it exists -->
        <td>
            <?php echo isset($row['recipient_type']) ? ucfirst(htmlspecialchars($row['recipient_type'])) : 'Unknown'; ?>
        </td>

        <!-- Display sender type (admin or trainer) -->
        <td>
            <?php echo ucfirst(htmlspecialchars($row['sender_type'])); ?>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
