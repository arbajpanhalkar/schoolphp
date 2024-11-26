<?php
// Include database connection
include('connection.php');
include('sidebar.php');

// Retrieve class data from the database
$sql = "SELECT * FROM classes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS for styling -->
    <style>
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
    }
    </style>
</head>

<body>
    <div class="content">
        <h1>Manage Classes</h1>
        <a href="add_Class.php">
        <button class="add-class-btn">Add Class</button>
        </a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Class Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['class_name']}</td>
                            <td>
                                <a href='update_class.php?id={$row['id']}' class='btn btn-success btn'>Update</a>
                                <a href='delete_class.php?id={$row['id']}' class='btn btn-danger btn' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
