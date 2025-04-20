<?php
include '../Components/DatabaseConnection.php'; 

if (isset($_POST['member_id']) && !empty($_FILES['schedule'])) {
    $member_id = $_POST['member_id'];
    $target_dir = "uploads/schedules/";

    // Check if directory exists, if not, create it
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory with full permissions
    }

    $target_file = $target_dir . basename($_FILES["schedule"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file type
    if ($file_type != "pdf" && $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg") {
        echo "Sorry, only PDF, JPG, JPEG, & PNG files are allowed.";
        exit;
    }

    // Verify member_id is set and valid
    if (empty($member_id)) {
        die("Invalid member ID.");
    }

    // Upload file
    if (move_uploaded_file($_FILES["schedule"]["tmp_name"], $target_file)) {
        // Use prepared statements to insert the data into the schedules table
        $stmt = $conn->prepare("INSERT INTO schedules (member_id, schedule_file) VALUES (?, ?)");
        $stmt->bind_param("is", $member_id, $target_file);  // 'i' for integer, 's' for string (file path)

        if ($stmt->execute()) {
            echo "The schedule has been uploaded and saved successfully.";
        } else {
            echo "Error inserting schedule into the database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
