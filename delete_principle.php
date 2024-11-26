<?php
include('connection.php'); // Database connection file

// Debugging: Check if ID is passed
if (!isset($_GET['id'])) {
    echo "<script>alert('ID parameter missing.'); window.location.href='view_principle.php';</script>";
    exit;
}

$id = $_GET['id']; // Get the ID from the URL

// Ensure that the ID is an integer
if (!is_numeric($id)) {
    echo "<script>alert('Invalid ID.'); window.location.href='view_principle.php';</script>";
    exit;
}

// Get the image file path to delete
$sql = "SELECT img FROM principle WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $file_path = $row['img'];

    // Delete the file from the server
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Delete the record from the database
    $delete_sql = "DELETE FROM principle WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Record deleted successfully.'); window.location.href='view_principle.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "'); window.location.href='viewdata_principle.php';</script>";
    }
} else {
    echo "<script>alert('No record found for the given ID.'); window.location.href='viewdata_principle.php';</script>";
}
?>
