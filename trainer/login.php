<?php
// Include the database connection
include '../Components/DatabaseConnection.php'; 

// Start the session
session_start();

// Initialize error message
$error_message = null;

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to check the user's credentials
    $stmt = $conn->prepare("SELECT trainer_id, password FROM trainers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user_data['password'])) {
            // Store trainer_id in session
            $_SESSION['trainer_id'] = $user_data['trainer_id'];
            // Redirect to the trainer dashboard or any other page
            header("Location: ../trainer/trainer_profile.php");
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Login</title>
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
            color: #ecf0f1; /* Change to appropriate text color */
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
        <h2 class="mb-4">Trainer Login</h2>

        <?php if ($error_message): ?>
            <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
