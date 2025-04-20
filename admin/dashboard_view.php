<?php
include '../Components/DatabaseConnection.php'; // Include the database connection
include 'dashboard.php';

// Query to get the total earnings
$sqlEarnings = "SELECT SUM(amount) as totalEarnings FROM payments WHERE payment_status = 'Paid'";
$resultEarnings = $conn->query($sqlEarnings);
$totalEarnings = 0;

if ($resultEarnings && $resultEarnings->num_rows > 0) {
    $rowEarnings = $resultEarnings->fetch_assoc();
    $totalEarnings = $rowEarnings['totalEarnings'];
}

// Query to get the count of members
$sqlMembers = "SELECT COUNT(*) AS member_count FROM memberregister";
$resultMembers = $conn->query($sqlMembers);
$memberCount = 0;

if ($resultMembers && $resultMembers->num_rows > 0) {
    $rowMembers = $resultMembers->fetch_assoc();
    $memberCount = $rowMembers['member_count'];
}

// Query to get the count of paid members
$sqlPaidMembers = "SELECT COUNT(DISTINCT member_id) AS paid_member_count FROM payments WHERE payment_status = 'Paid'";
$resultPaidMembers = $conn->query($sqlPaidMembers);
$paidMemberCount = 0;

if ($resultPaidMembers && $resultPaidMembers->num_rows > 0) {
    $rowPaidMembers = $resultPaidMembers->fetch_assoc();
    $paidMemberCount = $rowPaidMembers['paid_member_count'];
}

// Query to get the count of members per exercise plan
$sqlExercisePlans = "SELECT exercise_plan, COUNT(*) AS member_count FROM memberregister GROUP BY exercise_plan";
$resultExercisePlans = $conn->query($sqlExercisePlans);

$exercisePlans = [];
$memberCounts = [];

if ($resultExercisePlans && $resultExercisePlans->num_rows > 0) {
    while ($row = $resultExercisePlans->fetch_assoc()) {
        $exercisePlans[] = $row['exercise_plan'];
        $memberCounts[] = $row['member_count'];
    }
}

// Close the database connection
$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            margin: 0;
            padding: 50px;
        }
        
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background-color: #ffffff; 
            color: #333; 
            text-align: center; 
            padding: 20px; 
            border-radius: 10px; 
            width: 200px; 
            height: 150px; 
            margin: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            position: relative; 
            transition: transform 0.2s, box-shadow 0.2s; 
            cursor: pointer; 
        }

        .card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); 
        }

        .count {
            background-color: #e74c3c; 
            color: white; 
            font-size: 20px; 
            padding: 5px 10px; 
            border-radius: 50%; 
            position: absolute; 
            top: 10px; 
            right: 10px; 
            transform: translate(50%, -50%); 
        }

        .active-members {
            border-left: 5px solid #007bff;
        }

        .registered-members {
            border-left: 5px solid #ff5722;
        }

        .total-earnings {
            border-left: 5px solid #28a745;
        }

        .announcements {
            border-left: 5px solid #ffc107;
        }

        .icon {
            font-size: 40px; 
            margin-bottom: 10px; 
        }

        .text {
            font-size: 18px; 
            font-weight: bold; 
        }

        .earnings-text {
            font-size: 24px; 
            font-weight: bold; 
            margin-top: 10px; 
        }

        .graph-container {
            margin-top: 50px;
            width: 80%;
            max-width: 800px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function redirectToManageMembers() {
            window.location.href = 'ManageMember.php';
        }

        function redirectToAnnouncement() {
            window.location.href = 'announcement.php';
        }

        function redirectToPaidMembers() {
            window.location.href = 'paidMembers.php';
        }
    </script>
</head>
<body>

<div class="dashboard-container">
    <div class="card active-members" onclick="redirectToManageMembers()">
        <div class="icon">👤</div>
        <div class="text"> Registered Members</div>
        <div class="count"><?php echo $memberCount; ?></div>
    </div>

    <div class="card registered-members">
        <div class="icon">👥</div>
        <div class="text">Active Members</div>
        <div class="count"><?php echo $paidMemberCount; ?></div>
    </div>

    <div class="card total-earnings" onclick="redirectTofinancial_report()">
    <div class="icon">Rs.</div>
    <div class="earnings-text">Total Earnings</div>
    <div>Rs.<span id="total-earnings"><?php echo number_format($totalEarnings, 2); ?></span></div>
</div>

<script>
function redirectTofinancial_report() {
    // Redirect to the financial_report.php page
    window.location.href = 'financial_report.php';
}
</script>


    <div class="card announcements" onclick="redirectToadd_announcement()">
        <div class="icon">📢</div>
        <div class="text">Announcements</div>
    </div>
</div>

<!-- Add the graph section -->
<div class="graph-container">
    <canvas id="exercisePlanChart"></canvas>
</div>

<script>
    // Fetch PHP data into JavaScript variables
    const exercisePlans = <?php echo json_encode($exercisePlans); ?>;
    const memberCounts = <?php echo json_encode($memberCounts); ?>;

    // Initialize Chart.js
    const ctx = document.getElementById('exercisePlanChart').getContext('2d');
    const exercisePlanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: exercisePlans, // Exercise plans as labels
            datasets: [{
                label: 'Number of Members',
                data: memberCounts, // Member counts as data
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
