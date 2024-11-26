<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Check if ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch class details based on ID
    $sql = "SELECT * FROM classes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $class_name = $row['class_name'];
    } else {
        echo "Class not found.";
        exit;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_name = $_POST['class_name'];

    // Update class details in the database
    $update_sql = "UPDATE classes SET class_name = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $class_name, $id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Class updated successfully!'); window.location.href='manage_classes.php';</script>";
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
    <title>Update Class</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your external stylesheet -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* padding: 20px; */
            /* margin-left: 1px; */
        }

        .form-container {
            /* background: #fff; */
            padding: 100px;
            border-radius: 8px;
            /* max-width: 400px; */
            margin: auto;
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
            padding-top: 90px;
        }

        .form-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Update Class</h2>
        <form method="POST">
            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class_name); ?>" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>

</html>
