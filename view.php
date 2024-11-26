<?php 
include 'connection.php';
// include 'header.php';  // Include the header file (this will show your header content at the top)

// Check if the search term is set and filter the query
$search = isset($_POST['search']) ? $_POST['search'] : '';

// SQL Query to fetch students with class information
$query = "
    SELECT students.id, students.firstname, students.lastname, students.age, students.email, students.password, classes.class_name
    FROM students
    LEFT JOIN classes ON students.class_id = classes.id
    WHERE students.firstname LIKE '%$search%' 
    OR students.lastname LIKE '%$search%' 
    OR students.email LIKE '%$search%'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Table container */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin-top: 30px;
        }

        /* Table headers */
        th {
            background-color: #007bff;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 16px;
        }

        /* Table data cells */
        td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        /* Action links styling */
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin: 0 8px;
        }

        a:hover {
            color: #0056b3;
        }

        /* Hover effect for rows */
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Confirmation for delete */
        a[onclick] {
            cursor: pointer;
        }

        /* Table layout */
        .table-container {
            width: 80%;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Search bar styling */
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            padding: 8px;
            font-size: 16px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-container button {
            padding: 8px 12px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Search form -->
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by Firstname, Lastname or Email" value="<?php echo $search; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    
    <!-- Table container starts here -->
    <div class="table-container">
        <center>
            <table border='1' cellpadding='10' cellspacing='0'>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>firstname</th>
                        <th>lastname</th>
                        <th>age</th>
                        <th>email</th>
                        <th>password</th>
                        <th>action</th>
                        <th>class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['firstname']."</td>";
                            echo "<td>".$row['lastname']."</td>";
                            echo "<td>".$row['age']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['password']."</td>";
                            // echo "<td>
                            //         <a href='update.php?id=".$row['id']."'>Update</a> | 
                            //         <a href='delete.php?id=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete</a>
                            //       </td>";
                            echo "<td>".$row['class_name']."</td>"; // Display the class name
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </center>
    </div>

   
</body>
</html>
