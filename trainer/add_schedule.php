<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard - Add Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            margin-top: 20px;
            text-align: center;
        }
        .search-box {
            margin-bottom: 20px;
            text-align: right;
        }
        .upload-schedule {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Trainer Dashboard - Add Schedule</h2>

        <!-- Search Box -->
        <div class="search-box mb-3">
            <input type="text" id="search" class="form-control" placeholder="Search member by name or email...">
        </div>

        <!-- Members Table -->
        <table class="table table-bordered" id="membersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'trainer_dashboard.php';
                include '../Components/DatabaseConnection.php'; 
                $query = "SELECT * FROM memberregister";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['member_id']}</td>
                        <td>{$row['fullname']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact']}</td>
                        <td><button class='btn btn-primary' onclick=\"selectMember({$row['member_id']}, '{$row['fullname']}')\">Select</button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Upload Schedule Section -->
        <div class="upload-schedule">
            <form action="upload_schedule.php" method="POST" enctype="multipart/form-data" class="text-center">
                <input type="hidden" id="member_id" name="member_id" value="">
                <input type="hidden" id="member_name" name="member_name" value="">
                <h3 id="selectedMember" style="display:none;">Selected Member: <span id="member_name_display"></span></h3>
                <input type="file" name="schedule" class="form-control mb-2" accept="application/pdf,image/*" required>
                <input type="submit" value="Upload Schedule" class="btn btn-success">
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectMember(memberId, memberName) {
            document.getElementById('member_id').value = memberId;
            document.getElementById('member_name').value = memberName;
            document.getElementById('selectedMember').style.display = 'block';
            document.getElementById('member_name_display').textContent = memberName;
        }

        document.getElementById('search').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#membersTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();

                if (name.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>