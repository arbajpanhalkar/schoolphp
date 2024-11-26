<?php
include('connection.php');
include('header.php');
require_once 'TCPDF-main/TCPDF-main/tcpdf.php'; // Include TCPDF

// Initialize variables
$marks = null;
$studentDetails = null;

// Handle form submission when a student ID is entered
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
    $studentId = $_POST['student_id'];

    // Fetch marks for the selected student
    $marksQuery = "SELECT * FROM marks WHERE user_id = ?";
    $marksStmt = $conn->prepare($marksQuery);
    $marksStmt->bind_param("i", $studentId);
    $marksStmt->execute();
    $marksResult = $marksStmt->get_result();

    if ($marksResult->num_rows > 0) {
        $marks = $marksResult->fetch_assoc();

        // Fetch student details (name) based on student_id
        $studentDetailsQuery = "SELECT firstname, lastname FROM students WHERE id = ?";
        $studentDetailsStmt = $conn->prepare($studentDetailsQuery);
        $studentDetailsStmt->bind_param("i", $studentId);
        $studentDetailsStmt->execute();
        $studentDetailsResult = $studentDetailsStmt->get_result();

        if ($studentDetailsResult->num_rows > 0) {
            $studentDetails = $studentDetailsResult->fetch_assoc();
        }
    }
}

// Function to generate and download PDF
if (isset($_POST['download_pdf']) && $marks && $studentDetails) {
    // Clean output buffer
    ob_clean();
    flush();

    // Create a new PDF document
    $pdf = new TCPDF();
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('School Name');
    $pdf->SetTitle('Student Marks');
    $pdf->SetSubject('Student Report');
    $pdf->SetKeywords('TCPDF, PDF, Student, Marks');
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);
    
    // Prepare HTML content for the PDF
    $html = '<h3>Marks for ' . htmlspecialchars($studentDetails['firstname'] . ' ' . $studentDetails['lastname']) . '</h3>';
    $html .= '
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Subjects</th>
                    <th colspan="5" class="text-center">Marks</th>
                    <th rowspan="2">Total Marks</th>
                    <th rowspan="2">Percentage</th>
                </tr>
                <tr>
                    <th>ASP.NET</th>
                    <th>JAVA</th>
                    <th>WEB</th>
                    <th>DS</th>
                    <th>PHP</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Marks</td>
                    <td>' . htmlspecialchars($marks['subject1_marks']) . '</td>
                    <td>' . htmlspecialchars($marks['subject2_marks']) . '</td>
                    <td>' . htmlspecialchars($marks['subject3_marks']) . '</td>
                    <td>' . htmlspecialchars($marks['subject4_marks']) . '</td>
                    <td>' . htmlspecialchars($marks['subject5_marks']) . '</td>
                    <td>' . htmlspecialchars($marks['total_marks']) . '</td>
                    <td>' . number_format($marks['percentage'], 2) . '%</td>
                </tr>
            </tbody>
        </table>
    ';
    
    // Add the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Output the PDF to the browser
    $pdf->Output('student_marks.pdf', 'I'); // 'I' will display the PDF in the browser
    
    exit; // Stop further execution of the script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .form-control {
            width: 200px;
        }
        .flexdisplay {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">View Student Marks</h1>

        <!-- Form to Enter Student ID -->
        <form method="POST">
            <div class="mb-3 flexdisplay">
                <label for="student_id" class="form-label">Enter Student ID</label>
                <input type="number" name="student_id" id="student_id" class="form-control" required>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <button type="submit" class="btn btn-primary">View Marks</button>
            </div>
        </form>

        <?php if ($marks && $studentDetails): ?>
            <!-- Display the marks for the selected student -->
            <div class="mt-4">
                <h3>Marks for <?= htmlspecialchars($studentDetails['firstname'] . ' ' . $studentDetails['lastname']) ?></h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th rowspan="2">Subjects</th>
                            <th colspan="5" class="text-center">Marks</th>
                            <th rowspan="2">Total Marks</th>
                            <th rowspan="2">Percentage</th>
                        </tr>
                        <tr>
                            <th>ASP.NET</th>
                            <th>JAVA</th>
                            <th>WEB</th>
                            <th>DS</th>
                            <th>PHP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Marks</td>
                            <td><?= $marks['subject1_marks'] ?></td>
                            <td><?= $marks['subject2_marks'] ?></td>
                            <td><?= $marks['subject3_marks'] ?></td>
                            <td><?= $marks['subject4_marks'] ?></td>
                            <td><?= $marks['subject5_marks'] ?></td>
                            <td><?= $marks['total_marks'] ?></td>
                            <td><?= number_format($marks['percentage'], 2) ?>%</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Download PDF Button -->
                <form method="POST">
                    <button type="submit" name="download_pdf" class="btn btn-danger">Download Results as PDF</button>
                </form>
            </div>
        <?php elseif (isset($_POST['student_id'])): ?>
            <p>No marks found for the student with ID: <?= htmlspecialchars($studentId) ?>.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
