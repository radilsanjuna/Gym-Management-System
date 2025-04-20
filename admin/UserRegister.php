<?php
include 'dashboard.php'; // Ensure the path is correct
include '../Components/DatabaseConnection.php'; 

$error_message = ''; // Variable to store error messages
$success_message = ''; // Variable to store success messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);
    $email = htmlspecialchars(trim($_POST['email']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    
    // Validate fullname, username, email, and password
    if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
        $error_message = "Full Name can only contain letters and spaces!";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $error_message = "Username can only contain letters, numbers, and underscores!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } elseif (!preg_match("/^\+?\d{10,15}$/", $contact)) {
        $error_message = "Phone number must be between 10 and 15 digits!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if email or username already exists
        $stmt = $conn->prepare("SELECT email FROM memberregister WHERE email = ? OR username = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error_message = "Email or Username is already in use!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $dob = htmlspecialchars($_POST['dob']);
                $gender = htmlspecialchars($_POST['gender']);
                $registration_date = htmlspecialchars($_POST['registration_date']);
                $address = htmlspecialchars($_POST['address']);
                $exercise_plan = htmlspecialchars($_POST['exercise_plan']);
                $payment_plan = htmlspecialchars($_POST['payment_plan']);

                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO memberregister (fullname, username, password, dob, gender, registration_date, contact, email, address, exercise_plan, payment_plan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sssssssssss", $fullname, $username, $hashed_password, $dob, $gender, $registration_date, $contact, $email, $address, $exercise_plan, $payment_plan);
                    
                    // Execute the statement
                    if ($stmt->execute()) {
                        $success_message = "Registration successful!";
                    } else {
                        $error_message = "Error: " . $stmt->error;
                    }
                } else {
                    $error_message = "Database query failed!";
                }
            }
            $stmt->close();
        } else {
            $error_message = "Database connection issue!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="../css/UserRegister.css">
    <style>
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
    </style>
    <script>
        function validateForm() {
            var fullname = document.getElementById("fullname").value;
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var contact = document.getElementById("contact").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            // Validate fullname (letters and spaces only)
            var fullnamePattern = /^[a-zA-Z\s]+$/;
            if (!fullnamePattern.test(fullname)) {
                alert("Full Name can only contain letters and spaces!");
                return false;
            }

            // Validate username (letters, numbers, and underscores only)
            var usernamePattern = /^[a-zA-Z0-9_]+$/;
            if (!usernamePattern.test(username)) {
                alert("Username can only contain letters, numbers, and underscores!");
                return false;
            }

            // Validate email format
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Invalid email format!");
                return false;
            }

            // Validate contact number (10-15 digits)
            var contactPattern = /^\+?\d{10,15}$/;
            if (!contactPattern.test(contact)) {
                alert("Phone number must be between 10 and 15 digits!");
                return false;
            }

            // Validate password match
            if (password !== confirm_password) {
                alert("Passwords do not match!");
                return false;
            }

            return true; // Allow form submission if all validations pass
        }
    </script>
</head>
<body>

<div class="container">
    <h2>Registration Form</h2>

    <!-- Display error message if exists -->
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php elseif ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="" method="post" onsubmit="return validateForm()">
    <label for="fullname">Full Name</label>
    <input type="text" id="fullname" name="fullname" required>

    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" required>

    <label for="dob">Date of Birth</label>
    <input type="date" id="dob" name="dob" required>

    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
    </select>

    <label for="registration_date">Date of Registration</label>
    <input type="date" id="registration_date" name="registration_date" value="<?php echo date('Y-m-d'); ?>" readonly>

    <label for="contact">Contact Number</label>
    <input type="tel" id="contact" name="contact" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="address">Address</label>
    <textarea id="address" name="address" rows="4" required></textarea>

    <label for="exercise_plan">Exercise Plan</label>
    <select id="exercise_plan" name="exercise_plan" required>
        <option value="">Select Exercise Plan</option>
        <option value="weight_training">Weight Training</option>
        <option value="cardio_training">Cardio Training</option>
        <option value="cardio_weight_training">Cardio and Weight Training</option>
    </select>

    <label for="payment_plan">Payment Plan</label>
    <select id="payment_plan" name="payment_plan" required>
        <option value="">Select Payment Plan</option>
        <option value="one_month">One Month</option>
        <option value="six_months">Six Months</option>
        <option value="one_year">One Year</option>
    </select>

    <button type="submit">Register</button>
</form>

</div>

</body>
