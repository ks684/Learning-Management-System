<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection here
require_once('db_connection.php');

// Get user's name and email from the database
$username = $_SESSION['user']; // Assuming you store user's username in the session
$query = "SELECT Name, Email FROM user WHERE Username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // User not found in the database
    header("Location: login.php");
    exit();
}

$user_name = $user['Name'];
$user_email = $user['Email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Swayam Courses</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .dashboard-container {
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            background-color: #2c3e50;
            color: white;
            width: 250px;
            padding: 20px;
            height: 100vh;
        }

        .main-content {
            flex: 1;
            background-color: white;
            padding: 20px;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-item a {
            color: white;
            text-decoration: none;
        }

        .nav-item a:hover {
            text-decoration: underline;
        }

        .course-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .course {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer; /* Add cursor pointer to indicate clickable element */
        }

        .course h3 {
            margin-top: 0;
        }

        .course p {
            color: #666;
            font-size: 14px;
        }
        .b1{
            background-color:aqua;
            
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="profile">
                <img src="../images/profile.jpg" alt="Profile Image">
                <div>
                    <h6>Welcome <?php echo $user_name; ?></h6>
                    <p ><?php echo $user_email; ?></p>
                </div>
            </div>
            <div class="nav-item">
                <a href="dashboard.php"><input type="button"name="d"value="Dashboard"></a>
            </div>
            <div class="nav-item">
                <a href="courses.php"><input type="button"name="d"value="Courses"></a>
            </div>
            <div class="nav-item">
                <a href="notes.php"><input type="button"name="d"value="Notes"></a>
            </div>
            <div class="nav-item">
                <a href="settings.php"><input type="button"name="d"value="Settings"></a>
            </div>
            <div class="nav-item">
                <a href="logout.php"><input type="button"name="d"value="Sign out"></a>
            </div>
        </div>
        <div class="main-content">
            <div class="container">
                <h2>Swayam Courses</h2>
                <div class="course-list">
                    <?php
                    // Simulated course data (same as before)
                    $courses = [
                ['title' => 'C Programming And Assembly Language', 'instructor' => 'Prof. Janakiraman ', 'intro' => 'How a C program is translated to assembly language and how it eventually gets executed on a microprocessor. Through, animations we show what happens in the stack, data and code segment, of the microprocessor when a C program is executed. ','url'=>'https://onlinecourses.nptel.ac.in/noc23_cs93/preview'],
                ['title' => 'Programming, Data Structures And Algorithms Using Python', 'instructor' => 'Prof. Madhavan Mukund', 'intro' => 'This course is an introduction to programming and problem solving in Python.  It does not assume any prior knowledge of programming.  Using some motivating examples, the course quickly builds up basic concepts such as conditionals, loops, functions, lists, strings and tuples.', 'url' => 'https://onlinecourses.nptel.ac.in/noc23_cs95/preview'],
                ['title' => 'Python For Data Science', 'instructor' => 'Prof. Ragunathan Rengasamy', 'intro' => 'The course aims at equipping participants to be able to use python programming for solving data science problems.','url'=>'https://onlinecourses.nptel.ac.in/noc23_cs99/preview'],
                ['title' => 'Introduction To Machine Learning', 'instructor' => 'Prof. Balaraman Ravindran', 'intro' => 'With the increased availability of data from varied sources there has been increasing attention paid to the various data driven disciplines such as analytics and machine learning. In this course we intend to introduce some of the basic concepts of machine learning from a mathematically well motivated perspective. We will cover the different learning paradigms and some of the more popular algorithms and architectures used in each of these paradigms.','url'=>'https://onlinecourses.nptel.ac.in/noc23_cs98/preview'],
                ['title' => 'Digital Marketing', 'instructor' => 'Dr. Tejinderpal Singh ', 'intro' => 'Digital marketing is the use of digital technologies and platforms to promote products and services, as well as to connect with potential customers. It is an incredibly versatile and powerful tool that can be used in various ways to reach people worldwide. ','url'=>'https://onlinecourses.swayam2.ac.in/cec22_mg01/preview'],
                ['title' => 'Fundamentals Of Artificial Intelligence', 'instructor' => 'Prof. Shyamanta M. Hazarika ', 'intro' => 'The objective of this course is to present an overview of the principles and practices of AI to address such complex real-world problems. The course is designed to develop a basic understanding of problem solving, knowledge representation, reasoning and learning methods of AI.','url'=>'https://onlinecourses.nptel.ac.in/noc23_ge40/preview'],
                // Add more courses here...
                    ];

                    foreach ($courses as $course) {
                        echo '<div class="course">';
                        echo '<h3>' . $course['title'] . '</h3>';
                        echo '<p>Instructor: ' . $course['instructor'] . '</p>';
                        echo '<p>' . $course['intro'] . '</p>';
                        
                        // Check if 'url' key exists before creating the link
                        if (isset($course['url'])) {
                            echo '<a href="' . $course['url'] . '" target="_blank"><input type="button"name="Redirect"value="Go to Course"class="b1"></a>';
                        } else {
                            echo '<p>No link available</p>';
                        }
                        
                        echo '</div>';
                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
