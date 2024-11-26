<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Footer with Logo</title>
    <style>
        footer {
            background-color: #565656;
            color: #fff;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-container div {
            flex: 1;
            margin: 10px;
        }

        h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: blue;
        }

        .footer-about img {
            max-width: 100px;
            margin-bottom: 15px;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links ul li {
            margin-bottom: 10px;
        }

        .footer-links ul li a {
            color:black;
            text-decoration: none;
        }

        .footer-links ul li a:hover {
            text-decoration: underline;
        }

        .footer-contact .social-icons a {
            color: #fff;
            font-size: 1.2rem;
            margin-right: 15px;
            text-decoration: none;
        }

        .footer-contact .social-icons a:hover {
            color: black;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            font-size: 0.9rem;
            border-top: 1px solid #fff;
            margin-top: 20px;
            color: black;
        }
        /* Responsive Design for Smaller Screens */
@media screen and (max-width: 1024px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .footer-container div {
        flex: 0 0 100%;
        margin: 10px 0;
    }

    h3 {
        font-size: 1.2rem;
    }

    .footer-contact .social-icons a {
        font-size: 1rem;
        margin-right: 10px;
    }
}

/* Mobile Design */
@media screen and (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }

    .footer-links ul li {
        margin-bottom: 8px;
    }

    h3 {
        font-size: 1.1rem;
    }

    .footer-contact .social-icons a {
        font-size: 1rem;
        margin-right: 10px;
    }
}

/* Very Small Screen (Mobile Devices) */
@media screen and (max-width: 480px) {
    footer {
        padding: 20px 10px;
    }

    .footer-container {
        padding: 0;
    }

    .footer-links ul li a {
        font-size: 0.9rem;
    }

    .footer-bottom {
        font-size: 0.8rem;
        color: #fff;
    }
}
    </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <!-- About Us Section -->
             <form action="header.php"method="post">
            <div class="footer-about">
            <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo" class="logo">
            <h3><?php echo htmlspecialchars($website_name); ?></h3>
                <p></p>
            </div>
            </form>
            <!-- Quick Links Section -->
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index1.php">student Registration </a></li>
                    <li><a href="teacher.php">Teacher Registration</a></li>
                    <!-- <li><a href="services.php">Services</a></li> -->
                    <li><a href="contact_form.php">Contact</a></li>
                </ul>
            </div>
            <!-- Contact Us Section -->
            <div class="footer-contact">
            <h3 style="color:blue; display: inline-block;">Contact Us</h3>

                <p style="color:black;">Email: info@example.com</p>
                <p style="color:black;">Phone: +123 456 7890</p>
                <div class="social-icons">
                    <a href="#"><i class="fa fa-facebook" >facebook</i></a>
                    <a href="#"><i class="fa fa-twitter"></i>twitter</a>
                    <a href="#"><i class="fa fa-instagram"></i>instagram</a>
                    <a href="#"><i class="fa fa-linkedin"></i>linkedin</a>
                </div>
            </div>
        </div>
        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> APSCHOOL. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
