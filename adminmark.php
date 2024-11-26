<?php
include('connection.php');
include('sidebar.php');

// Handle form submission for adding marks
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_marks'])) {
    $studentId = $_POST['student_id'];
    $subject1 = $_POST['subject1_marks'];
    $subject2 = $_POST['subject2_marks'];
    $subject3 = $_POST['subject3_marks'];
    $subject4 = $_POST['subject4_marks'];
    $subject5 = $_POST['subject5_marks'];

    // Calculate total marks
    $totalMarks = $subject1 + $subject2 + $subject3 + $subject4 + $subject5;

    // Calculate percentage (max marks = 500)
    $maxMarks = 500;
    $percentage = ($totalMarks / $maxMarks) * 100;

    // Determine pass or fail status
    // If any subject has marks less than 35, the status should be "Fail"
    $status = ($subject1 >= 35 && $subject2 >= 35 && $subject3 >= 35 && $subject4 >= 35 && $subject5 >= 35) ? 'Pass' : 'Fail';

    // Check if the student already has marks in the 'marks' table
    $checkQuery = "SELECT * FROM marks WHERE user_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $studentId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // If marks are already entered for this student, show a message
        echo "<script>alert('Marks already entered for this student!');</script>";
    } else {
        // Insert marks into the 'marks' table if no marks exist for this student
        $sql = "INSERT INTO marks (user_id, subject1_marks, subject2_marks, subject3_marks, subject4_marks, subject5_marks, total_marks, percentage, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiiids", $studentId, $subject1, $subject2, $subject3, $subject4, $subject5, $totalMarks, $percentage, $status);

        if ($stmt->execute()) {
            echo "<script>alert('Marks added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding marks.');</script>";
        }
    }
}

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_marks'])) {
    $marksId = $_POST['marks_id'];

    // Delete marks from the 'marks' table
    $deleteQuery = "DELETE FROM marks WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $marksId);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Marks deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting marks.');</script>";
    }
}

// Fetch students
$studentQuery = "SELECT id, firstname, lastname FROM students";
$studentResult = $conn->query($studentQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Marks</h1>

        <!-- Add Marks Form -->
        <div class="card mb-4" style="margin-left: 250px;">
            <div class="card-body">
                <h5 class="card-title">Add Marks for 5 Subjects</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select" required>
                            <option value="">Select Student</option>
                            <?php while ($student = $studentResult->fetch_assoc()): ?>
                                <option value="<?= $student['id'] ?>">
                                    <?= htmlspecialchars($student['firstname'] . ' ' . $student['lastname']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="subject1_marks" class="form-label">ASP.NET</label>
                        <input type="number" name="subject1_marks" id="subject1_marks" class="form-control" required
                            min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="subject2_marks" class="form-label">JAVA</label>
                        <input type="number" name="subject2_marks" id="subject2_marks" class="form-control" required
                            min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="subject3_marks" class="form-label">WEB</label>
                        <input type="number" name="subject3_marks" id="subject3_marks" class="form-control" required
                            min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="subject4_marks" class="form-label">DS</label>
                        <input type="number" name="subject4_marks" id="subject4_marks" class="form-control" required
                            min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="subject5_marks" class="form-label">PHP</label>
                        <input type="number" name="subject5_marks" id="subject5_marks" class="form-control" required
                            min="0" max="100">
                    </div>

                    <button type="submit" name="insert_marks" class="btn btn-primary">Add Marks</button>
                </form>
            </div>
        </div>

        <!-- View Marks Section -->
        <div class="card" style="margin-left: 250px;">
            <div class="card-body">
                <h5 class="card-title">Marks List</h5>
                <?php
                // Fetch student details along with marks using JOIN
                $marksQuery = "
                SELECT 
                    marks.id AS marks_id,
                    marks.user_id,
                    students.firstname,
                    students.lastname,
                    marks.subject1_marks,
                    marks.subject2_marks,
                    marks.subject3_marks,
                    marks.subject4_marks,
                    marks.subject5_marks,
                    marks.total_marks,
                    marks.percentage,
                    marks.status
                FROM marks
                JOIN students ON marks.user_id = students.id";
                $marksResult = $conn->query($marksQuery);

                if ($marksResult->num_rows > 0):
                    ?>
                    <table class="table table-bordered">
                    <tbody>
    <?php while ($mark = $marksResult->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($mark['user_id']) ?></td>
            <td><?= htmlspecialchars($mark['firstname']) . ' ' . htmlspecialchars($mark['lastname']) ?></td>
            <td><?= htmlspecialchars($mark['subject1_marks']) ?>
                <?php if ($mark['subject1_marks'] <=35): ?>
                    <span class="text-success">*</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($mark['subject2_marks']) ?>
                <?php if ($mark['subject2_marks'] <= 35): ?>
                    <span class="text-success">*</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($mark['subject3_marks']) ?>
                <?php if ($mark['subject3_marks'] <= 35): ?>
                    <span class="text-success">*</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($mark['subject4_marks']) ?>
                <?php if ($mark['subject4_marks'] <= 35): ?>
                    <span class="text-success">*</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($mark['subject5_marks']) ?>
                <?php if ($mark['subject5_marks'] <= 35): ?>
                    <span class="text-success">*</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($mark['total_marks']) ?></td>
            <td><?= htmlspecialchars(number_format($mark['percentage'], 2)) ?>%</td>
            <td><?= htmlspecialchars($mark['status']) ?></td>
            <td>
                <div class="d-flex justify-content-around">
                    <a href="update_marks.php?id=<?= $mark['marks_id'] ?>"
                        class="btn btn-warning btn-sm mx-1">Update</a>
                    <!-- Delete Marks Form -->
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="marks_id" value="<?= $mark['marks_id'] ?>" />
                        <button type="submit" name="delete_marks" class="btn btn-danger btn-sm mx-1"
                            onclick="return confirm('Are you sure you want to delete this entry?');">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

                    </table>
                <?php else: ?>
                    <p>No marks found for students.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>
