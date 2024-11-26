<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Retrieve student data from the database
$sql = "
    SELECT students.id, students.firstname, students.lastname, students.age, students.email, students.password, students.img, classes.class_name
    FROM students
    LEFT JOIN classes ON students.class_id = classes.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f0f2f5;
            flex-direction: row;
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

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
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

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }

        .student-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin-right: 5px;
            text-align: center;
        }

        .btn-primary {
            background-color: #333;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .table td a {
            text-decoration: none;
        }

        .btn i {
            margin-right: 5px;
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
    }
    </style>
</head>

<body>

    <div class="content">
        <h1>Manage Students</h1>
     

        <a href="add_student.php">
           
            <button class="add-class-btn">Add Class</button>
        </a>

        <!-- Student Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Execute the query
                if ($result->num_rows > 0) {
                    // Output the student rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['firstname'] . "</td>";
                        echo "<td>" . $row['lastname'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['class_name'] . "</td>"; 
                        
                        // Display the image if it exists
                        if ($row['img']) {
                            echo "<td><img src='" . $row['img'] . "' alt='Student Image' class='student-img'></td>";
                        } else {
                            echo "<td>No Image</td>";
                        }

                        // Action buttons
                        echo "<td style='text-align: center;'>
                            <a href='updateadmin.php?id=" . $row['id'] . "' class='btn btn-primary'>
                                <i class='fas fa-edit'></i> Update
                            </a>
                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete?\");'>
                                <i class='fas fa-trash'></i> Delete
                            </a>
                        </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
