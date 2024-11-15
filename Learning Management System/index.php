<?php
include_once 'includes/header.php';
?>


<!DOCTYPE html>
<html>
<head>
    <title>Learning Management System</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Include Font Awesome CSS from CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Your custom CSS styles go here */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        .contact-info {
            text-align: center;
        }

        .contact-info h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .contact-info p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .social-media {
            font-size: 24px;
        }

        .social-media a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }

        .social-media a:hover {
            color: #f8f9fa;
        }

        #a{
            margin-left: 45%;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="hero">
            <h1>Welcome to the Learning Management System</h1>
            <h3><p><b>Your gateway to knowledge and education.</b></p></h3>
            <i><p>A Learning Management System (LMS) is a comprehensive 
                digital platform that empowers educators and organizations 
                to create, deliver, and manage educational content and 
                training materials. It simplifies the process of disseminating 
                knowledge by offering features like course creation, assessment tools, 
                tracking learner progress, and facilitating interactive learning 
                experiences, making it an essential tool for efficient and organized 
                online education and training initiatives.</p></i>
        </section>
        <footer>
            <div class="row">
                <div class="col-md-6 contact-info">
                    <h3>Contact Us</h3>
                    <address>
                        <strong>Address:</strong><br>
                        123 Main Street<br>
                        City, Country
                    </address>
                    <p>
                        <strong>Email:</strong> lms1234@gmail.com<br>
                        <strong>Phone:</strong> +91 5215463214
                    </p>
                </div>
                <div class="col-md-6">
                    <h3>Follow Us</h3>
                    <div class="social-media">
                        <a href="https://www.facebook.com/learning.management.system.2023?mibextid=ZbWKwL" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://twitter.com/LMS_KC_2023" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/lms_kc_2023?utm_source=qr&igshid=MThlNWY1MzQwNA==" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div>
            <a href="Admin1/pass.php" target="_blank" ><input type="button" id="a" value="Admin"></a>
    </div >
        </footer>
    </div>
    <!-- Optional: Include Bootstrap and Font Awesome JavaScript if needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"></script>
</body>
</html>