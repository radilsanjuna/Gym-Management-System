<?php
session_start();
include '../Components/DatabaseConnection.php'; // Include your database connection
include 'trainer_dashboard.php';


// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: login.php");
    exit();
}

// Get trainer details from the database
$trainer_id = $_SESSION['trainer_id'];
$sql = "SELECT * FROM trainers WHERE trainer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();
$trainer = $result->fetch_assoc();

// Handle form submission for updating trainer details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $specialization = $_POST['specialization'];
    $years_of_experience = $_POST['years_of_experience'];
    $certifications = $_POST['certifications'];
    $availability = $_POST['availability'];

    $update_sql = "UPDATE trainers SET full_name = ?, username = ?, email = ?, phone_number = ?, specialization = ?, years_of_experience = ?, certifications = ?, availability = ? WHERE trainer_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssssi", $full_name, $username, $email, $phone_number, $specialization, $years_of_experience, $certifications, $availability, $trainer_id);

    if ($update_stmt->execute()) {
        // Reload the page with updated details
        header("Location: trainer_profile.php");
        exit();
    } else {
        echo "Error updating profile.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Profile</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar a {
            color: #fff;
        }
        .profile-info p {
            font-size: 1.1em;
        }
        .logout-btn {
            background-color: #dc3545;
            color: #fff;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .edit-btn, .save-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>


        <!-- Main Content -->
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="pt-3 pb-2 mb-3">
                <h2 class="text-center">Trainer Profile</h2>

                <div class="card shadow-sm p-4 mb-5 bg-white rounded">
                    <!-- Profile Info -->
                    <div class="profile-info">
                        <form action="trainer_profile.php" method="POST">
                            <div class="form-group">
                                <label for="full_name"><strong>Full Name:</strong></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($trainer['full_name']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="username"><strong>Username:</strong></label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($trainer['username']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email"><strong>Email:</strong></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($trainer['email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_number"><strong>Phone Number:</strong></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($trainer['phone_number']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="specialization"><strong>Specialization:</strong></label>
                                <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($trainer['specialization']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="years_of_experience"><strong>Years of Experience:</strong></label>
                                <input type="text" class="form-control" id="years_of_experience" name="years_of_experience" value="<?php echo htmlspecialchars($trainer['years_of_experience']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="certifications"><strong>Certifications:</strong></label>
                                <input type="text" class="form-control" id="certifications" name="certifications" value="<?php echo htmlspecialchars($trainer['certifications']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="availability"><strong>Availability:</strong></label>
                                <input type="text" class="form-control" id="availability" name="availability" value="<?php echo htmlspecialchars($trainer['availability']); ?>" required>
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="btn btn-success save-btn">Save Changes</button>
                        </form>
                        <!-- Logout Button -->
                        <a href="logout.php" class="btn logout-btn mt-3">Logout</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
