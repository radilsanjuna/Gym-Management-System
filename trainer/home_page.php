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
            background-color: #f0f0f0; /* Set body background color to lighter */
            color: #333; /* Change text color for contrast */
            display: flex;
        }
     
        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            background-color: #444; /* Slightly lighter shade for sidenav */
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
            background-color: #fff; /* Container background color */
            border-radius: 5px; /* Rounded corners for container */
            color: #333; /* Darker font color for the container text */
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
            background-color: #eee; /* Card background color */
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 30%; 
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
        
    </div>

    <div class="dropdown">
        <button class="dropdown-btn">Class Management
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="add_class.php">Add Classes</a>
            <a href="add_class.php">View Class</a>
        </div>
    </div>


    <a href="notification_page.php">Notifications</a>
    <a href="add_announcement.php">Announcements</a>
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

    function viewClients() {
        alert('Redirecting to the Clients List...');
        // window.location.href = 'clients.html';
    }

    function scheduleSession() {
        alert('Redirecting to Schedule a Session...');
        // Here you can redirect to the schedule session page
        // window.location.href = 'schedule_session.html';
    }
</script>
</body>
</html>
