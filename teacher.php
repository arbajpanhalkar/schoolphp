<?php
include 'connection.php';
include 'header.php'; // Include the header at the top of the page

if (isset($_POST['register'])) {
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $class_id = $_POST["class_id"];

    // Handle file upload
    $uploadDir = 'uploads/'; // Directory to save uploaded files
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        $imagePath = "";

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Save the uploaded file path
        } else {
            echo "<div class='alert alert-danger text-center'>Failed to upload the image. Please try again.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger text-center'>No image uploaded or an error occurred.</div>";
        exit;
    }

    // Check if email already exists
    $checkQuery = "SELECT * FROM teachers WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<div class='alert alert-danger text-center'>Email already exists. Please use a different email.</div>";
    } else {
        // Insert teacher data into the teachers table
        $query = "INSERT INTO teachers (firstname, lastname, email, password, class_id, file) 
                  VALUES ('$firstname', '$lastname', '$email', '$password', '$class_id', '$imagePath')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<div class='alert alert-success text-center'>Teacher registered successfully!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error: " . mysqli_error($conn) . "</div>";
        }
    }

    mysqli_close($conn); // Close the connection after processing the form
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .maindiv {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        h2 {
            color: #333;
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
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="maindiv">
            <h2 class="text-center">Register Teacher</h2>
            <form action="teacher.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="class" class="form-label">Class:</label>
                    <select name="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        <?php
                        // Re-open connection to fetch classes for dropdown
                        include 'connection.php';
                        $classQuery = "SELECT * FROM classes";
                        $classResult = mysqli_query($conn, $classQuery);

                        if (mysqli_num_rows($classResult) > 0) {
                            while ($classRow = mysqli_fetch_assoc($classResult)) {
                                echo "<option value='" . $classRow['id'] . "'>" . htmlspecialchars($classRow['class_name']) . "</option>";
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
                    <input type="file" class="form-control" name="image" id="image" required>
                </div>

                <button type="submit" name="register" class="btn-register">Register</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php 
include('footer.php');
?>

