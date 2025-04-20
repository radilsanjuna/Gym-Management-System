<?php
 include 'dashboard.php'; 
include '../Components/DatabaseConnection.php';

$message = '';

if (isset($_POST['add_equipment'])) {
    // Get form inputs
    $name = $_POST['name'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Handle image upload
    $target_dir = "../uploads/";
    $image = $_FILES['image']['name'];
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        $message = "File is not an image.";
    } else {
        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $message = "Only JPG, JPEG, and PNG files are allowed.";
        } else {
            // Upload the image
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $stmt = $conn->prepare("INSERT INTO gym_equipment (name, type, quantity, description, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiss", $name, $type, $quantity, $description, $target_file);
                
                if ($stmt->execute()) {
                    $message = "Equipment added successfully!";
                } else {
                    $message = "Error: " . $conn->error;
                }
                
                $stmt->close();
                $conn->close();
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gym Equipment</title>
    <link rel="stylesheet" href="../css/font.css">
    <style>
        /* General body styling */
     /* General body styling */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f7f9fc;
    margin: 0;
    padding: 0;
}

/* Container styling */
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 40px;
    background-color: #ffffff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05); /* Softer shadow */
    border-radius: 10px; /* Rounded corners */
    border: 1px solid #e3e6eb; /* Light border */
}

/* Heading styling */
h1 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 30px;
}

/* Success/Error message styling */
.message {
    text-align: center;
    padding: 15px;
    font-size: 16px;
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 8px;
    margin-bottom: 20px;
    display: none;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
}

/* Label styling */
label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #555;
    font-size: 14px;
}

/* Input, textarea, and file input styling */
input[type="text"],
input[type="number"],
input[type="file"],
textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 14px;
    background-color: #fafafa;
    transition: all 0.3s ease;
}

input[type="file"] {
    padding: 10px;
}

input:focus,
textarea:focus {
    border-color: #007bff;
    background-color: #ffffff;
    outline: none;
}

/* Button styling */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease;
    width: 100%;
}

button:hover {
    background-color: #218838;
}

/* Secondary button */
.btn-secondary {
    background-color: #6c757d;
    color: white;
    margin-top: 20px;
    padding: 12px;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    display: block;
    font-size: 16px;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Equipment</h1>

        <!-- Display success or error message -->
        <div id="message-box" class="message <?php if(!empty($message)) { echo $message == 'Equipment added successfully!' ? '' : 'error-message'; } ?>" style="display: <?php echo !empty($message) ? 'block' : 'none'; ?>">
            <?php echo $message; ?>
        </div>

        <form action="add_equipment.php" method="post" enctype="multipart/form-data">
            <label for="name">Equipment Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="image">Equipment Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" name="add_equipment">Add Equipment</button>
        </form>


    </div>

    <script>
        // Hide the message after 3 seconds
        setTimeout(function() {
            document.getElementById('message-box').style.display = 'none';
        }, 3000);
    </script>
</body>
</html>
