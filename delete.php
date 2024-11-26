<?php 
include 'connection.php';

if (isset($_GET['id'])) {
    $sid = $_GET['id'];  // Get the student ID from the URL

    // Delete query
    $query = "DELETE FROM students WHERE id='$sid'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        header("Location: manage_Students.php");  // Redirect to the view page after deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No ID provided for deletion.";
}

mysqli_close($conn);
?>
