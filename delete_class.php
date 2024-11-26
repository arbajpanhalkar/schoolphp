<?php
// Include database connection
include('connection.php');

// Check if ID is passed in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE SQL statement
    $sql = "DELETE FROM classes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Class deleted successfully!'); window.location.href='manage_classes.php';</script>";
    } else {
        echo "<script>alert('Error deleting class: " . $conn->error . "'); window.location.href='manage_classes.php';</script>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='manage_classes.php';</script>";
}

// Close the database connection
$conn->close();
?>
