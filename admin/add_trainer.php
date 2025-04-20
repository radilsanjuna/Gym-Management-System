<?php
include 'dashboard.php'; 
include '../Components/DatabaseConnection.php';

// Initialize an empty message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs and sanitize them
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']); // New Username field
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    $date_of_birth = $_POST['date_of_birth'];
    $specialization = trim($_POST['specialization']);
    $years_of_experience = (int) trim($_POST['years_of_experience']); // Cast to int
    $certifications = trim($_POST['certifications']);
    $availability = $_POST['availability'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Hash the password...
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Registration</title>
    <link rel="stylesheet" href="../css/UserRegister.css"> <!-- Ensure this points to the correct stylesheet -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* Space between the dashboard and registration form */
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"], input[type="password"], input[type="date"], input[type="tel"], input[type="email"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }
        .input-icon input, .input-icon select, .input-icon textarea {
            padding-left: 40px; /* Add space for the icon */
        }
    </style>
</head>
<body>

<!-- Dashboard Content -->
<div class="dashboard">
    <?php include 'dashboard.php'; ?>
</div>

<!-- Registration Form -->
<div class="container">
    <h2>Trainer Registration Form</h2>

    <!-- Display message if exists -->
    <?php if ($message): ?>
        <div class="error-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="input-icon">
            <i class="fas fa-user"></i>
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-user-circle"></i>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-envelope"></i>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-phone"></i>
            <label for="phone_number">Phone Number</label>
            <input type="tel" id="phone_number" name="phone_number" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-calendar-alt"></i>
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-home"></i>
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required></textarea>
        </div>

        <div class="input-icon">
            <i class="fas fa-dumbbell"></i>
            <label for="specialization">Specialization</label>
            <input type="text" id="specialization" name="specialization" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-history"></i>
            <label for="years_of_experience">Years of Experience</label>
            <input type="text" id="years_of_experience" name="years_of_experience" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-certificate"></i>
            <label for="certifications">Certifications</label>
            <input type="text" id="certifications" name="certifications" required>
        </div>

        <div class="input-icon">
            <label for="availability">Availability</label>
            <select id="availability" name="availability" required>
                <option value="" disabled selected>Select Availability</option>
                <option value="full_time">Full Time</option>
                <option value="part_time">Part Time</option>
            </select>
        </div>

        <div class="input-icon">
            <i class="fas fa-lock"></i>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="input-icon">
            <i class="fas fa-lock"></i>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit">Register</button>
    </form>
</div>

<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
