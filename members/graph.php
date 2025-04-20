<?php
session_start();
include '../Components/DatabaseConnection.php';
include 'header.php';


// Ensure the user is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit();
}

$error_message = null;
$success_message = null;
$bmi_message = null;
$bmi_value = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_bmi'])) {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $member_id = $_SESSION['member_id'];  // Get the member ID from session

    // Convert height from cm to meters
    $height_in_meters = $height / 100;

    // Calculate BMI
    $bmi = $weight / ($height_in_meters * $height_in_meters);
    $bmi_value = round($bmi, 2); // Round BMI to 2 decimal places

    // Check if BMI was already submitted today
    $stmt = $conn->prepare("SELECT * FROM bmi_records WHERE member_id = ? AND DATE(submission_date) = CURDATE()");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert BMI data into the database if not already submitted today
        $stmt = $conn->prepare("INSERT INTO bmi_records (member_id, bmi, submission_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $member_id, $bmi);

        if ($stmt->execute()) {
            $success_message = "Your BMI has been saved successfully.";
        } else {
            $error_message = "Failed to save your BMI. Please try again.";
        }
    }

    // Determine the BMI category and provide a message
    if ($bmi_value < 18.5) {
        $bmi_message = "Your BMI is below the normal range. You might be underweight.";
    } elseif ($bmi_value >= 18.5 && $bmi_value <= 24.9) {
        $bmi_message = "Your BMI is normal. Keep up the good work!";
    } elseif ($bmi_value >= 25 && $bmi_value <= 29.9) {
        $bmi_message = "Your BMI is above the normal range. You might be overweight.";
    } else {
        $bmi_message = "Your BMI is in the high range. It's advisable to consult a healthcare provider.";
    }
}

// Fetch BMI records for the graph
$bmi_data = [];
$dates = [];
$stmt = $conn->prepare("SELECT bmi, submission_date FROM bmi_records WHERE member_id = ? ORDER BY submission_date ASC");
$stmt->bind_param("i", $_SESSION['member_id']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $bmi_data[] = $row['bmi'];
    $dates[] = date('Y-m-d', strtotime($row['submission_date']));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <link href="../css/style.min.css" rel="stylesheet">
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<!-- Flaticon Font -->
<link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="css/style.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h4 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase font-weight-bold">BMI</h4>
            <div class="d-inline-flex">
                <p class="m-0 text-white"><a class="text-white" href="">Home</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Check the Progress</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Display error or success message -->
    <div class="container mt-4">
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
    </div>

    <!-- BMI Calculation Start -->
    <div class="container-fluid position-relative bmi mt-5" style="margin-bottom: 90px;">
        <div class="container">
            <div class="row px-3 align-items-center">
                <div class="col-md-6">
                    <div class="pr-md-3 d-none d-md-block">
                        <h4 class="text-primary">Body Mass Index</h4>
                        <h4 class="display-4 text-white font-weight-bold mb-4">What is BMI?</h4>
                        <p class="m-0 text-white">BMI stands for Body Mass Index. It is a measure that uses your height and weight to work out if your weight is healthy.</p>
                    </div>
                </div>
                <div class="col-md-6 bg-secondary py-5">
                    <div class="py-5 px-3">
                        <h1 class="mb-4 text-white">Calculate your BMI</h1>
                        <form method="POST">
                            <div class="form-row">
                                <div class="col form-group">
                                    <input type="text" name="weight" id="weight" class="form-control form-control-lg bg-dark text-white" placeholder="Weight (KG)" required>
                                </div>
                                <div class="col form-group">
                                    <input type="text" name="height" id="height" class="form-control form-control-lg bg-dark text-white" placeholder="Height (CM)" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col form-group">
                                    <input type="text" name="age" id="age" class="form-control form-control-lg bg-dark text-white" placeholder="Age" required>
                                </div>
                                <div class="col form-group">
                                    <select name="gender" id="gender" class="custom-select custom-select-lg bg-dark text-muted" required>
                                        <option value="">Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <input type="submit" name="calculate_bmi" class="btn btn-lg btn-block btn-dark border-light" value="Calculate Now">
                                </div>
                            </div>
                        </form>

                        <!-- Display BMI result and message -->
                        <?php if ($bmi_value): ?>
                            <div class="mt-4">
                                <h3 class="text-white">Your BMI: <?php echo $bmi_value; ?></h3>
                                <p class="text-warning"><?php echo $bmi_message; ?></p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BMI Graph Section -->
    <div class="container mt-5">
        <h2 class="text-primary">Your BMI Over Time</h2>
        <canvas id="bmiChart" width="400" height="200"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('bmiChart').getContext('2d');
        const bmiData = <?php echo json_encode($bmi_data); ?>;
        const dates = <?php echo json_encode($dates); ?>;

        const bmiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'BMI',
                    data: bmiData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'BMI'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                }
            }
        });
    </script>


  <!-- Footer Start -->
  <div class="footer container-fluid mt-5 py-5 px-sm-3 px-md-5 text-white">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-primary mb-4">Get In Touch</h4>
                <p><i class="fa fa-map-marker-alt mr-2"></i>123 Gampaha</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-primary mb-4">Quick Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Features</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Classes</a>
                    <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-primary mb-4">Popular Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Features</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Classes</a>
                    <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-primary mb-4">Opening Hours</h4>
                <h5 class="text-white">Monday - Friday</h5>
                <p>5.00 AM - 10.00 PM</p>
                <h5 class="text-white">Saturday - Sunday</h5>
                <p>7.00 AM - 8.00 PM</p>
            </div>
        </div>
        <div class="container border-top border-dark pt-5">
            <p class="m-0 text-center text-white">
                &copy; <a class="text-white font-weight-bold" href="#">Flexforge</a>
                <a class="text-white font-weight-bold" href="https://htmlcodex.com"></a>
            </p>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-outline-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
