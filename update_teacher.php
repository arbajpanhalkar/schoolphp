<?php
include 'connection.php';
include 'sidebar.php'; // Include the header at the top of the page

if (isset($_GET['id'])) {
    $teacherId = $_GET['id'];

    // Fetch the existing teacher data
    $query = "SELECT * FROM teachers WHERE id='$teacherId'";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);

  
    if (!$teacher) {
        echo "<div class='alert alert-danger text-center' style='position: absolute; top: 0; left: 0; width: 100%; z-index: 1000;'>Teacher not found.</div>";
        exit;
    }
    
}

// Handle the update form submission
if (isset($_POST['update'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $class_id = $_POST["class_id"];
    $imagePath = $teacher['file']; // Default to the existing file path

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Update with new file path
        } else {
            echo "< text-center'>Failed to upload the image. Please try again.</div>";
            exit;
        }
    }

    // Update the teacher data in the database
    $updateQuery = "UPDATE teachers SET 
        firstname='$firstname', 
        lastname='$lastname', 
        email='$email', 
        password='$password', 
        class_id='$class_id', 
        file='$imagePath' 
        WHERE id='$teacherId'";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        
        echo "<div class='alert alert-success text-center' style='position: absolute; top: 10; left: 0; width: 50%; z-index: 500;margin-left: 500px; margin-top: auto' >Teacher updated successfully!</div>";
        header('location:manage_teacher.php');
    
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
    }

    mysqli_close($conn); // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f4f4f4; */
        }

        .maindiv {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
            max-width: 600px;
            margin: 40px auto;
        }

        h2 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .btn-register {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            border: none;
            font-weight: bold;
        }

        .btn-register:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .alert {
            margin-top:100px;
            margin-left: px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="maindiv">
        <h2 class="text-center" style="color:black;">Update Teacher</h2>

            <form action="update_teacher.php?id=<?php echo $teacherId; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($teacher['firstname']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($teacher['lastname']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($teacher['password']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="class" class="form-label">Class:</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        <?php
                        // Fetch classes for dropdown
                        include 'connection.php';
                        $classQuery = "SELECT * FROM classes";
                        $classResult = mysqli_query($conn, $classQuery);

                        if (mysqli_num_rows($classResult) > 0) {
                            while ($classRow = mysqli_fetch_assoc($classResult)) {
                                $selected = $classRow['id'] == $teacher['class_id'] ? 'selected' : '';
                                echo "<option value='" . $classRow['id'] . "' $selected>" . htmlspecialchars($classRow['class_name']) . "</option>";
                            }
                        } else {
                            echo "<option disabled>No classes available</option>";
                        }

                        mysqli_close($conn); // Close connection after fetching classes
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Choose an image:</label>
                    <input type="file" class="form-control" name="image" id="image">
                    <p>Current Image: <a href="<?php echo $teacher['file']; ?>" target="_blank">View</a></p>
                </div>

                <button type="submit" name="update" class="btn-register">Update</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
