<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FlexForge</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.min.css" rel="stylesheet">


    <style>
   

        .feedback-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .feedback-container h2 {
            text-align: center;
            color: #ffc107;
            margin-bottom: 20px;
        }

        .feedback-container textarea {
            background-color: #343a40;
            color: white;
            border: 1px solid #ffc107;
            border-radius: 5px;
            width: 100%;
            height: 120px; /* Reduced height */
            font-size: 14px; /* Smaller font size */
            padding: 10px;
            margin-bottom: 15px;
        }

        .feedback-container button {
            background-color: #ffc107;
            border: none;
            color: #343a40;
            font-weight: bold;
            padding: 8px 16px; /* Reduced padding */
            border-radius: 5px;
            font-size: 14px; /* Smaller font size */
            cursor: pointer;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .feedback-container button:hover {
            background-color: #e0a800;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 600px) {
            .feedback-container {
                padding: 15px;
            }

            .feedback-container h2 {
                font-size: 18px;
            }
        }
    </style>






</head>

<body class="bg-white">
    
<?php include 'header.php';?>


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h4 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase font-weight-bold">Our Features</h4>
            <div class="d-inline-flex">
                <p class="m-0 text-white"><a class="text-white" href="">Home</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Our Features</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


  
<!-- GYM Feature Start -->
<div class="container feature pt-5">
    <div class="d-flex flex-column text-center mb-5">
        <h4 class="text-primary font-weight-bold">Why Choose Us?</h4>
        <h4 class="display-4 font-weight-bold">Benefits of Joining Our GYM</h4>
    </div>
    <div class="row">
        <div class="col-md-6 mb-5">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <img class="img-fluid mb-3 mb-sm-0" src="img/feature-1.jpg" alt="Image">
                    <i class="flaticon-barbell"></i>
                </div>
                <div class="col-sm-7">
                    <h4 class="font-weight-bold">Video Instruction</h4>
                    <p>Access a library of expert-led instructional videos to ensure you're performing exercises with perfect form and technique.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <img class="img-fluid mb-3 mb-sm-0" src="img/feature-2.jpg" alt="Image">
                    <i class="flaticon-training"></i>
                </div>
                <div class="col-sm-7">
                    <h4 class="font-weight-bold">Training Calendar</h4>
                    <p>Stay organized and motivated with a personalized training calendar that helps track your progress and plan your workouts.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <img class="img-fluid mb-3 mb-sm-0" src="img/feature-3.jpg" alt="Image">
                    <i class="flaticon-trends"></i>
                </div>
                <div class="col-sm-7">
                    <h4 class="font-weight-bold">Personalized Workout Plans</h4>
                    <p>Get customized workout plans tailored to your fitness goals, ensuring you make the most of every gym session.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <img class="img-fluid mb-3 mb-sm-0" src="img/feature-4.jpg" alt="Image">
                    <i class="flaticon-support"></i>
                </div>
                <div class="col-sm-7">
                    <h4 class="font-weight-bold">Community Support</h4>
                    <p>Join a thriving fitness community where members support and motivate each other towards achieving their health goals.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- GYM Feature End -->














<div class="container">
        <div class="feedback-container">
            <h2>Submit Your Feedback</h2>
            <form action="" method="POST">
                <textarea name="feedback_text" placeholder="Enter your feedback..." required></textarea>
                <button type="submit" name="submit_feedback">Submit Feedback</button>
            </form>
        </div>
    </div>























    <!-- Footer Start -->
    <div class="footer container-fluid mt-5 py-5 px-sm-3 px-md-5 text-white">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-primary mb-4">Get In Touch</h4>
                <p><i class="fa fa-map-marker-alt mr-2"></i>123 Gampaha</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                <p><i class="fa fa-envelope mr-2"></i>FlexForge@gmail.com</p>
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