<?php
include 'dashboard.php'; // Ensure the path is correct
include '../Components/DatabaseConnection.php'; 

$error_message = ''; 
$success_message = ''; 

// Check if member_id is set
if (isset($_GET['member_id'])) {
    $member_id = intval($_GET['member_id']); // Ensure we are using the correct member_id

    // Fetch the member data
    $stmt = $conn->prepare("SELECT fullname, username, dob, gender, contact, email, address, exercise_plan, payment_plan FROM MemberRegister WHERE member_id = ?");
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
    } else {
        $error_message = "Member not found.";
    }
} else {
    $error_message = "No member_id provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <link rel="stylesheet" href="../css/UserRegister.css">
    <style>
        .error-message, .success-message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Member</h2>

    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php elseif ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form action="update_member.php" method="post">
        <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">

        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($member['fullname']); ?>" required>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($member['username']); ?>" required>

        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($member['dob']); ?>" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="male" <?php echo ($member['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($member['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($member['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>

        <label for="contact">Contact Number</label>
        <input type="tel" id="contact" name="contact" value="<?php echo htmlspecialchars($member['contact']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($member['address']); ?></textarea>

        <label for="exercise_plan">Exercise Plan</label>
        <select id="exercise_plan" name="exercise_plan" required>
            <option value="weight_training" <?php echo ($member['exercise_plan'] == 'weight_training') ? 'selected' : ''; ?>>Weight Training</option>
            <option value="cardio_training" <?php echo ($member['exercise_plan'] == 'cardio_training') ? 'selected' : ''; ?>>Cardio Training</option>
            <option value="cardio_weight_training" <?php echo ($member['exercise_plan'] == 'cardio_weight_training') ? 'selected' : ''; ?>>Cardio and Weight Training</option>
        </select>

        <label for="payment_plan">Payment Plan</label>
        <select id="payment_plan" name="payment_plan" required>
            <option value="one_month" <?php echo ($member['payment_plan'] == 'one_month') ? 'selected' : ''; ?>>One Month</option>
            <option value="six_months" <?php echo ($member['payment_plan'] == 'six_months') ? 'selected' : ''; ?>>Six Months</option>
            <option value="one_year" <?php echo ($member['payment_plan'] == 'one_year') ? 'selected' : ''; ?>>One Year</option>
        </select>

        <button type="submit">Update Member</button>
    </form>

</div>

</body>
</html>
