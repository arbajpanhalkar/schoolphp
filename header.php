<?php
include('connection.php'); // Include your database connection

// Query to fetch the logo and website name
$sql = "SELECT logo, name FROM sitesetting LIMIT 1";
$result = $conn->query($sql);

$logo = "img/default-logo.png"; // Default logo if no data found
$website_name = "Default Name"; // Default name if no data found

if ($result->num_rows > 0) {
    // Fetch the first row
    $row = $result->fetch_assoc();
    $logo = $row['logo'];
    $website_name = $row['name'];
}

// Close the database connection
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="path/to/font-awesome/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.
    <link rel="stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMptUURQo/2TW+f6yS+En6T3t51dFEp9yKAB7BZ" crossorigin="anonymous">
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        /* Header Styling */
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: antiquewhite;
            padding: 10px 20px;
            /* margin-top: 1px; */
        }

        .logo {
            width: 80px;
            height: auto;
            margin-right: 10px;
        }

        /* Styled H1 Text */
        h1 {
            font-size: 2.5rem; 
            font-weight: bold;
            color: #004080;
            margin: 0;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            font-family: Arial, sans-serif; 
        }

        /* Contact Info Styling */
        .contact-info {
            display: flex;
            gap: 15px;
            font-size: 0.9rem;
            align-items: center;
            margin-left: px;
        }

        .contact-info span {
            display: flex;
            align-items: center;
        }

        .contact-info i {
            margin-right: 5px;
        }

        /* Navigation Menu */
        nav {
            background-color: #6eace9;
            padding: 10px 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: inline-flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #004080;
        }
         /* Admin Login Styling */
         .admin-login {
            display: flex;
            align-items:right;
            gap: 10px;
            background-color: #004080;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            margin-left: 750px;
        }

        .admin-login:hover {
            background-color: #003366;
        }

        .admin-login i {
            margin-right: 8px;
        }
        /* Responsive Design for Smaller Screens */
@media screen and (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: center;
    }

    .logo {
        width: 60px; /* Resize logo on smaller screens */
    }

    h1 {
        font-size: 2rem; /* Reduce heading size on small screens */
    }

    .contact-info {
        margin-top: 10px;
        justify-content: center;
    }

    nav ul {
        flex-direction: column; /* Stack navigation items vertically on small screens */
    }

    nav ul li {
        margin: 10px 0;
    }

    nav ul li a {
        font-size: 1rem;
        padding: 8px 12px;
    }

    .admin-login {
        margin-left: 0;
        margin-top: 15px;
        justify-content: center;
        width: auto;
    }
}

/* Additional Styling for Very Small Screens (e.g., mobile devices) */
@media screen and (max-width: 480px) {
    h1 {
        font-size: 1.5rem; /* Further reduce font size on very small screens */
    }

    .contact-info {
        font-size: 0.8rem; /* Make the contact info smaller */
    }

    .admin-login {
        font-size: 1rem;
        padding: 8px 10px;
    }
}
        

        
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header-content">
        <!-- Logo and Title -->
        <div style="display: flex; align-items: center;">
    <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo" class="logo">
    <h1><?php echo htmlspecialchars($website_name); ?></h1>
</div>

        <!-- Contact Info -->
        <!-- <div class="contact-info" >
            <span><i class="fas fa-envelope"></i> school@example.com</span>
            <span><i class="fas fa-phone"></i> +123 456 7890</span>
        </div> -->
        <a href="adminlogin.php" class="admin-login"><i class="fas fa-user-shield"> Admin Login</a></li>
    </div>

    <!-- Navigation Menu -->
   <!-- Navigation Menu -->
   <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="contact_form.php">Contact Us</a></li>
        <li><a href="showresult.php">View Result</a></li>
        <!-- Dropdown Menu for Apply Form -->
      
            
                <li><a href="teacher.php">Teacher Form</a></li>
                <li><a  href="index1.php">Student Form</a></li>
            </ul>
        </li>
    </ul>
</nav>

<!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
</body>

</html>

