<?php
include('connection.php'); // Database connection file
include('sidebar.php'); // Include sidebar for navigation

// Fetch data from the database
$sql = "SELECT * FROM principle";
$dataResult = $conn->query($sql);

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // SQL query to delete the record
    $delete_sql = "DELETE FROM principle WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        header('Location: view_principle.php'); // Redirect to refresh the page
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Principle Data</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .data-display {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-left: 300px; /* Assuming sidebar space */
            max-width: 1200px;
        }

     

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 1.1rem;
        }

        th {
            background-color: #49a0e3;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            margin-top: 20px;
        }

        .no-data {
            font-size: 1.2rem;
            color: #999;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: space-around;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 8px 12px;
            color: white;
            background-color: #49a0e3;
            border-radius: 5px;
            font-size: 1rem;
            margin: 5px;
        }

        .action-buttons a:hover {
            background-color: #3c8db1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .data-display {
                margin-left: 50px;
                margin-right: 50px;
            }

            table {
                font-size: 1rem;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="data-display">
        <h2>Uploaded Principle Data</h2>
        
        <div class="table-container">
            <?php
            if ($dataResult->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Info</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
                
                while ($row = $dataResult->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['info'] . "</td>
                        <td><img src='" . $row['img'] . "' alt='Image' style='width: 150px; height: auto;'></td>
                        <td class='action-buttons'>
                            <a href='update_principle.php?id=" . $row['id'] . "'>Update</a>
                            <a href='delete_principle.php?id=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
</td>
                    </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p class='no-data'>No data available.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>
