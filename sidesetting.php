<?php 
include('connection.php'); // Include your database connection
 include('sidebar.php'); // Include sidebar if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload and database save logic

    $website_name = $_POST['website_name']; // Get website name from form
    $upload_dir = "uploads/"; // Directory to store uploaded files
    $logo_path = ""; // Initialize the logo path variable

    // Check if a file is uploaded
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $file_name = basename($_FILES['logo']['name']);
        $target_file = $upload_dir . $file_name;

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
            $logo_path = $target_file; // Save file path for database
        } else {
            echo "Error uploading the file.";
        }
    }

    // Save data into the database
    if (!empty($website_name) && !empty($logo_path)) {
        $sql = "INSERT INTO sitesetting (logo, name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $logo_path, $website_name);

        if ($stmt->execute()) {
            echo "Data saved successfully.";
        } else {
            echo "Error saving data: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Please fill out all fields.";
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Website Settings</title>
    <style>/* General Form Styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    /* background-color: #f4f4f4; */
}

form {
    max-width: 500px;
    margin: 40px auto;
    /* background-color: #fff; */
    padding: 20px;
    border-radius: 8px;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
}

h1 {
    text-align: center;
    color: #2d133f;
    /* text-size:bold; */
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 1rem;
    color: #333;
}

input[type="file"],
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
}

input[type="file"] {
    padding: 12px 10px;
}

button {
    width: 100%;
    padding: 12px;
    background-color: blue;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* button:hover {
    /* background-color: #1b0e28; */


/* Responsive Design for Smaller Screens */
@media screen and (max-width: 768px) {
    form {
        padding: 15px;
    }

    input[type="file"],
    input[type="text"] {
        padding: 8px;
        font-size: 0.9rem;
    }

    button {
        padding: 10px;
        font-size: 1rem;
    }
}
</style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Logo:</label>
        <input type="file" name="logo" required>

        <label>Website Name:</label>
        <input type="text" name="website_name" required>

        <button type="submit">Save</button>
    </form>
</body>
</html>
