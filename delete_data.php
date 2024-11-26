<?php
include('connection.php');

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input to ensure it's a valid integer

    // Prepare and execute the DELETE query
    $deleteQuery = "DELETE FROM contact_form WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Successful deletion
        echo "<script>
            alert('Record deleted successfully!');
            window.location.href='contactdata.php'; // Redirect to the main page
        </script>";
    } else {
        // Error during deletion
        echo "<script>
            alert('Failed to delete record. Please try again.');
            window.location.href='contactdata.php'; // Redirect to the main page
        </script>";
    }
    $stmt->close();
} else {
    // Invalid request handling
    echo "<script>
        alert('Invalid request.');
        window.location.href='your_file_name.php'; // Redirect to the main page
    </script>";
}

$conn->close(); // Close the database connection
?>
