<?php
// Start the session
session_start(); 

include '../Components/DatabaseConnection.php'; // Include the database connection file

// Check if the user is logged in and get the member ID from the session
if (!isset($_SESSION['member_id'])) {
    // Redirect to login if the member is not logged in
    header("Location: login.php");
    exit;
}

$member_id = $_SESSION['member_id']; // Get the logged-in member's ID from the session

// Fetch schedules for the logged-in member from the database
$query = "SELECT schedule_file, upload_date FROM schedules WHERE member_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Schedules</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Your Uploaded Schedules</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Schedule File</th>
                <th>Upload Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo basename($row['schedule_file']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($row['upload_date'])); ?></td>
                    <td><a href="<?php echo $row['schedule_file']; ?>" target="_blank">View</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No schedules uploaded yet.</p>
<?php endif; ?>

</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
