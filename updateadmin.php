<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the student's data from the database
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $result = $conn->query($sql);

    // If student exists, fetch data
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger text-center' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 1000;'>Student not found.</div>";
        exit;
    }
}

// Handle form submission to update student data
if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $class_id = $_POST['class_id'];
    $imagePath = $student['img']; // Retain the existing image by default

    // Check if a new image is uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if not exists
        }
        $uploadFile = $uploadDir . basename($_FILES['img']['name']);
        if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Update the image path with the new file
        } else {
            echo "<div class='alert alert-danger text-center'>Failed to upload the image. Please try again.</div>";
            exit;
        }
    }

    // Update the student record in the database
    $update_sql = "UPDATE students 
                   SET firstname = '$firstname', lastname = '$lastname', age = $age, email = '$email', 
                       password = '$password', class_id = $class_id, img = '$imagePath'
                   WHERE id = $student_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>Record updated successfully!</div>";
        header("Location: manage_students.php"); // Redirect back to the manage students page
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f0f2f5;
            flex-direction: row;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px;
            /* Adjust this based on your sidebar width */
        }

        .content h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        input[type="file"] {
            padding: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        button:active {
            background-color: #004085;
            transform: translateY(0);
        }

        p {
            margin-top: 10px;
            color: #333;
        }

        img {
            border-radius: 5px;
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="content">
        <h1>Update Student Information</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo $student['firstname']; ?>" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo $student['lastname']; ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $student['age']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $student['password']; ?>" required>

            <label for="class_id">Class:</label>
            <select id="class_id" name="class_id" required>
                <?php
                // Fetch classes from the database
                $class_sql = "SELECT * FROM classes";
                $class_result = $conn->query($class_sql);
                while ($class = $class_result->fetch_assoc()) {
                    echo "<option value='" . $class['id'] . "'" . ($class['id'] == $student['class_id'] ? ' selected' : '') . ">" . $class['class_name'] . "</option>";
                }
                ?>
            </select>

            <label for="img">Image:</label>
            <input type="file" id="img" name="img" accept="image/*">
            <p>Current Image: <img src="<?php echo $student['img']; ?>" alt="Student Image" width="100"></p>

            <button type="submit" name="update" class="add-class-btn">Update Student</button>
        </form>
    </div>
</body>

</html>