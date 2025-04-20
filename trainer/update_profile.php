<?php
// Sample trainer data (in a real application, this data would come from a database)
$trainer = [
    'name' => 'John Doe',
    'bio' => 'Certified fitness trainer with over 5 years of experience in weight training, yoga, and nutrition coaching.',
    'email' => 'johndoe@example.com',
    'phone' => '+123 456 7890',
    'image' => 'trainer.jpg' // Sample image file
];

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_form'])) {
    $trainer['email'] = htmlspecialchars($_POST['update_email']);
    $trainer['phone'] = htmlspecialchars($_POST['update_phone']);
    
    $updated = true; // Flag to indicate profile update success
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
    <title>Trainer Profile</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $trainer['image']; ?>" class="card-img-top" alt="Trainer Image">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $trainer['name']; ?></h5>
                        <p class="card-text"><?php echo $trainer['bio']; ?></p>
                        <h6>Contact Information</h6>
                        <p>Email: <a href="mailto:<?php echo $trainer['email']; ?>"><?php echo $trainer['email']; ?></a></p>
                        <p>Phone: <?php echo $trainer['phone']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h3>Update Contact Details</h3>
                <form action="" method="post">
                    <input type="hidden" name="update_form" value="1">
                    <div class="mb-3">
                        <label for="update_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="update_email" name="update_email" value="<?php echo $trainer['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="update_phone" name="update_phone" value="<?php echo $trainer['phone']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Contact</button>
                </form>

                <?php if (isset($updated)): ?>
                    <div class="alert alert-success mt-3">
                        <h4>Contact Details Updated!</h4>
                        <p>Email: <?php echo $trainer['email']; ?></p>
                        <p>Phone: <?php echo $trainer['phone']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
