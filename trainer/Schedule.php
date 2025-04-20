<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Dashboard</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Lighter background color */
            color: #333; /* Darker text color for contrast */
            display: flex;
        }

        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            background-color: #444; /* Slightly darker shade for sidenav */
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
            color: #fff; /* Change text color to white for contrast */
            text-align: center;
            margin-bottom: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #fff; /* Change link color to white */
            display: block;
            background: none;
            text-align: left;
            border: none;
            outline: none;
            width: 100%;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            background-color: #555; /* Change hover color for links */
        }
        .dropdown-container {
            display: none;
            padding-left: 20px;
        }
        .dropdown {
            position: relative;
        }
        .active {
            background-color: #555; /* Active dropdown button color */
        }

        .container {
            margin-left: 270px;
            width: calc(100% - 270px);
            padding: 20px;
            background-color: #fff; /* White background for container */
            border-radius: 5px; /* Rounded corners for container */
            color: #333; /* Darker font color for the container text */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
        }

        header {
            text-align: center;
            padding: 10px;
        }

        .dashboard {
            margin-top: 20px;
        }

        .greeting {
            text-align: center;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .stat-item {
            background-color: #f8f9fa; /* Light background color for cards */
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 30%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
        }

        .actions {
            text-align: center;
        }

        button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Dropdown icon */
        .fas.fa-caret-down {
            float: right;
            padding-right: 10px;
        }

        /* Form styling */
        .form-container {
            background-color: #f8f9fa; /* Light background color for form */
            padding: 20px;
            border-radius: 5px;
            color: #333; /* Darker text color for form */
            margin-top: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
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
            <a href="../admin/view_payment.php">View Payments</a>
        </div>
    </div>

    <a href="notification_page.php">Notifications</a>
    <a href="#contact">Announcements</a>
</div>

<div class="container">
    <header>
        <h1>Welcome, Trainer!</h1>
    </header>
    <div class="dashboard">
        <div class="greeting">
            <h2>Hello, <span id="trainerName">John Doe</span>!</h2>
            <p>Here are your quick stats:</p>
        </div>
        <div class="stats">
            <div class="stat-item">
                <h3>Total Clients</h3>
                <p id="totalClients">25</p>
            </div>
            <div class="stat-item">
                <h3>Sessions This Week</h3>
                <p id="sessionsThisWeek">10</p>
            </div>
            <div class="stat-item">
                <h3>Upcoming Appointments</h3>
                <p id="upcomingAppointments">3</p>
            </div>
        </div>
        <div class="actions">
            <button onclick="viewClients()">View Clients</button>
            <button onclick="scheduleSession()">Schedule a Session</button>
        </div>

        <!-- Add Trainer Schedule Form -->
        <div class="form-container">
            <h2>Add Trainer Schedule</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="trainer_id">Trainer ID:</label>
                    <input type="number" name="trainer_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="day">Day:</label>
                    <input type="text" name="day" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="time">Time:</label>
                    <input type="time" name="time" class="form-control" required>
                </div>
                <button type="submit" name="add_schedule" class="btn btn-primary">Add Schedule</button>
            </form>

            <?php
            if (isset($_POST['add_schedule'])) {
                $trainer_id = $_POST['trainer_id'];
                $day = $_POST['day'];
                $time = $_POST['time'];

                include '../Components/DatabaseConnection.php';

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO schedules (trainer_id, day, time) VALUES ('$trainer_id', '$day', '$time')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success mt-3'>Schedule added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>
</div>

<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            dropdownContent.classList.toggle("show"); // Toggle the 'show' class
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

    // Function to view clients
    function viewClients() {
        window.location.href = 'view_clients.php'; // Redirect to view clients page
    }

    // Function to schedule a session
    function scheduleSession() {
        window.location.href = 'schedule_session.php'; // Redirect to schedule session page
    }
</script>

</body>
</html>
