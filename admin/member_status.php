<?php
// Database connection
include 'dashboard.php'; 
include '../Components/DatabaseConnection.php'; 

// Query to get all members, including those without any payment
$sql = "
    SELECT m.member_id, m.fullname, p.due_date, 
    CASE 
        WHEN p.due_date IS NULL THEN 'No Payment'
        WHEN p.due_date >= CURDATE() THEN 'Active'
        ELSE 'Expired'
    END AS membership_status
    FROM memberregister m
    LEFT JOIN payments p ON m.member_id = p.member_id
    AND p.payment_id = (
        SELECT MAX(payment_id) 
        FROM payments 
        WHERE member_id = m.member_id
    )
";

$result = $conn->query($sql);
?>

<!-- HTML Table to display member status -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Status</title>
    <style>
        /* General body styling */
      /* General body styling */
body {
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f7f9fc; /* Changed to black as per original intent */
}

/* Container for centering content */
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Retained box shadow */
}

/* Page title styling */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

/* Table border */
table, th, td {
    border: 1px solid #ccc;
}

/* Table header styling */
th, td {
    padding: 12px;
    text-align: left;
}

/* Header background and text color */
th {
    background-color: #333;
    color: white;
}

/* Alternating row colors */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Status cell styling */
.status {
    font-weight: bold;
    text-transform: capitalize;
}

/* Active status color */
.active {
    color: green;
    background-color: transparent; /* Ensure no background color for Active status */
}

/* Expired and No Payment status colors */
.expired, .no-payment {
    color: red;
}

/* Text alignment for centered content */
.text-center {
    text-align: center;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Gym Members' Status</h2>

    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Full Name</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['member_id']; ?></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['due_date'] ? $row['due_date'] : 'N/A'; ?></td>
                        <td class="status <?php echo strtolower(str_replace(' ', '-', $row['membership_status'])); ?>">
                            <?php echo $row['membership_status']; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No members found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
