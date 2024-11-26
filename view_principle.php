<?php
include('connection.php'); // Database connection file
include('sidebar.php'); // Include sidebar for navigation

$message = ""; // Initialize message variable

// Handle form submission
if (isset($_POST['submit'])) {
    // Get form data
    $info = $_POST['info'];
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];

    // Check if file upload is successful
    if ($file_error === 0) {
        // Define the target directory for the file upload
        $target_dir = "uploads/";  // Folder to store uploaded files
        $target_file = $target_dir . basename($file_name);

        // Check file size (e.g., max 5MB allowed)
        if ($file_size <= 5000000) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                // Insert data into the database
                $sql = "INSERT INTO principle (info, img) VALUES ('$info', '$target_file')";

                if ($conn->query($sql) === TRUE) {
                    $message = "<p style='color: green; text-align:center;'>Data and file uploaded successfully.</p>";
                } else {
                    $message = "<p style='color: red; text-align:center;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
            } else {
                $message = "<p style='color: red; text-align:center;'>Error uploading the file.</p>";
            }
        } else {
            $message = "<p style='color: red; text-align:center;'>File size is too large. Max 5MB allowed.</p>";
        }
    } else {
        $message = "<p style='color: red; text-align:center;'>Error uploading the file.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Upload Info and File</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

       

        /* Form container styles */
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; /* Limit form width */
            text-align: center;
            margin-left: 250px; /* Space for sidebar */
            margin-top: 50px;
            margin-left: 400px;
            height: 600px;
        }

        /* Heading styling */
        
        /* Textarea and Input fields styling */
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        /* Textarea specific style */
        textarea {
            height: 150px; /* Adjust the height as needed */
            resize: vertical; /* Allows the user to resize vertically */
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #49a0e3;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            width: 100%;
        }

        /* Hover effect for the submit button */
        input[type="submit"]:hover {
            background-color: #3c8db1;
        }

        /* Placeholder text style */
        ::placeholder {
            color: #aaa;
        }
    </style>
</head>
<body>

    <!-- Admin Panel Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Admin Panel - Upload Info</h2>
        
        <!-- Display Message -->
        <?php if ($message != "") echo $message; ?>

        <textarea name="info" placeholder="Enter information here" required></textarea><br><br>
        <input type="file" name="file" required><br><br>
        <input type="submit" name="submit" value="Upload">
    </form>

</body>
</html>
