<?php
include 'dashboard.php'; 
include '../Components/DatabaseConnection.php'; 

// Fetch members and their payment details from the database
$query = "
    SELECT 
        m.member_id, 
        m.username, 
        m.exercise_plan, 
        m.payment_plan, 
        p.amount, 
        p.payment_date, 
        p.due_date 
    FROM 
        memberregister AS m 
    LEFT JOIN 
        payments AS p ON m.member_id = p.member_id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Member's Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font.css">
    <style>
  <style>
        body {
            font-family: "Poppins", sans-serif; /* Use the Poppins font */
            background-color: #f8f9fa; /* Light background color */
        }
        .container {
            margin-top: 50px; /* Space above the container */
        }
        h2 {
            margin-bottom: 30px; /* Space below the heading */
            color: #343a40; /* Dark heading color */
        }
        .form-group {
            margin-bottom: 20px; /* Space below the search input */
        }
        .table {
            border: 1px solid #dee2e6; /* Table border */
        }
        th {
            background-color: #343a40; /* Dark header background */
            color: white; /* White text in header */
            padding: 12px; /* Padding in header */
        }
        td {
            padding: 12px; /* Padding in table cells */
            vertical-align: middle; /* Center align text vertically */
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Light grey for even rows */
        }
        tbody tr:hover {
            background-color: #d1ecf1; /* Light blue on hover */
        }
        .make-payment-btn {
            background-color: #28a745; /* Green button */
            color: white; /* White text for the button */
        }
        .make-payment-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }
        .search-container {
            margin-bottom: 20px; /* Space below the search input */
        }
        .search-container input {
            padding: 10px; /* Padding in the search input */
            border: 1px solid #ced4da; /* Border for the search input */
            border-radius: 4px; /* Rounded corners */
            width: 300px; /* Width of the search input */
        }
        .sidebar {
            width: 250px; /* Width of the sidebar */
            position: fixed; /* Fix it on the left */
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40; /* Dark sidebar background */
            padding: 15px;
            color: white;
        }
        .content {
            margin-left: 270px; /* Make space for the sidebar */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registered Member's Payment</h2>
        <div class="form-group row search-container">
            <label for="search" class="col-sm-1 col-form-label">Search:</label>
            <div class="col-sm-11">
                <input type="text" class="form-control" id="search" placeholder="Search by Username or Member ID">
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Exercise Plan</th>
                    <th>Payment Plan</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody id="memberTable">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['member_id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['exercise_plan'] . "</td>";
                        echo "<td>" . $row['payment_plan'] . "</td>";
                        echo "<td>" . ($row['amount'] ? '$' . $row['amount'] : 'N/A') . "</td>"; // Check if amount is available
                        echo "<td>" . ($row['payment_date'] ? $row['payment_date'] : 'N/A') . "</td>"; // Check if payment_date is available
                        echo "<td>" . ($row['due_date'] ? $row['due_date'] : 'N/A') . "</td>"; // Check if due_date is available
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No members found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#memberTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
