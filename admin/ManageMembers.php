<?php
// Include necessary files
include '../Components/DatabaseConnection.php'; 
include 'dashboard.php'; 

$error_message = '';
$success_message = '';

// Fetch members from the database
$query = "SELECT member_id, username, contact, email, gender, payment_plan, exercise_plan FROM MemberRegister";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/font.css">
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        /* Centering the page content */
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Table and button title styling */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Success and error message styling */
        .alert {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .alert-danger {
            color: red;
        }

        .alert-success {
            color: green;
        }

        /* Table styling */
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

        /* Header styling */
        th {
            background-color: #333;
            color: white;
        }

        /* Alternate row color for better readability */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Button styling for actions */
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-warning {
            background-color: #f0ad4e;
        }

        .btn-warning:hover {
            background-color: #ec971f;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Member Management</h2>

    <?php
    // Display error or success message if exists
    if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php elseif ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <!-- Member Management Table -->
    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Username</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Payment Plan</th>
                <th>Exercise Plan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display each member in a table row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['member_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['payment_plan']) . "</td>";  // Payment plan column
                echo "<td>" . htmlspecialchars($row['exercise_plan']) . "</td>"; // Exercise plan column
                echo "<td>
                        <a href='edit_member.php?member_id=" . htmlspecialchars($row['member_id']) . "' class='btn btn-warning'>Edit</a>
                        <a href=\"javascript:void(0);\" onclick=\"confirmDelete(" . htmlspecialchars($row['member_id']) . ");\" class='btn btn-danger'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</div>

<script>
function confirmDelete(memberId) {
    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this member?")) {
        // If confirmed, redirect to the delete_member.php script
        window.location.href = 'delete_member.php?member_id=' + memberId;
    }
}
</script>

</body>
</html>
