<?php 
include('header.php');
?>

   
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Student ID</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            /* background-color: #f9f9f9; */
            height: 450px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Enter Student ID </h2>
            <form action="demo.php" method="GET">
                <div class="form-group">
                    <label for="studentId">Student ID:</label>
                    <input type="number" class="form-control" name="studentId" id="studentId" required placeholder="Enter Student ID">
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-primary w-100" value="Generate Report">
                </div>
            </form> 
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
include('footer.php');
?>

