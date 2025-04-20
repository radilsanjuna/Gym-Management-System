<?php
include '../Components/DatabaseConnection.php';
include 'dashboard.php'; 

// Query to get all trainers
$sql = "SELECT * FROM trainers";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer List</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/font.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            float: left;
            margin-left: 10%;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #f0ad4e; /* Orange */
        }

        .edit-btn:hover {
            background-color: #ec971f;
        }

        .delete-btn {
            background-color: #d9534f; /* Red */
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Trainer Registration Details</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Specialization</th>
                <th>Years of Experience</th>
                <th>Certifications</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['trainer_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                        <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                        <td><?php echo htmlspecialchars($row['years_of_experience']); ?></td>
                        <td><?php echo htmlspecialchars($row['certifications']); ?></td>
                        <td><?php echo htmlspecialchars($row['availability']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="edit_trainer.php?id=<?php echo $row['trainer_id']; ?>" class="btn edit-btn">Edit</a>
                                <a href="delete_trainer.php?id=<?php echo $row['trainer_id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this trainer?');">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No trainers found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php 
    // Close the connection
    if (isset($conn)) {
        $conn->close(); 
    }
    ?>
</div>
</body>
</html>
