<?php
include 'connection.php';
include 'sidebar.php'; // Include the sidebar or any required elements

if (isset($_GET['id'])) {
    $teacherId = $_GET['id'];

    // Delete teacher from the database
    $deleteQuery = "DELETE FROM teachers WHERE id='$teacherId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<div class='alert alert-success text-center'>Teacher deleted successfully!</div>";
        header('location: manage_teacher.php'); // Redirect to the manage teachers page
    } else {
        echo "<div class='alert alert-danger text-center'>Error deleting teacher: " . mysqli_error($conn) . "</div>";
    }

    mysqli_close($conn); // Close the database connection
} else {
    echo "<div class='alert alert-danger text-center'>Teacher ID not provided.</div>";
}
?>
