<?php
include '../Components/DatabaseConnection.php'; // Include your database connection
include 'dashboard.php'; 

// Fetch total revenue
$totalRevenueQuery = "SELECT SUM(amount) AS total_revenue FROM payments WHERE payment_status = 'paid'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['total_revenue'];

// Fetch revenue by training type
$revenueByTypeQuery = "SELECT training_type, SUM(amount) AS revenue FROM payments WHERE payment_status = 'paid' GROUP BY training_type";
$revenueByTypeResult = mysqli_query($conn, $revenueByTypeQuery);

// Fetch total number of payments
$totalPaymentsQuery = "SELECT COUNT(payment_id) AS total_payments FROM payments WHERE payment_status = 'paid'";
$totalPaymentsResult = mysqli_query($conn, $totalPaymentsQuery);
$totalPaymentsRow = mysqli_fetch_assoc($totalPaymentsResult);
$totalPayments = $totalPaymentsRow['total_payments'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report</title>
    <link rel="stylesheet" href="../css/dashboard.css"> <!-- Include your existing dashboard CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM4X0Y5TtB6Y0t1NI50tG5g4eGTVK9vAa0E0df" crossorigin="anonymous" /> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin-left: 250px; /* Space for sidenav */
            padding: 0; /* Remove default padding */
            height: 100vh; /* Full viewport height */
            background-color: #f0f0f0; /* Match the background color */
            display: flex; /* Use flexbox for layout */
            flex-direction: column; /* Vertical layout */
        }

        .report-container {
            flex-grow: 1; /* Allow this to grow and take up available space */
            margin: 20px; /* Add margin around the report container */
            padding: 20px;
            background-color: white; /* White background for the report */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add some shadow for depth */
            overflow-y: auto; /* Allow scrolling if content overflows */
        }

        h2, h3 {
            text-align: center;
            color: #333; /* Darker color for headings */
        }

        .total-revenue, .total-payments {
            display: flex; /* Flexbox for alignment */
            align-items: center; /* Center items vertically */
            justify-content: center; /* Center items horizontally */
            margin: 20px 0; /* Margin around sections */
            padding: 15px;
            border-radius: 5px; /* Rounded corners */
            background-color: #e3f2fd; /* Light blue background */
            color: #1976d2; /* Darker blue for text */
            font-size: 1.2em; /* Larger text */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .total-revenue i, .total-payments i {
            margin-right: 10px; /* Space between icon and text */
            font-size: 1.5em; /* Icon size */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Space above the table */
        }

        table, th, td {
            border: 1px solid #ddd; /* Lighter border for table */
        }

        th, td {
            padding: 12px; /* Increased padding */
            text-align: left;
        }

        th {
            background-color: #1976d2; /* Darker blue background for headers */
            color: white; /* White text for headers */
        }

        tr:hover {
            background-color: #f5f5f5; /* Highlight row on hover */
        }
    </style>
</head>
<body>
    <div class="report-container">
        <h2>Financial Report</h2>

        <div class="total-revenue">
            <i class="fas fa-money-bill-wave"></i> <!-- Money icon -->
            Total Revenue: <?php echo number_format($totalRevenue, 2); ?> RS
        </div>

        <div class="total-payments">
            <i class="fas fa-receipt"></i> <!-- Receipt icon -->
            Total Number of Payments: <?php echo $totalPayments; ?>
        </div>

        <h3>Revenue by Training Type</h3>
        <table>
            <tr>
                <th>Training Type</th>
                <th>Revenue (RS)</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($revenueByTypeResult)): ?>
                <tr>
                    <td><?php echo $row['training_type']; ?></td>
                    <td><?php echo number_format($row['revenue'], 2); ?> RS</td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
