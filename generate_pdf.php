<?php
require_once 'connection.php'; // Ensure your database connection is set up correctly
require_once 'TCPDF-main/TCPDF-main/tcpdf.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the database (assuming user id is passed or it's the latest entry)
$user_id = 1; // Example user ID, you can pass or retrieve dynamically
$query = "SELECT * FROM registrations WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $user_data = mysqli_fetch_assoc($result);
    
    if ($user_data) {
        // Create new PDF instance
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set font for the title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Registration Form Details', 0, 1, 'C');
        $pdf->Ln(10); // Add space after title

        // Add image (if exists)
        if (!empty($user_data['file'])) {
            $image_path = 'uploads/' . $user_data['file'];
            // Check if file exists
            if (file_exists($image_path)) {
                $pdf->Image($image_path, 15, 35, 50, 50); // Adjust x, y, width, height as needed
                $pdf->Ln(60); // Add space after the image (adjust if needed)
            } else {
                $pdf->Cell(0, 10, 'No image found', 0, 1);
            }
        } else {
            $pdf->Cell(0, 10, 'No image uploaded', 0, 1);
        }

        // Personal Information Section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Personal Information', 0, 1);
        $pdf->SetFont('helvetica', '', 12);

        // Add data to PDF
        $pdf->Cell(0, 10, 'First Name: ' . $user_data['firstname'], 0, 1);
        $pdf->Cell(0, 10, 'Last Name: ' . $user_data['lastname'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $user_data['email'], 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $user_data['phone'], 0, 1);
        $pdf->Cell(0, 10, 'Address: ' . $user_data['address'], 0, 1);
        $pdf->Cell(0, 10, 'City: ' . $user_data['city'], 0, 1);
        $pdf->Cell(0, 10, 'State: ' . $user_data['state'], 0, 1);
        $pdf->Cell(0, 10, 'Zip Code: ' . $user_data['zipcode'], 0, 1);
        $pdf->Cell(0, 10, 'Country: ' . $user_data['country'], 0, 1);

        // Masked Password
        $pdf->Cell(0, 10, 'Password: ' . '**********', 0, 1);
        $pdf->Ln(5); // Add space between sections

        // File Upload Status Section
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Uploaded File Status', 0, 1);
        $pdf->SetFont('helvetica', '', 12);
        $file_status = $user_data['file'] ? 'File uploaded: ' . $user_data['file'] : 'No file uploaded';
        $pdf->Cell(0, 10, $file_status, 0, 1);

        // Output PDF to browser
        $pdf->Output('registration_form.pdf', 'I'); // 'I' for inline display in the browser

    } else {
        echo "No data found for user ID: " . $user_id;
    }
} else {
    echo "Error executing query: " . mysqli_error($conn);
}
?>
