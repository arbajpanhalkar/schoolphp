<?php
include('connection.php');

// Check if studentId is provided in the URL (via GET method)
if (isset($_GET['studentId']) && !empty($_GET['studentId'])) {
    $studentId = (int)$_GET['studentId']; // Cast to integer to prevent SQL injection
} else {
    die("Student ID is required.");
}

// Fetch student details (first name, last name, email) including the image filename
$studentDetailsQuery = "SELECT firstname, lastname, email, img FROM students WHERE id = ?";
$studentDetailsStmt = $conn->prepare($studentDetailsQuery);
$studentDetailsStmt->bind_param("i", $studentId);
$studentDetailsStmt->execute();
$studentDetailsResult = $studentDetailsStmt->get_result();

$studentDetails = null;
$errorMessage = '';  // Initialize the error message variable

if ($studentDetailsResult->num_rows > 0) {
    $studentDetails = $studentDetailsResult->fetch_assoc();
} else {
    $errorMessage = "No student found with this ID.";  // Store the error message
}

// Fetch marks for the student
$marksQuery = "SELECT subject1_marks, subject2_marks, subject3_marks, subject4_marks, subject5_marks, total_marks, percentage FROM marks WHERE user_id = ?";
$marksStmt = $conn->prepare($marksQuery);
$marksStmt->bind_param("i", $studentId);
$marksStmt->execute();
$marksResult = $marksStmt->get_result();

$marks = null;
if ($marksResult->num_rows > 0) {
    $marks = $marksResult->fetch_assoc();
} else {
    die("No marks found for this student.");
}

// Include TCPDF
require_once 'TCPDF-main/TCPDF-main/tcpdf.php';

// Check if student details and marks were fetched
if ($marks && $studentDetails) {
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

    // Add background image
    $pdf->SetXY(0, 0); // Set coordinates to the top-left corner
    $pdf->Image('img/background.jpg', 0, 0, 210, 297); // Adjust to fit A4 size (210x297 mm)

    // Add logo
    $pdf->SetXY(10, 10); // Position of logo
    $pdf->Image('img/dyp_logo.jpeg', 10, 10, 30); // Adjust logo size and path

    // Fetch image filename from database
    if (!empty($studentDetails['img'])) {
        $studentImagePath = $studentDetails['img']; // Path to the uploaded image
        if (file_exists($studentImagePath)) {
            // If image exists, display it
            $pdf->SetXY(150, 40); // Position it on the right side (adjust coordinates as needed)
            $pdf->Image($studentImagePath, 150, 40, 36, 30); // 36x30 for profile image size
        } else {
            // If image doesn't exist, display a placeholder
            $pdf->SetXY(150, 40); // If no image, display a placeholder on the right side
            $pdf->Cell(0, 10, 'No profile image found.', 0, 1, 'L');
        }
    } else {
        // If no image field exists in the database
        $pdf->SetXY(150, 40);
        $pdf->Cell(0, 10, 'No profile image available.', 0, 1, 'L');
    }

    // Set header
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetXY(50, 10);
    $pdf->Cell(0, 10, 'DYP ATU College - Student Report', 0, 1, 'L');

    $pdf->Ln(20); // Add space after the header

    // Add Student Details
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Full Name: ' . htmlspecialchars($studentDetails['firstname'] . ' ' . $studentDetails['lastname']), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Student ID: ' . htmlspecialchars($studentId), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($studentDetails['email']), 0, 1, 'L');
    $pdf->Cell(0, 10, 'Semester: Semester 2, MCA', 0, 1, 'L');

    $pdf->Ln(10); // Add space before the table

    // Determine if the student has passed or failed based on individual subject marks
    $status = 'Pass';  // Assume Pass by default

    // Check if any subject mark is below 35
    if ($marks['subject1_marks'] < 35 || $marks['subject2_marks'] < 35 || $marks['subject3_marks'] < 35 || $marks['subject4_marks'] < 35 || $marks['subject5_marks'] < 35) {
        $status = 'Fail';
    }

    // Prepare HTML content for the marks table
    $html = '
        <h3>Marks for ' . htmlspecialchars($studentDetails['firstname'] . ' ' . $studentDetails['lastname']) . '</h3>
        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin: 20px 0;">
            <thead style="background-color: blue; color: white;">
                <tr>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold;">Subjects</th>
                    <th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold;">Marks</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #f9f9f9;">
                    <td style="border: 1px solid #ddd; padding: 10px; ">ASP.NET</td>
                    <td style="border: 1px solid #ddd; padding: 10px; ">' . htmlspecialchars($marks['subject1_marks']) . '</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;">JAVA</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . htmlspecialchars($marks['subject2_marks']) . '</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="border: 1px solid #ddd; padding: 10px;">WEB</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . htmlspecialchars($marks['subject3_marks']) . '</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;">DS</td>
                    <td style="border: 1px solid #ddd; padding: 10px; ">' . htmlspecialchars($marks['subject4_marks']) . '</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="border: 1px solid #ddd; padding: 10px;">PHP</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . htmlspecialchars($marks['subject5_marks']) . '</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px;">Total Marks</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . htmlspecialchars($marks['total_marks']) . '</td>
                </tr>
                <tr style="background-color: yellow;">
                    <td style="border: 1px solid #ddd; padding: 10px;">Percentage</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . number_format($marks['percentage'], 2) . '%</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Status</td>
                    <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold; color: ' . ($status == 'Pass' ? 'green' : 'red') . ';">' . $status . '</td>
                </tr>
            </tbody>
        </table>
    ';

    // Add the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the PDF (Force download)
    $pdf->Output('student_report_' . $studentId . '.pdf', 'D');
} else {
    // If no student details or marks were found, display an error message
    echo $errorMessage ? $errorMessage : "No data found for this student.";
}
?>
