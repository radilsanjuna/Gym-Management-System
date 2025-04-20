<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/font.css">
    <title>Gym Equipment Management</title>
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        /* Centering the page content */
        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Table and button title styling */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Success message styling */
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Center the button */
        .btn-container {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            float: left; /* Floats the table to the left */
    margin-left: 10%; /* Space on the right */
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        /* Header styling */
        th {
            background-color: #333;
            color: white;
        }

        /* Alternate row color for better readability */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Image styling in table */
        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        /* Button styling for actions */
        .action-btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #f0ad4e;
        }

        .edit-btn:hover {
            background-color: #ec971f;
        }

        .delete-btn {
            background-color: #d9534f;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Gym Equipment</h1>

        <!-- Success Message -->
        <div id="successMessage" class="success-message" style="display:none;"></div>

      

        <!-- Equipment Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dashboard.php'; 
          include '../Components/DatabaseConnection.php';
                // Fetch the equipment from the database
                $sql = "SELECT * FROM gym_equipment";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";

                        // Display image
                        echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "'></td>";

                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>
                                <a href='edit_equipment.php?id=" . $row['id'] . "' class='action-btn edit-btn'>Edit</a>
                                <a href='#' onclick='confirmDelete(" . $row['id'] . ")' class='action-btn delete-btn'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>No equipment found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Function to confirm deletion
        function confirmDelete(id) {
            var confirmAction = confirm("Are you sure you want to delete this equipment?");
            if (confirmAction) {
                // If confirmed, send an AJAX request to delete the equipment
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "delete_equipment.php?id=" + id, true);
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        // On success, remove the row from the table
                        var successMessage = document.getElementById('successMessage');
                        successMessage.innerHTML = "Equipment deleted successfully.";
                        successMessage.style.display = 'block';
                        
                        // Reload the page or remove the specific row from DOM
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                };
                xhr.send();
            }
        }
    </script>
</body>
</html>
