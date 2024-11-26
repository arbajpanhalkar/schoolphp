<?php
include('connection.php'); // Database connection file
include('sidebar.php'); // Include sidebar for navigation

// Check if the 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing record from the database
    $sql = "SELECT * FROM principle WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $info = $row['info'];
        $img = $row['img']; // existing image file path
    } else {
        echo "<script>alert('No record found for the given ID.'); window.location.href='view_principle.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID parameter missing.'); window.location.href='view_principle.php';</script>";
    exit;
}

// Handle the form submission for updating
if (isset($_POST['submit'])) {
    $updated_info = $_POST['info'];
    $updated_img = $img; // Retain the existing image if no new file is uploaded

    // Check if the file is uploaded and handle the image
    if ($_FILES['img']['error'] === 0) {
        $file_name = $_FILES['img']['name'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $file_size = $_FILES['img']['size'];
        $file_error = $_FILES['img']['error'];

        // Define the target directory for the file upload
        $target_dir = "uploads/";  // Folder to store uploaded files
        $target_file = $target_dir . basename($file_name);

        // Check file size (e.g., max 5MB allowed)
        if ($file_size <= 5000000) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                $updated_img = $target_file; // Update the image path in the database
            } else {
                echo "<script>alert('Error uploading the file.');</script>";
            }
        } else {
            echo "<script>alert('File size is too large. Max 5MB allowed.');</script>";
        }
    }

    // Update query
    $update_sql = "UPDATE principle SET info = '$updated_info', img = '$updated_img' WHERE id = $id";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='viewdata_principle.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Principle Data</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 60%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

       

        label {
            font-size: 1.1rem;
            color: #333;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #49a0e3;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #3c8db1;
        }

        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Update Principle Data</h2>

        <form action="update_principle.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <label for="info">Info</label>
            <input type="text" id="info" name="info" value="<?php echo $info; ?>" required>

            <label for="img">Image</label>
            <input type="file" id="img" name="img">

            <button type="submit" name="submit">Update</button>
        </form>

        <a href="viewdata_principle.php" class="back-button">Back to List</a>
    </div>

</body>
</html>
