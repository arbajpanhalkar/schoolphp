<?php
include 'connection.php';
include('header.php');

// Query to fetch teachers and their associated class
$sql = "SELECT teachers.id, teachers.firstname, teachers.lastname, classes.class_name, teachers.file 
        FROM teachers
        LEFT JOIN classes ON teachers.class_id = classes.id";
$result = $conn->query($sql);

// Query to fetch principle data
$sql1 = "SELECT * FROM principle";
$result1 = $conn->query($sql1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: blanchedalmond;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .image-container {
            display: flex;
            gap: 15px;
        }

        .image-container img {
            width: 420px;
            height: 450px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-container img:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .container::-webkit-scrollbar {
            height: 8px;
        }

        .container::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .container::-webkit-scrollbar-track {
            background: transparent;
        }

        .container2 {
            text-align: center;
            color: #2d133f;
        }

        .flex-container {
            display: flex;
            align-items: center;
            gap: 50px;
            padding: 20px;
        }

        .flex-container img {
            width: 400px;
            height: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .flex-container p {
            font-size: 1.5rem;
            color: #333;
            line-height: 1.5;
            font-family: Arial, sans-serif;
        }

        .contnertechers {
            display: flex;
            flex-wrap: wrap;
            gap: 100px;
            justify-content: center;
            padding: 20px;
        }

        .teacher-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .teacher-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .teacher-card img {
            width: 300px;
            height: 300px;
            /* border-bottom: 20px solid #ddd; */
        }

        .teacher-card p {
            text-align: center;
            font-size: 0.9rem;
            color: #333;
            padding: 10px;
            font-family: Arial, sans-serif;
        }
        /* facilty  */

        .containerfaclity {
            display: flex;
            flex-wrap: wrap;
            gap: 120px;
            justify-content: center;
            padding: 20px;
        }

        .facility-card {
            background-color: #fff;
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            text-align: center;
        }

        .facility-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .facility-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .facility-card .card-content {
            padding: 15px;
        }

        .facility-card h2 {
            font-size: 1.5rem;
            color: #2d133f;
            margin: 10px 0;
        }

        .facility-card p {
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        /* mobile using media query */

        /* Responsive Design for Smaller Screens */
@media screen and (max-width: 1024px) {
    .flex-container {
        flex-direction: column;
        align-items: center;
        gap: 30px;
    }

    .flex-container img {
        width: 80%;
        height: auto;
    }

    .teacher-card,
    .facility-card {
        width: 80%;
    }

    .image-container img {
        width: 90%;
    }
}

/* Mobile Design */
@media screen and (max-width: 768px) {
    .container {
        padding: 10px;
        margin-left: 20px;
    }

    .image-container {
        flex-direction: row;
        gap: 20px;
     
    }

    .teacher-card,
    .facility-card {
        width: 100%;
    }

    .flex-container {
        flex-direction: column;
        gap: 20px;
        justify-content: right;
    }

    .flex-container img {
        width: 100%;
        height: auto;
    }

    .teacher-card img,
    .facility-card img {
        width: 100%;
        height: auto;
    }
}

/* Very Small Screen (Mobile Devices) */
@media screen and (max-width: 480px) {
    .teacher-card p,
    .facility-card p {
        font-size: 0.8rem;
    }

    .teacher-card img {
        width: 80%;
        height: auto;
    }

    .facility-card img {
        width: 100%;
        height: auto;
    }
}

        
    </style>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="img/img1.jpg" alt="Image 1">
            <img src="img/img2.jpg" alt="Image 2">
            <img src="img/img3.jpg" alt="Image 3">
        </div>
    </div>
    <br><br>
    <div class="container2">
        <h1>About us</h1>
    </div>

    <div class="flex-container">
        <?php
        if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $image_path1 = !empty($row1['img']) ? $row1['img'] : 'img/default_teacher.jpg';
        ?>
            <img src="<?php echo $image_path1; ?>" alt="Example Image">
            <p><?php echo $row1['info']; ?></p>
        <?php
        }
        ?>
    </div>

    <div class="container2">
        <h1>Our Teachers</h1>
    </div>

    <div class="contnertechers">
        <?php
        if ($result->num_rows > 0) {
            // Loop through all teachers and display their info
            while ($row = $result->fetch_assoc()) {
                $image_path = !empty($row['file']) ? $row['file'] : 'img/default_teacher.jpg'; // Default image if none exists
        ?>
                <div class="teacher-card">
                    <img src="<?php echo $image_path; ?>" alt="Teacher Image">
                    <p><strong><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></strong><br>
                        Class: <?php echo $row['class_name']; ?>
                    </p>
                </div>
        <?php
            }
        } else {
            echo "<p>No teachers found</p>";
        }
        ?>
    </div>
    <br><br>
    <div class="container2">
        <h1>Facility</h1>
    </div>
    <div class="containerfaclity">
        <!-- Bus Transport -->
        <div class="facility-card">
            <img src="img/bus.webp" alt="Bus Transport">
            <div class="card-content">
                <h2>Bus Transport</h2>
                <p>Safe and reliable transport facilities for students, covering a wide area of routes.</p>
            </div>
        </div>
        <!-- Events -->
        <div class="facility-card">
            <img src="img/events.jfif" alt="Events">
            <div class="card-content">
                <h2>Events</h2>
                <p>Regular cultural and academic events to foster student growth and engagement.</p>
            </div>
        </div>
        <!-- Sports -->
        <div class="facility-card">
            <img src="img/sports.jpg" alt="Sports">
            <div class="card-content">
                <h2>Sports</h2>
                <p>State-of-the-art sports facilities to encourage physical fitness and teamwork.</p>
            </div>
        </div>

        
    </div>
</body>
<?php 
include('footer.php');
?>

</html>
