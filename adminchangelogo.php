<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $siteName = mysqli_real_escape_string($conn, $_POST['site_name']);
    $logoUrl = $_FILES['logo']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($logoUrl);

    // Move the uploaded logo file to the target directory
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
        // Insert or update the site settings in the database
        $sql = "UPDATE site_settings SET site_name='$siteName', logo_url='$targetFile' WHERE id=1";
        if ($conn->query($sql) === TRUE) {
            echo "Settings updated successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading the logo.";
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="site_name">Site Name:</label>
    <input type="text" name="site_name" required>
    
    <label for="logo">Logo:</label>
    <input type="file" name="logo" required>

    <input type="submit" value="Update Settings">
</form>



<?php
// Make sure your connection is established properly

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the values from the form
    $siteName = $_POST['site_name'];
    $logoUrl = $_POST['uploads/logo_url'];

    // Check if the form data is not empty
    if (!empty($siteName) && !empty($logoUrl)) {
        // Update the database
        $sql = "UPDATE site_settings SET site_name = ?, logo_url = ? WHERE id = 1";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param("ss", $siteName, $logoUrl);

            // Execute the query
            if ($stmt->execute()) {
                echo "Settings updated successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the SQL statement.";
        }
    } else {
        echo "All fields are required!";
    }
}

// Close the database connection
$conn->close();
?>
