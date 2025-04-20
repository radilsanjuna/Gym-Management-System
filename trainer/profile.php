<?php
// Sample trainer data (in a real application, this data would come from a database)
$trainer = [
    'name' => 'John Doe',
    'bio' => 'Certified fitness trainer with over 5 years of experience in weight training, yoga, and nutrition coaching.',
    'skills' => ['Weight Training', 'Yoga', 'Nutrition Coaching', 'Cardio Training'],
    'email' => 'johndoe@example.com',
    'phone' => '+123 456 7890',
    'image' => 'trainer.jpg' // Sample image file
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // For demonstration, we will just echo the submitted data.
    // In a real application, you might send an email or store it in a database.
    $submitted = true;
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
        h3 {
            margin-top: 20px;
        }
        .list-group-item {
            background-color: #e9ecef; /* Light gray background for skill items */
            border: none;
        }
        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border-color: #007bff;
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
                <h3>Skills</h3>
                <ul class="list-group mb-4">
                    <?php foreach ($trainer['skills'] as $skill): ?>
                        <li class="list-group-item"><?php echo $skill; ?></li>
                    <?php endforeach; ?>
                </ul>

                <h3>Contact Me</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
                
                <?php if (isset($submitted)): ?>
                    <div class="alert alert-success mt-3">
                        <h4>Message Sent!</h4>
                        <p>Name: <?php echo $name; ?></p>
                        <p>Email: <?php echo $email; ?></p>
                        <p>Message: <?php echo $message; ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
