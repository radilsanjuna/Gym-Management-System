<?php
// Include necessary files
include 'dashboard.php'; 
include '../Components/DatabaseConnection.php'; 

// Initialize the search variable
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch all registered members and get their due date and amount from the payments table
$sql = "SELECT m.member_id, m.username, m.exercise_plan, m.payment_plan, p.due_date, p.amount
        FROM memberregister AS m
        LEFT JOIN payments AS p ON m.member_id = p.member_id";

// Modify the SQL query if there's a search term
if (!empty($searchTerm)) {
    $searchTerm = $conn->real_escape_string($searchTerm); // Sanitize input to prevent SQL injection
    $sql .= " WHERE m.username LIKE '%$searchTerm%'"; // Filter by username
}

$result = $conn->query($sql);

// Current month and year for payment checking
$currentMonth = date('m');
$currentYear = date('Y');
?>

<!-- Custom CSS Styles -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f8f8f8;
    }

    .container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: #fff;
        float: left;
        margin-left: 10%;
    }

    table, th, td {
        border: 1px solid #ccc;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #333;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Button styling for actions */
    .btn {
        padding: 5px 10px;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #d9534f;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn:hover {
        opacity: 0.8;
    }

    /* Search input styling */
    .search-container {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-container input {
        padding: 8px;
        width: 300px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .search-container button {
        padding: 8px 12px;
        margin-left: 5px;
        background-color: #d9534f;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-container button:hover {
        opacity: 0.8;
    }

    .alert {
        color: red;
        font-weight: bold;
    }
</style>

<!-- Make Payment Section -->
<div class="container">
    <h1>Make Payment</h1>

    <!-- Search Form -->
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by Username" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Username</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Exercise Plan</th>
                <th>Payment Plan</th>
                <th>Action</th>
                <th>Reminder</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hasPaid = false;

                    // Check if the member has already paid for the current month
                    $checkPaymentSql = "SELECT * FROM payments WHERE member_id = " . htmlspecialchars($row['member_id']) . " 
                                        AND MONTH(due_date) = '$currentMonth' 
                                        AND YEAR(due_date) = '$currentYear'";
                    $paymentResult = $conn->query($checkPaymentSql);
                    if ($paymentResult && $paymentResult->num_rows > 0) {
                        $hasPaid = true; // User has already paid
                    }

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['member_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . (!empty($row['due_date']) ? htmlspecialchars($row['due_date']) : "N/A") . "</td>";
                    echo "<td>" . (!empty($row['amount']) ? htmlspecialchars($row['amount']) : "N/A") . "</td>";
                    echo "<td>" . htmlspecialchars($row['exercise_plan']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['payment_plan']) . "</td>";
                    
                    // Check if the user has already paid
                    if ($hasPaid) {
                        echo "<td colspan='2' class='alert'>Already paid this month</td>";
                    } else {
                        echo "<td><a href='make_payment_2.php?member_id=" . htmlspecialchars($row['member_id']) . "' class='btn btn-primary'>Make Payment</a></td>";
                        echo "<td><a href='send_reminder.php?member_id=" . htmlspecialchars($row['member_id']) . "' class='btn btn-warning'>Alert</a></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No members found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
