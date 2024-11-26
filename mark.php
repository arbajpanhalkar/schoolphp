<?php
include('connection.php');

// Handle form submission to insert marks
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_marks'])) {
    $userId = $_POST['user_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    $sql = "INSERT INTO marks (user_id, subject, marks) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $userId, $subject, $marks);

    if ($stmt->execute()) {
        echo "<script>alert('Marks added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding marks.');</script>";
    }
}

// Fetch all users
$userQuery = "SELECT * FROM users";
$userResult = $conn->query($userQuery);

// Fetch marks for selected user
$selectedUserId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$marksResult = null;
if ($selectedUserId) {
    $marksQuery = "SELECT * FROM marks WHERE user_id = ?";
    $stmt = $conn->prepare($marksQuery);
    $stmt->bind_param("i", $selectedUserId);
    $stmt->execute();
    $marksResult = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Mark List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container input, .form-container select, .form-container button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>

<body>

<h1>Exam Mark List Management</h1>

<!-- Form to Insert Marks -->
<div class="form-container">
    <form method="POST">
        <label for="user_id">Select User:</label>
        <select name="user_id" id="user_id" required>
            <option value="">Select User</option>
            <?php
            if ($userResult->num_rows > 0) {
                while ($user = $userResult->fetch_assoc()) {
                    echo "<option value='" . $user['id'] . "'>" . $user['email'] . "</option>";
                }
            }
            ?>
        </select>
        <br>
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" placeholder="Enter Subject" required>
        <br>
        <label for="marks">Marks:</label>
        <input type="number" name="marks" id="marks" placeholder="Enter Marks" required>
        <br>
        <button type="submit" name="insert_marks">Insert Marks</button>
    </form>
</div>

<!-- Display Marks for Selected User -->
<div class="form-container">
    <form method="GET">
        <label for="select_user">Select User to View Marks:</label>
        <select name="user_id" id="select_user" required>
            <option value="">Select User</option>
            <?php
            $userResult->data_seek(0); // Reset pointer to the beginning
            while ($user = $userResult->fetch_assoc()) {
                $selected = ($selectedUserId == $user['id']) ? "selected" : "";
                echo "<option value='" . $user['id'] . "' $selected>" . $user['email'] . "</option>";
            }
            ?>
        </select>
        <button type="submit">View Marks</button>
    </form>
</div>

<?php if ($marksResult && $marksResult->num_rows > 0): ?>
    <h2>Mark List for User</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Marks</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($mark = $marksResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $mark['id']; ?></td>
                <td><?php echo $mark['subject']; ?></td>
                <td><?php echo $mark['marks']; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No marks found for the selected user.</p>
<?php endif; ?>

</body>
</html>
