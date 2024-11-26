<?php
include 'connection.php';
include 'header.php';  // Include the header file

// Fetch classes for the dropdown
$classQuery = "SELECT id, class_name FROM classes";
$classResult = mysqli_query($conn, $classQuery);

if (!$classResult) {
    die('Error fetching classes: ' . mysqli_error($conn)); // Debugging database query for classes
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure the body takes up the full screen height */
        body, html {
            height: 100%;
            margin: 0;
        }

        /* Ensure container takes full height and centers the content */
        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        /* Center the form inside the card */
        .card {
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Form button styling */
        .btn-primary {
            background-color: #0056b3;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #003f7f;
        }
        /* Responsive Design */
@media (max-width: 768px) {
    .container {
        margin-top: 20px;
    }

    .card {
        padding: 15px;
    }

    .card h2 {
        font-size: 1.5rem;
    }

    .btn-primary {
        font-size: 1rem;
        padding: 8px 16px;
    }
}
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Registration Form</h2>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>

                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class:</label>
                                <select id="class_id" name="class_id" class="form-select" required>
                                    <option value="">Select Class</option>
                                    <?php while ($row = mysqli_fetch_assoc($classResult)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['class_name'] . "</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Choose an image:</label>
                                <input type="file" name="image" id="image" required>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
                        </form>

                        <?php
                        if (isset($_POST["submit"])) {
                            $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
                            $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
                            $age = mysqli_real_escape_string($conn, $_POST["age"]);
                            $email = mysqli_real_escape_string($conn, $_POST["email"]);
                            $password = mysqli_real_escape_string($conn, $_POST["password"]);
                            $class_id = mysqli_real_escape_string($conn, $_POST["class_id"]);

                            // Ensure fields are not empty
                            if (empty($firstname) || empty($lastname) || empty($age) || empty($email) || empty($password) || empty($class_id)) {
                                echo "<div class='alert alert-danger mt-3'>All fields are required.</div>";
                            } else {
                                // Check if email already exists
                                $emailCheckQuery = "SELECT * FROM students WHERE email = '$email'";
                                $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

                                if (mysqli_num_rows($emailCheckResult) > 0) {
                                    echo "<div class='alert alert-danger mt-3'>The email address is already registered. Please use a different email.</div>";
                                } else {
                                    // Handle file upload
                                    $uploadDir = 'uploads/';
                                    $uploadFile = $uploadDir . basename($_FILES['image']['name']);
                                    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

                                    // Check if file is an image
                                    if (getimagesize($_FILES['image']['tmp_name']) === false) {
                                        echo "<div class='alert alert-danger mt-3'>File is not an image.</div>";
                                    } else {
                                        // Allow certain file formats
                                        if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png') {
                                            echo "<div class='alert alert-danger mt-3'>Only JPG, JPEG, and PNG files are allowed.</div>";
                                        } else {
                                            // Check file size (5MB)
                                            if ($_FILES['image']['size'] > 5000000) {
                                                echo "<div class='alert alert-danger mt-3'>Sorry, your file is too large.</div>";
                                            } else {
                                                // Upload the file
                                                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                                                    $imgPath = $uploadFile;

                                                    // Insert query (no password hashing)
                                                    $query = "INSERT INTO students (firstname, lastname, age, email, password, class_id, img) VALUES ('$firstname', '$lastname', '$age', '$email', '$password', '$class_id', '$imgPath')";
                                                    $result = mysqli_query($conn, $query);

                                                    if ($result) {
                                                        echo "<div class='alert alert-success mt-3'>Student registered successfully!</div>";
                                                    } else {
                                                        echo "<div class='alert alert-danger mt-3'>Error in registration. Please try again.</div>";
                                                        // Debugging: show SQL error
                                                        echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
                                                    }
                                                } else {
                                                    echo "<div class='alert alert-danger mt-3'>Sorry, there was an error uploading your file.</div>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<div>
<?php 
include('footer.php');
?>
</div>
