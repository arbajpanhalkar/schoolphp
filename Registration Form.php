<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Adding an image at the top -->
                        <div class="text-center mb-4">
                            <img src="uploads/dyp_logo.jpeg" alt="Logo" class="img-fluid rounded-circle">
                        </div>

                        <h2 class="text-center mb-4">Registration Form</h2>
                        <form action="registration.php" method="post" enctype="multipart/form-data">
                            <!-- 10 form fields -->
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required placeholder="Enter your first name">
                            </div>

                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Enter your last name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number:</label>
                                <input type="text" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" required placeholder="Enter your address">
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">City:</label>
                                <input type="text" class="form-control" id="city" name="city" required placeholder="Enter your city">
                            </div>

                            <div class="mb-3">
                                <label for="state" class="form-label">State:</label>
                                <input type="text" class="form-control" id="state" name="state" required placeholder="Enter your state">
                            </div>

                            <div class="mb-3">
                                <label for="zipcode" class="form-label">Zip Code:</label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode" required placeholder="Enter your zip code">
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country:</label>
                                <input type="text" class="form-control" id="country" name="country" required placeholder="Enter your country">
                            </div>

                            <!-- File upload field -->
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File:</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Include database connection
require_once 'connection.php'; // Assume this file contains the connection to MySQL

if (isset($_POST["submit"])) {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $country = $_POST['country'];

    // File upload handling
    $file_name = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        // Move the uploaded file to the server
        if (!move_uploaded_file($file_tmp_name, $upload_dir . $file_name)) {
            $file_name = ''; // Reset if file failed to upload
        }
    }

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO registrations (firstname, lastname, email, password, phone, address, city, state, zipcode, country, file) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    $stmt->bind_param("sssssssssss", $firstname, $lastname, $email, $hashed_password, $phone, $address, $city, $state, $zipcode, $country, $file_name);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
