<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $class_code = mysqli_real_escape_string($conn, $_POST['class_code']);
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);

    // Ensure class_code is not empty
    if (empty($class_code)) {
        echo "Class code is required.";
    } else {
        // Insert the new class into the database
        $sql = "INSERT INTO classes (class_code, class_name)
                VALUES ('$class_code', '$class_name')";

        if ($conn->query($sql) === TRUE) {
            // echo "New class added successfully.";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS for styling -->
    <style>
        
/* Main content styling */
.content {
    flex-grow: 1; /* Allows content to take remaining space */
    padding: 20px;
    /* margin-left: 250px; To avoid overlap with the sidebar */
}

.content h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}


/* Form styling */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 500px;
    margin: 0 auto;
}

form label {
    font-size: 1rem;
    color: #333;
}

form input,
form select {
    padding: 10px;
    font-size: 1rem;
    border-radius: 5px;
    border: 1px solid #ccc;
}

form input[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}

footer {
    text-align: center;
    padding: 10px;
    background-color: #333;
    color: white;
    margin-top: 20px;
}

    </style>
</head>

<body>

    

        <!-- Main content -->
        <div class="content">
            <h1>Add New Class</h1>

            <!-- Class Form -->
            <form action="" method="post">
                <label for="class_code">Class Code:</label>
                <input type="text" id="class_code" name="class_code" required>

                <label for="class_name">Class Name:</label>
                <input type="text" id="class_name" name="class_name" required>

                <input type="submit" value="Add Class">
            </form>
        </div>
    </div>

</body>

</html>
