<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Member Performance</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Record Member Performance</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="member_id">Member ID:</label>
                    <input type="number" class="form-control" id="member_id" name="member_id" required>
                </div>
                <div class="form-group">
                    <label for="session_id">Session ID:</label>
                    <input type="number" class="form-control" id="session_id" name="session_id" required>
                </div>
                <div class="form-group">
                    <label for="performance">Performance:</label>
                    <input type="text" class="form-control" id="performance" name="performance" required>
                </div>
                <button type="submit" class="btn btn-primary" name="add_performance">Record Performance</button>
            </form>

            <?php
            if (isset($_POST['add_performance'])) {
                $member_id = $_POST['member_id'];
                $session_id = $_POST['session_id'];
                $performance = $_POST['performance'];

                // Database connection
                $conn = new mysqli('localhost', 'username', 'password', 'gym_db');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO performance (member_id, session_id, performance) VALUES ('$member_id', '$session_id', '$performance')";

                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success mt-3'>Performance recorded successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                }

                $conn->close();
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
