<?php
// Start the session and include the database connection
session_start();
include '../Components/DatabaseConnection.php';

if (!isset($_SESSION['trainer_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $bio = $_POST['bio'];
    $twitter_link = $_POST['twitter_link'];
    $facebook_link = $_POST['facebook_link'];
    $linkedin_link = $_POST['linkedin_link'];
    $instagram_link = $_POST['instagram_link'];

    // Image upload handling
    $profile_img = '';
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0) {
        $image_name = basename($_FILES['profile_img']['name']);
        $image_path = 'uploads/' . $image_name;

        // Move the uploaded image to the "uploads" directory
        if (move_uploaded_file($_FILES['profile_img']['tmp_name'], $image_path)) {
            $profile_img = $image_name;
        } else {
            $_SESSION['error_message'] = 'Failed to upload profile image.';
        }
    }

    // Insert trainer details into the database (without position)
    $query = "INSERT INTO trainers_pro (full_name, bio, twitter_link, facebook_link, linkedin_link, instagram_link, profile_img) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $full_name, $bio, $twitter_link, $facebook_link, $linkedin_link, $instagram_link, $profile_img);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Trainer added successfully!';
    } else {
        $_SESSION['error_message'] = 'Failed to add trainer.';
    }

    header('Location: add_trainer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trainer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Add Trainer</h2>
    <form action="add_trainer.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="profile_img">Profile Image</label>
            <input type="file" class="form-control-file" id="profile_img" name="profile_img" accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="twitter_link">Twitter</label>
            <input type="url" class="form-control" id="twitter_link" name="twitter_link">
        </div>
        <div class="form-group">
            <label for="facebook_link">Facebook</label>
            <input type="url" class="form-control" id="facebook_link" name="facebook_link">
        </div>
        <div class="form-group">
            <label for="linkedin_link">LinkedIn</label>
            <input type="url" class="form-control" id="linkedin_link" name="linkedin_link">
        </div>
        <div class="form-group">
            <label for="instagram_link">Instagram</label>
            <input type="url" class="form-control" id="instagram_link" name="instagram_link">
        </div>
        <button type="submit" class="btn btn-primary">Add Trainer</button>
    </form>

    <!-- Display success/error messages -->
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="alert alert-success mt-3">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])) : ?>
        <div class="alert alert-danger mt-3">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
