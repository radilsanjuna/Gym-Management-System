<!-- Navbar Start -->
<div class="container-fluid p-0 nav-bar">
    <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
        <a href="" class="navbar-brand">
            <h1 class="m-0 display-4 font-weight-bold text-uppercase text-white">FlexForge</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto p-4 bg-secondary">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.php" class="nav-item nav-link">About Us</a>
                <a href="feature.php" class="nav-item nav-link">Our Features</a>
                <a href="class.php" class="nav-item nav-link">Classes</a>
                <a href="graph.php" class="nav-item nav-link">BMI</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
                <a href="../member/test.php" class="nav-item nav-link">Get the QR Code</a>
                <a href="../member/PaymentPortal.php" class="nav-item nav-link">Payment</a>

                <!-- Notification Icon -->
                <div class="nav-item nav-link">
                    <a href="notification.php" class="text-white" style="position: relative;">
                        <i class="fas fa-bell"></i>
                        <!-- Notification Badge -->
                        <span style="
                            position: absolute;
                            top: -5px;
                            right: -5px;
                            background-color: red;
                            color: white;
                            border-radius: 50%;
                            padding: 5px;
                            font-size: 12px;
                        "></span> <!-- Example notification count -->
                    </a>
                </div>

                <!-- Profile Icon -->
                <div class="nav-item nav-link">
                    <a href="profile.php" class="text-white" title="Profile">
                        <i class="fas fa-user"></i>
                    </a>
                </div>

                <!-- Logout Icon -->
                <div class="nav-item nav-link">
                    <a href="logout.php" class="text-white" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->

<!-- Include Font Awesome for the icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
