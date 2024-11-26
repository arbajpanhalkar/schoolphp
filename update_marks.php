<?php
include('connection.php');
include('sidebar.php');

// Check if 'id' is passed via the URL
if (isset($_GET['id'])) {
    $marksId = $_GET['id'];

    // Fetch the marks record from the database
    $query = "SELECT marks.id AS marks_id, marks.user_id, students.firstname, students.lastname, 
                     marks.subject1_marks, marks.subject2_marks, marks.subject3_marks, 
                     marks.subject4_marks, marks.subject5_marks, marks.total_marks, marks.percentage 
              FROM marks 
              JOIN students ON marks.user_id = students.id 
              WHERE marks.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $marksId);
    $stmt->execute();
    $result = $stmt->get_result();
    $mark = $result->fetch_assoc();

    if (!$mark) {
        echo "<script>alert('Record not found!');</script>";
        exit;
    }

    // Handle form submission for updating marks
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_marks'])) {
        $subject1 = $_POST['subject1_marks'];
        $subject2 = $_POST['subject2_marks'];
        $subject3 = $_POST['subject3_marks'];
        $subject4 = $_POST['subject4_marks'];
        $subject5 = $_POST['subject5_marks'];

        // Calculate total and percentage
        $totalMarks = $subject1 + $subject2 + $subject3 + $subject4 + $subject5;
        $percentage = ($totalMarks / 500) * 100;

        // Update the marks in the database
        $updateQuery = "UPDATE marks SET subject1_marks = ?, subject2_marks = ?, subject3_marks = ?, 
                        subject4_marks = ?, subject5_marks = ?, total_marks = ?, percentage = ? 
                        WHERE id = ?";
        
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("iiiiiiii", $subject1, $subject2, $subject3, $subject4, $subject5, $totalMarks, $percentage, $marksId);

        if ($updateStmt->execute()) {
            echo "<script>alert('Marks updated successfully!'); window.location.href='adminmark.php';</script>";
        } else {
            echo "<script>alert('Error updating marks.');</script>";
        }
    }
} else {
    echo "<script>alert('No marks ID provided.'); window.location.href='marks.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Marks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5" style="margin-left: 250px;">
    <!-- <h1 class="text-center mb-4">Update Marks</h1>  -->

    <div class="card mb-4">
        <div class="card-body" >
            <h5 class="card-title">Update Marks for <?= htmlspecialchars($mark['firstname']) . ' ' . htmlspecialchars($mark['lastname']) ?></h5>

            <form method="POST">
                <div class=""></div>
                <div class="mb-3">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" id="student_id" class="form-control" value="<?= htmlspecialchars($mark['user_id']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="subject1_marks" class="form-label">ASP.NET</label>
                    <input type="number" name="subject1_marks" id="subject1_marks" class="form-control" value="<?= htmlspecialchars($mark['subject1_marks']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="subject2_marks" class="form-label">JAVA</label>
                    <input type="number" name="subject2_marks" id="subject2_marks" class="form-control" value="<?= htmlspecialchars($mark['subject2_marks']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="subject3_marks" class="form-label">WEB</label>
                    <input type="number" name="subject3_marks" id="subject3_marks" class="form-control" value="<?= htmlspecialchars($mark['subject3_marks']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="subject4_marks" class="form-label">DS</label>
                    <input type="number" name="subject4_marks" id="subject4_marks" class="form-control" value="<?= htmlspecialchars($mark['subject4_marks']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="subject5_marks" class="form-label">PHP</label>
                    <input type="number" name="subject5_marks" id="subject5_marks" class="form-control" value="<?= htmlspecialchars($mark['subject5_marks']) ?>" required>
                </div>

                <button type="submit" name="update_marks" class="btn btn-primary">Update Marks</button>
                <a href="adminmark.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
