<?php 
include('connection.php');
include('header.php');?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        @media (min-width: 768px) {
            .form-group-inline {
                display: flex;
                gap: 20px;
            }
            .form-group-inline .form-control {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Contact Us</h2>
        <form action="" method="POST" class="form-container">
            <div class="form-group">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="message" class="form-label">Message:</label>
                <textarea class="form-control" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary align-self-center">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
//include 'connection.php'; // Include database connection file

if (isset($_POST['submit'])) {
    // Get form data and sanitize
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM contact_form WHERE email = '$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo "<p style='color: red; text-align: center;'>You have already submitted the form with this email.</p>";
    } else {
        // Insert the contact form data into the database
        $query = "INSERT INTO contact_form (fullname, email, message) 
                  VALUES ('$fullname', '$email', '$message')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<p style='color: green; text-align: center;'>Thank you for contacting us! We will get back to you soon.</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<br><br>
<?php 
include('footer.php');
?>
