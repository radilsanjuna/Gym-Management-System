<?php
// Include the database connection
include '../Components/DatabaseConnection.php'; // Ensure the path is correct

// Start session to get the logged-in user ID
session_start();

if (!isset($_SESSION['member_id'])) {
    // Redirect to login if user is not logged in
    header('Location: login.php');
    exit();
}

// Fetch member details from the database
$member_id = $_SESSION['member_id'];
$sql = "SELECT fullname, username, dob, gender, contact, email, address, exercise_plan, payment_plan FROM memberregister WHERE member_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
$member = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .navbar {
            background-color: #111;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        .profile-header {
            background-color: #222;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        .profile-header h1 {
            margin: 0;
        }

        .profile-header p {
            font-size: 1.2rem;
        }

        .profile-content {
            display: flex;
            justify-content: center;
            padding: 2rem;
            background-color: #fff;
        }

        .profile-card {
            background-color: #333;
            color: #fff;
            padding: 2rem;
            margin: 1rem;
            border-radius: 8px;
            width: 500px;
            text-align: left;
        }

        .profile-card h2 {
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }

        .profile-info {
            display: table;
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .profile-info td {
            padding: 0.75rem 1rem;
        }

        .profile-info td:first-child {
            font-weight: bold;
            color: #1abc9c;
        }

        .footer {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <?php include 'header.php';?>

    <div class="navbar">
        <h2>FlexForge</h2>
    </div>

    <div class="profile-header">
        <h1>User Profile</h1>
        <p>Welcome to your personal profile page!</p>
    </div>

    <div class="profile-content">
        <div class="profile-card">
            <h2><?php echo htmlspecialchars($member['fullname']); ?></h2>
            <table class="profile-info">
                <tr>
                    <td>Username:</td>
                    <td><?php echo htmlspecialchars($member['username']); ?></td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td><?php echo htmlspecialchars($member['dob']); ?></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td><?php echo htmlspecialchars($member['gender']); ?></td>
                </tr>
                <tr>
                    <td>Contact:</td>
                    <td><?php echo htmlspecialchars($member['contact']); ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo htmlspecialchars($member['email']); ?></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><?php echo htmlspecialchars($member['address']); ?></td>
                </tr>
                <tr>
                    <td>Exercise Plan:</td>
                    <td><?php echo htmlspecialchars($member['exercise_plan']); ?></td>
                </tr>
                <tr>
                    <td>Payment Plan:</td>
                    <td><?php echo htmlspecialchars($member['payment_plan']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 FlexForge. All rights reserved.</p>
    </div>


    

</body>
</html>
