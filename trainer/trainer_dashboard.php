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
            position: fixed;
            background-color: #333;
            padding-top: 20px;
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
    </style>
</head>
<body>
    <!-- Sidenav -->
    <div class="sidenav">
        <img src="../img/logo.jpg" alt="Gym Logo">
        <h2>Fitness Gym</h2> <!-- Gym Name -->

        <a href="trainer_profile.php">Profile</a>

   

        <a href="add_class.php">Upload Class</a>

    <a href="add_schedule.php">Upload Schedule</a>
    <a href="add_announcement.php">Announcements</a>
  
    <a href="logout.php" onclick="return confirmLogout()">LogOut</a>

<script>
    function confirmLogout() {
        // Display a confirmation dialog
        var confirmation = confirm("Are you sure you want to log out?");
        // If user clicks "OK", return true to proceed with logout
        return confirmation;
    }
</script>

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
