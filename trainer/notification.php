<?php
 include 'dashboard.php'; 
 include '../Components/DatabaseConnection.php';
 
 $message = '';
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    if (isset($_POST['member_id'], $_POST['notification_text'])) {
        $member_id = intval($_POST['member_id']); // Ensure member_id is an integer
        $notification_text = trim($_POST['notification_text']);

        if (empty($notification_text)) {
            $error = "Notification text cannot be empty.";
        } else {
            // Insert notification into the notifications table
            $query = "INSERT INTO notifications (member_id, notification_text, is_read, created_at) VALUES (?, ?, 0, NOW())";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("is", $member_id, $notification_text);

                if ($stmt->execute()) {
                    $success = "Notification sent successfully!";
                } else {
                    $error = "Failed to send notification: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $error = "Failed to prepare statement: " . $conn->error;
            }
        }
    } else {
        $error = "Invalid form submission.";
    }
}

// Fetch members from the database
$query = "SELECT id, first_name, last_name FROM users"; // Removed the role filtering
$result = mysqli_query($conn, $query);
$members = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $members[] = $row; // Store members in an array
    }
} else {
    $error = "Error fetching members: " . mysqli_error($conn);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
       
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            background-color: #333;
            padding-top: 20px;
        }
        .sidenav img {
            width: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }
        .sidenav h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #f1f1f1;
            display: block;
            background: none;
            text-align: left;
            border: none;
            outline: none;
            width: 100%;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            background-color: #575757;
        }
        .dropdown-container {
            display: none;
            background-color: #414141;
            padding-left: 15px;
        }
        .active {
            background-color: #575757;
        }
        .fas.fa-caret-down {
            float: right;
            padding-right: 10px;
        }
        .container {
            margin-left: 270px; /* Add margin to the left to avoid overlap with the sidebar */
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidenav -->
    <div class="sidenav">
        <img src="../img/logo.jpg" alt="Gym Logo">
        <h2>Flex Forge Gym</h2> 

        <a href="#about">Dashboard</a>

        <button class="dropdown-btn">Members
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/UserRegister.php">Add Members</a>
            <a href="../admin/ManageMembers.php">View Members</a>
        </div>

        <button class="dropdown-btn">Add Class
            <i class="fas fa-caret-down"></i>
        </button>

        <button class="dropdown-btn">Payment
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/make_payment.php">Make Payment</a>
            <a href="../admin/view_payment.php">View Payments</a>
        </div>

        <a href="notification.php" class="dropdown-btn">Notifications
    <i class="fas fa-caret-down"></i>
</a>

        <a href="#contact">Announcement</a>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Send Notification to Members</h2>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="send_notification.php" method="POST">
            <div class="form-group">
                <label for="member_id">Select Member:</label>
                <select class="form-control" id="member_id" name="member_id" required>
                    <?php if (!empty($members)): ?>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= htmlspecialchars($member['id']); ?>">
                                <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No members found</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="notification_text">Notification:</label>
                <textarea class="form-control" id="notification_text" name="notification_text" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Notification</button>
        </form>
    </div>

    <!-- Dropdown Script -->
    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
