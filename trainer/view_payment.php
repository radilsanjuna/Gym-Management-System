<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>View Payments</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Light background color */
            color: #333; /* Darker text color */
            display: flex;
        }

        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            background-color: #444; /* Sidebar background color */
            padding: 15px;
            flex-shrink: 0;
        }
        .sidenav img {
            width: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }
        .sidenav h2 {
            color: #fff; /* Text color in sidebar */
            text-align: center;
            margin-bottom: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #fff; /* Link color */
            display: block;
            background: none;
            text-align: left;
            border: none;
            outline: none;
            width: 100%;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            background-color: #555; /* Hover effect */
        }
        .dropdown-container {
            display: none;
            padding-left: 20px;
        }
        .dropdown {
            position: relative;
        }
        .active {
            background-color: #555; /* Active state for dropdown */
        }

        .container {
            margin-left: 270px;
            width: calc(100% - 270px);
            padding: 20px;
            background-color: #fff; /* Container background */
            border-radius: 5px; /* Rounded corners */
            color: #333; /* Text color */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
        }

        .payment-item {
            background-color: #f8f9fa; /* Light background for payment items */
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Light shadow */
        }
    </style>
</head>
<body>

<div class="sidenav">
    <br>
    <img src="../img/logo.jpg" alt="Gym Logo">
    <h2>Flex Forge Gym</h2>

    <div class="dropdown">
        <button class="dropdown-btn">Profile
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="update_profile.php" class="dropdown-link">Update Profile</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropdown-btn">Class Management
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="manage_class.php">Manage Classes</a>
            <a href="add_class.php">Add Class</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropdown-btn">Payment
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/make_payment.php">Make Payment</a>
            <a href="../admin/view_payment.php" class="active">View Payments</a> <!-- Active link -->
        </div>
    </div>

    <a href="notification_page.php">Notifications</a>
    <a href="announcements.php">Announcements</a>
</div>

<div class="container">
    <header>
        <center><h1>View Payments</h1></center>
    </header>
  <br>
  
    <div class="payments-list">
        <h2>Payments Overview</h2>

        <!-- Example payments -->
        <div class="payment-item">
            <h5>Payment ID: 1001</h5>
            <p>Member Name: John Doe</p>
            <p>Amount: $50.00</p>
            <p>Date: 2024-10-01</p>
            <p>Status: Completed</p>
        </div>
        <div class="payment-item">
            <h5>Payment ID: 1002</h5>
            <p>Member Name: Jane Smith</p>
            <p>Amount: $75.00</p>
            <p>Date: 2024-10-02</p>
            <p>Status: Completed</p>
        </div>
        <div class="payment-item">
            <h5>Payment ID: 1003</h5>
            <p>Member Name: Anjula Perera</p>
            <p>Amount: $60.00</p>
            <p>Date: 2024-10-03</p>
            <p>Status: Pending</p>
        </div>
        <!-- Add more payment items as needed -->
    </div>
</div>

<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            dropdownContent.classList.toggle("show");
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>

</body>
</html>
