<?php
session_start(); // Start the session

// Destroy all session variables
$_SESSION = array();

// If you want to destroy the session cookie as well (for security reasons)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page or home page
header("Location: login.php"); // Redirect to the login page after logout
exit;
?>
