<?php
// Include database connection
include '../Components/DatabaseConnection.php'; 
include 'dashboard.php'; 

// Get the member_id from the URL
$member_id = isset($_GET['member_id']) ? intval($_GET['member_id']) : 0;

// Fetch the user's details based on the member_id
if ($member_id > 0) {
    $sql = "SELECT m.username, m.exercise_plan, m.payment_plan 
            FROM memberregister AS m 
            WHERE m.member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();

    if (!$member) {
        die('Member not found');
    }
} else {
    die('Invalid member ID');
}
?>

<!-- Form for displaying user details and calculating payment -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
    <style>
        /* General styling for body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Centered form container */
        .payment-form-container {
            background-color: #fff;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
        }

        /* Form heading */
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Form labels */
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        /* Form inputs */
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Readonly inputs */
        input[readonly] {
            background-color: #f0f0f0;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Responsive adjustments for small screens */
        @media (max-width: 500px) {
            .payment-form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="payment-form-container">
    <h1>Make Payment for <?php echo htmlspecialchars($member['username']); ?></h1>

    <form action="process_payment.php" method="POST">
        <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
        
        <!-- Display user details -->
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($member['username']); ?>" readonly>

        <label for="exercise_plan">Exercise Plan:</label>
        <input type="text" name="exercise_plan" value="<?php echo htmlspecialchars($member['exercise_plan']); ?>" readonly>

        <label for="payment_plan">Payment Plan:</label>
        <input type="text" name="payment_plan" value="<?php echo htmlspecialchars($member['payment_plan']); ?>" readonly>

        <!-- JavaScript to calculate amount -->
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" readonly>

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" required>

        <button type="submit">Pay</button>
    </form>
</div>

<script>
    // Get the exercise plan and payment plan values
    const exercisePlan = "<?php echo $member['exercise_plan']; ?>";
    const paymentPlan = "<?php echo $member['payment_plan']; ?>";

    // Calculate the amount based on the selected plans
    let amount = 0;

    switch (exercisePlan) {
        case 'cardio_training':
            if (paymentPlan === 'one_month') {
                amount = 2550;
            } else if (paymentPlan === 'six_months') {
                amount = 10000;
            } else if (paymentPlan === 'one_year') {
                amount = 16000;
            }
            break;

        case 'weight_training':
            if (paymentPlan === 'one_month') {
                amount = 3000;
            } else if (paymentPlan === 'six_months') {
                amount = 13000;
            } else if (paymentPlan === 'one_year') {
                amount = 20000;
            }
            break;

        case 'cardio_weight_training':
            if (paymentPlan === 'one_month') {
                amount = 3500;
            } else if (paymentPlan === 'six_months') {
                amount = 16000;
            } else if (paymentPlan === 'one_year') {
                amount = 23000;
            }
            break;

        default:
            amount = 0; // Default to 0 if no valid plan
    }

    // Set the calculated amount in the input field
    document.getElementById('amount').value = amount;
</script>

</body>
</html>
