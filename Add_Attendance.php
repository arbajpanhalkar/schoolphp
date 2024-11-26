<?php
include 'connection.php';

// Fetch students for the dropdown
$query = "SELECT id, firstname, lastname FROM students";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Student Attendance</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student</label>
                <select class="form-select" id="student_id" name="student_id" required>
                    <option value="" disabled selected>Select a student</option>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['firstname'] . ' ' . $row['lastname'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Attendance</button>
        </form>
    </div>
</body>
</html>

<?php 

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Check if attendance for this student on this date already exists
    $check_query = "SELECT * FROM attendance WHERE student_id = ? AND date = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("is", $student_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Attendance for this student on this date already exists.";
    } else {
        // Insert attendance
        $query = "INSERT INTO attendance (student_id, date, status, remarks) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $student_id, $date, $status, $remarks);

        if ($stmt->execute()) {
            echo "Attendance added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>


