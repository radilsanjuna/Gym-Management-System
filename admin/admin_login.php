<?php
session_start(); // Start the session

// Hardcoded credentials
$hardcoded_username = 'admin';
$hardcoded_password = 'admin123';

$error_message = ""; // Initialize the error message variable

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password
    if ($username === $hardcoded_username && $password === $hardcoded_password) {
        // Set session variable
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        // Redirect to UserRegister.php
        header("Location: dashboard_view.php");
        exit(); // Make sure the script stops after redirect
    } else {
        // Set an error message if the username or password is incorrect
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #ecf0f1;
        }
        .login-card {
            background-color: #34495e;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-card img {
            width: 150px;
            margin-bottom: 20px;
        }
        .form-control {
            background-color: #3b4b60;
            border: none;
            margin-bottom: 20px;
            color: #white;
        }
        .form-control:focus {
            background-color: #3b4b60;
            color: #ecf0f1;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #1abc9c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #16a085;
        }
        .error {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <img src="../img/logo.jpg" alt="Gym Logo">
    <h2 class="mb-4">Admin Login</h2>

    <?php if ($error_message): ?>
        <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
