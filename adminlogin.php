<?php
// Include database connection
include 'connection.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the POST request
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query the database for the admin
    $query = "SELECT * FROM adminlogin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user data
        $row = mysqli_fetch_assoc($result);

        // Verify the password (plain text comparison, but hashed passwords are recommended)
        if ($row['password'] == $password) {
            // If login is successful, start the session
            $_SESSION['admin'] = $row['username'];
        
            // Redirect to admin dashboard with absolute URL
            header('Location: admin_dashbord.php');
            exit;
        }
         else {
            // If the password is incorrect
            $error = "Invalid username or password.";
        }
    } else {
        // If the username does not exist
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            font-size: 14px;
            margin: 10px 0;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            font-size: 16px;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error messages -->
        <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

        <!-- Login Form -->
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Back to Index Page -->
        <a href="index.php" class="back-link">Back to Index Page</a>
       <!-- <button><a href="contact_form.php" >Back to Index Page</a></button>  -->
    </div>
</body>

</html>

