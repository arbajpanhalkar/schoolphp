<?php 
include('connection.php');
include('sidebar.php');

// Fetch the list of classes for the filter dropdown
$class_sql = "SELECT id, class_name FROM classes";
$class_result = $conn->query($class_sql);

// Get the class filter value from the request (if any)
$class_filter = isset($_GET['class_id']) ? $_GET['class_id'] : '';

// Build the SQL query with optional class filter
$sql = "
    SELECT teachers.id, teachers.firstname, teachers.lastname, teachers.email, teachers.password, teachers.file, classes.class_name
    FROM teachers
    LEFT JOIN classes ON teachers.class_id = classes.id
";

// Apply the class filter if selected
if ($class_filter) {
    $sql .= " WHERE teachers.class_id = " . (int)$class_filter;
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Teachers - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
   

/* Style for the filter form */
.filter-form {
    margin-bottom: 20px;
}

.filter-form label {
    font-weight: bold;
}

.filter-form select {
    padding: 8px;
    font-size: 1rem;
    margin-right: 10px;
}

.filter-form button {
    padding: 8px 16px;
    font-size: 1rem;
    background-color: #49a0e3;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.filter-form button:hover {
    background-color: #3b8eb5;
}
.content {
            flex-grow: 1;
            padding: 20px;
            margin-left: 250px;
        }

        .content h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: #fff;
            font-size: 0.9rem;
        }

        .btn-success {
            background-color: #333;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-success:hover, .btn-danger:hover {
            opacity: 0.8;
        }
        .add-class-btn {
        background-color: #007bff; /* Blue color */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        display: inline-block; /* Inline display */
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .add-class-btn:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-2px); /* Slight lift on hover */
    }

    .add-class-btn:active {
        background-color: #004085; /* Even darker blue when clicked */
        transform: translateY(0); /* Reset lift on click */
    }</style>
</head>
<body>

<div class="content">
    <h1>Manage Teachers</h1>

    <!-- Filter Form -->
    <form class="filter-form" method="GET" action="">
        <label for="class_id">Filter by Class:</label>
        <select name="class_id" id="class_id">
            <option value="">All Classes</option>
            <?php
            if ($class_result->num_rows > 0) {
                while ($class_row = $class_result->fetch_assoc()) {
                    $selected = ($class_filter == $class_row['id']) ? 'selected' : '';
                    echo "<option value='" . $class_row['id'] . "' $selected>" . $class_row['class_name'] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Teacher Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Actions</th>
                <th>Class</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td><a href='update_teacher.php?id=" . $row['id'] . "'>Update</a> | <a href='delete_teacher.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete</a></td>";
                    echo "<td>" . $row['class_name'] . "</td>";
                    if (!empty($row['file'])) {
                        // Get the file path and extension
                        $file_path = $row['file'];
                        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                
                        // Check if the file is an image (you can check for specific file types like jpg, jpeg, png, etc.)
                        if (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                            // Display the image
                            echo "<td><img src='" . $file_path . "' alt='Teacher Image' style='max-width: 100px; height: auto;'></td>";
                        } else {
                            // If it's not an image, provide a link to the file
                            echo "<td><a href='" . $file_path . "' target='_blank'>View File</a></td>";
                        }
                    } else {
                        echo "<td>No File</td>";
                    }
                }
            } else {
                echo "<tr><td colspan='8'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
