<?php
session_start();  // Start the session

// Check if the admin is logged in, otherwise redirect to login page
if (isset($_SESSION['id'])) {
    header("Location: adminlogin.php");  // Redirect to login page
     // header("Location: manage_Students.php");  // Redirect to login page
    
    exit;
}

// Fetch the data like total students, total classes, and total teachers (you already have this code)
include 'connection.php';  // Include your database connection

// // Fetch total students
// $total_students_query = "SELECT COUNT(*) AS total_students FROM students";
// $total_students_result = mysqli_query($conn, $total_students_query);
// $total_students = mysqli_fetch_assoc($total_students_result)['total_students'];

// // Fetch total classes
// $total_classes_query = "SELECT COUNT(*) AS total_classes FROM classes";
// $total_classes_result = mysqli_query($conn, $total_classes_query);
// $total_classes = mysqli_fetch_assoc($total_classes_result)['total_classes'];

// // Fetch total teachers
// $total_teacher_query = "SELECT COUNT(*) AS total_teachers FROM teachers";
// $total_teachers_result = mysqli_query($conn, $total_teacher_query);
// $total_teachers = mysqli_fetch_assoc($total_teachers_result)['total_teachers'];
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset and general styling */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    margin: 0;
    background-color: #f0f2f5;
    min-height: 100vh; /* Ensures the body always fills the viewport */
}

/* Sidebar styling */
.sidebar {
    width: 250px; /* Fixed width */
    /* height: 100vh; Full height of the viewport */
    background-color: #007bff;
    padding-top: 20px;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: fixed; /* Sidebar stays in place on scroll */
    overflow-y: auto; /* Allow scrolling if content overflows */
    padding-bottom: 50px;
}

.sidebar h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    text-align: center;
}

.sidebar a {
    color: white;
    padding: 10px 20px;
    margin: 10px 0;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    width: 100%;
    transition: background 0.3s;
}

.sidebar a:hover {
    background-color: #0056b3;
    cursor: pointer;
}

.sidebar i {
    font-size: 1.2rem;
}

/* Content styling to avoid overlap */
.content {
    margin-left: 250px; /* Matches the sidebar width */
    padding: 20px;
    width: calc(100% - 250px); /* Ensures content adapts to the remaining width */
}


       

       

       
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <h2>Admin Dashboard</h2>
    <a href="adminhome.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="manage_students.php"><i class="fas fa-user-graduate"></i> Manage Students</a>
    <a href="manage_classes.php"><i class="fas fa-school"></i> Manage Classes</a>
    <a href="add_student.php"><i class="fas fa-user-plus"></i> Add Student</a>
    <a href="add_class.php"><i class="fas fa-plus-square"></i> Add Class</a>
    <a href="manage_teacher.php"><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</a>
    <a href="contactdata.php"><i class="fas fa-address-book"></i> Contact Data</a>
    <a href="view_principle.php"><i class="fas fa-address-book"></i> Principle</a>
   
    <a href="viewdata_principle.php"><i class="fas fa-address-book"></i> Principle</a>

    <a href="adminmark.php"><i class="fas fa-clipboard-list"></i> Marks</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>


 
      

  

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
