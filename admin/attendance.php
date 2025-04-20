<?php
// Database connection
include '../Components/DatabaseConnection.php'; 
include 'dashboard.php'; 
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search_query = '';
$attendance_data = [];

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search_query = trim($_POST['search_query']);

    // Fetch attendance records for the searched username
    $sql = "SELECT username, scan_time, COUNT(*) as attendance_count 
            FROM attendance 
            WHERE username LIKE ? 
            GROUP BY username, scan_time 
            ORDER BY scan_time DESC";
    
    $stmt = $conn->prepare($sql);
    $search_query_param = '%' . $search_query . '%'; // Add wildcards for partial match
    $stmt->bind_param("s", $search_query_param);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all data
    while ($row = $result->fetch_assoc()) {
        $attendance_data[] = $row;
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Attendance Records</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            margin-top: 20px;
        }
        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search Attendance Records</h2>

    <div class="search-form">
        <form action="" method="POST" class="d-flex justify-content-center">
            <input type="text" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>" class="form-control w-50 me-2" placeholder="Enter username">
            <input type="submit" name="search" value="Search" class="btn btn-primary">
        </form>
    </div>

    <?php
    // Display the attendance data if any records are found
    if (!empty($attendance_data)) {
        echo "<table class='table table-striped table-hover'>
                <thead class='table-dark'>
                    <tr>
                        <th>Username</th>
                        <th>Scan Time</th>
                        <th>Attendance Count</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($attendance_data as $record) {
            echo "<tr>
                    <td>{$record['username']}</td>
                    <td>{$record['scan_time']}</td>
                    <td>{$record['attendance_count']}</td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        // If no results found
        if (isset($_POST['search'])) {
            echo "<p class='text-center text-danger'>No records found for '$search_query'.</p>";
        } else {
            echo "<p class='text-center text-muted'>Please enter a username to search.</p>";
        }
    }

    // Close connection
    $conn->close();
    ?>
</div>

<!-- Bootstrap JS (Optional if you need dynamic components like modals or dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>