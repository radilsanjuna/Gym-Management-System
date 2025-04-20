<?php
include '../Components/DatabaseConnection.php'; 
//include 'dashboard.php'; 

$member_data = null;
$result = null;
$error_message = null;

// Check if a member ID is set
if (isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];

    // Fetch member details by member ID
    $member_stmt = $conn->prepare("SELECT member_id FROM payments WHERE member_id LIKE ?");
    $search_id = "%" . $member_id . "%";
    $member_stmt->bind_param("s", $search_id);
    $member_stmt->execute();
    $member_result = $member_stmt->get_result();

    if ($member_result->num_rows > 0) {
        $member_data = $member_result->fetch_assoc();

        // Fetch payment details for the member
        $stmt = $conn->prepare("SELECT payment_id, payment_date, payment_amount, payment_method, billing_cycle, start_date, end_date, ExercisePlan FROM payments WHERE member_id = ?");
        $stmt->bind_param("i", $member_data['member_id']);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $error_message = "No member found with that ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment Details</title>
    <link rel="stylesheet" href="../css/UserRegister.css">
    <link rel="stylesheet" href="../css/font.css">
    <style>
        body {
            position: relative;
            margin-left: 200px;
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f9f9f9; /* Light background color */
        }
        .container {
            max-width: 1200px; /* Increased max-width for the container */
            margin: auto;
            padding: 20px; /* Added padding */
            background-color: #ffffff; /* White background for the container */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
            border-radius: 8px; /* Rounded corners */
        }
        h2, h3 {
            color: #333; /* Darker text color for headings */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); /* Shadow for the table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px; /* Increased padding */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold; /* Bold text for headers */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Zebra striping for rows */
        }
        tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }
        .error {
            color: red;
            font-weight: bold; /* Bold error messages */
        }
        input[type="text"] {
            width: calc(100% - 22px); /* Full width with padding */
            padding: 10px; /* Padding inside input */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 10px; /* Space below the input */
        }
        button {
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            padding: 10px 15px; /* Padding inside button */
            border: none; /* No border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Cursor change on hover */
        }
        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search Member Payment Details</h2>

    <form method="POST" action="">
        <input type="text" name="member_id" placeholder="Enter member ID" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($error_message): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <?php if ($member_data): ?>
        <h3>Payment Details for Member ID: <?php echo htmlspecialchars($member_data['member_id']); ?></h3>

        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Billing Cycle</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Exercise Plan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($payment = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                        <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['payment_amount']); ?></td>
                        <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                        <td><?php echo htmlspecialchars($payment['billing_cycle']); ?></td>
                        <td><?php echo htmlspecialchars($payment['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['ExercisePlan']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No payment records found for this member.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>