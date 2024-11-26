<?php 
include 'connection.php';

// Get the student id from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the current details of the student to display in the form
    $query = "SELECT * FROM students WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Fetch classes for dropdown
        $classQuery = "SELECT * FROM classes";
        $classResult = mysqli_query($conn, $classQuery);
        
        // If the form is submitted
        if (isset($_POST['update'])) {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $age = $_POST["age"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $class_id = $_POST["class_id"];

            // Update query
            $query = "UPDATE students SET firstname='$firstname', lastname='$lastname', age='$age', email='$email', password='$password', class_id='$class_id' WHERE id='$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Redirect to view.php after successful update
                header("Location: manage_Students.php");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    } else {
        echo "No student found with that ID.";
    }
} else {
    echo "No ID provided.";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>   /* Styling for the update form */
.update-form {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.update-form label {
    display: block;
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: bold;
}

.update-form input,
.update-form select {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.update-form button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.update-form button:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>
    

<!-- HTML Form for updating student -->
<form action="update.php?id=<?php echo $id; ?>" method="POST" class="update-form">
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" required><br><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" required><br><br>
    
    <label for="age">Age:</label>
    <input type="number" name="age" value="<?php echo $row['age']; ?>" required><br><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" name="password" value="<?php echo $row['password']; ?>" required><br><br>
    
    <!-- Dropdown for class selection -->
    <label for="class">Class:</label>
    <select name="class_id" required>
        <?php
        while ($classRow = mysqli_fetch_assoc($classResult)) {
            echo "<option value='".$classRow['id']."' ".($row['class_id'] == $classRow['id'] ? 'selected' : '').">".$classRow['class_name']."</option>";
        }
        ?>
    </select><br><br>
    
    <button type="submit" name="update">Update</button>
</form>
</body>
</html>
