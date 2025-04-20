<?php
include '../Components/DatabaseConnection.php'; 

// Get the current date and one month back date
$currentDate = date('Y-m-d');
$lastMonth = date('Y-m-d', strtotime('-1 month'));

// Query to get attendance records for the last month
$sql = "SELECT * FROM attendance 
        WHERE payment_status = 'paid' 
        AND scan_time BETWEEN '$lastMonth' AND '$currentDate'
        ORDER BY scan_time DESC";
        
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Member Attendance for the Last Month</h1>

        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>ID</th>
                    <th>Member ID</th>
                    <th>Email</th>
                    <th>Exercise Plan</th>
                    <th>Payment Plan</th>
                    <th>Scan Time</th>
                    <th>Payment Status</th>
                  </tr>";

            // Fetch the data and display in table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['member_id']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['exercise_plan']}</td>
                        <td>{$row['payment_plan']}</td>
                        <td>{$row['scan_time']}</td>
                        <td>{$row['payment_status']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No attendance records found for the last month.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
