<?php
include('connection.php');
include('sidebar.php');

// Fetch classes
$classResult = $conn->query("SELECT * FROM classes");
if (!$classResult) {
    die("Error fetching classes: " . $conn->error);
}

// Debugging: Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);

    // Check for empty fields
    if (empty($firstname) || empty($lastname) || empty($age) || empty($email) || empty($password) || empty($class_id)) {
        echo "<div class='alert alert-danger mt-3'>All fields are required.</div>";
    } else {
        // Check for duplicate email
        $emailCheckQuery = "SELECT * FROM students WHERE email = ?";
        $stmt = $conn->prepare($emailCheckQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $emailCheckResult = $stmt->get_result();

        if ($emailCheckResult->num_rows > 0) {
            echo "<div class='alert alert-danger mt-3'>Email already registered.</div>";
        } else {
            // Handle file upload
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    echo "<div class='alert alert-danger mt-3'>Only JPG, JPEG, and PNG files are allowed.</div>";
                } elseif ($_FILES['image']['size'] > 5000000) {
                    echo "<div class='alert alert-danger mt-3'>File size exceeds 5MB.</div>";
                } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Insert student into the database
                    $query = "INSERT INTO students (firstname, lastname, age, email, password, class_id, img) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ssissis", $firstname, $lastname, $age, $email, $password, $class_id, $uploadFile);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success mt-3'>Student added successfully!</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Database error: " . $stmt->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-3'>File upload error.</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3'>Please upload an image.</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <style>/* General Body Styling */
body {
    font-family: Arial, sans-serif;
    /* background-color: #f4f6f9; */
    margin: 0;
    padding: 0;
    color: #333;
}

/* Content Container */
.content {
    width: 60%;
    margin: 50px auto;
    /* background-color: #fff; */
    border-radius: 10px;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
    padding: 20px 30px;
    box-sizing: border-box;
}

/* Heading Styling */
.content h1 {
    font-size: 1.8rem;
    color: black;
    text-align: left;
    margin-bottom: 20px;
}

/* Form Styling */
form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

form input,
form select,
form button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 1rem;
}

/* Input Focus Effect */
form input:focus,
form select:focus {
    border-color: #49a0e3;
    outline: none;
    box-shadow: 0 0 5px rgba(73, 160, 227, 0.5);
}

/* Button Styling */
form button {
    background-color: #49a0e3;
    color: #fff;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #347ab6;
}

/* Alerts */
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        width: 90%;
    }

    form input,
    form select,
    form button {
        font-size: 0.9rem;
    }
}
</style>
</head>
<body>
    <div class="content">
        <h1>Add Student</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" required>
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" required>
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="class_id">Class:</label>
            <select name="class_id" id="class_id" required>
                <option value="">Select Class</option>
                <?php while ($row = $classResult->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['class_name']}</option>";
                } ?>
            </select>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" required>
            <button type="submit">Add Student</button>
        </form>
    </div>
</body>
</html>
