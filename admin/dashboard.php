<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Dashboard</title>

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        /* Sidenav styling */
        .sidenav {
    height: 100%;
    width: 250px;
    position: fixed; /* Keeps it fixed on the screen */
    left: 0; /* Ensure it stays on the left side */
    top: 0; /* Align to the top */
    background-color: #333;
    padding-top: 20px;
    z-index: 1000; /* Ensure it's above other elements */
}
        .sidenav img {
            width: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }
        .sidenav h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #f1f1f1;
            display: block;
            background: none;
            text-align: left;
            border: none;
            outline: none;
            width: 100%;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            background-color: #575757;
        }
        .dropdown-container {
            display: none;
            background-color: #414141;
            padding-left: 15px;
        }
        .active {
            background-color: #575757;
        }
        .fas.fa-caret-down {
            float: right;
            padding-right: 10px;
        }
        .content {
    margin-left: 250px; /* Push the content to start after the sidebar */
    padding: 20px; /* Add padding for a neat layout */
    background-color: #f0f0f0;
    min-height: 100vh; /* Ensure it spans the full height of the viewport */
    overflow-x: auto; /* Prevent overflow issues with tables */
}
    </style>
</head>
<body>
    <!-- Sidenav -->
    <div class="sidenav">
        <img src="../img/logo.jpg" alt="Gym Logo">
        <h2>FlexForge Gym</h2> <!-- Gym Name -->

        <a href="dashboard_view.php">Dashboard</a>

        <button class="dropdown-btn">Members
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/UserRegister.php">Add Members</a>
            <a href="../admin/ManageMembers.php">View Members</a>
        </div>

        <a href="member_status.php">Member Status</a>

        <button class="dropdown-btn">Trainer
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/add_trainer.php">Add Trainer</a>
            <a href="../admin/view_trainers.php">View Trainers</a>
        </div>

        <button class="dropdown-btn">Equipment
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/add_equipment.php">Add Equipment</a>
            <a href="../admin/view_equipment.php">Manage Equipment</a>
        </div>

        <button class="dropdown-btn">Payment
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../admin/make_payment.php">Make Payment</a>
            <a href="../admin/view_payment.php">View Payments</a>
        </div>

        <button class="dropdown-btn">Attendance
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="../member/qrscan.php">Add Attendance  </a>
            <a href="../admin/attendance.php">View Attendance </a>
        </div>

        <a href="add_class.php">Add Class</a>

        <a href="feedback.php">FeedBack</a>

        <a href="add_announcement.php">Announcement</a>
       

        <a href="logout.php">LogOut</a>
    </div>

    <!-- Dropdown Script -->
    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
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
