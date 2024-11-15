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
    <title>User Dashboard</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #4e54c8, #8f94fb);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            background-color: #2c3e50;
            color: white;
            width: 350px;
            padding: 20px;
        }

        .main-content {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
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

        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        p {
            color: #555;
        }

        .email{
            color:#f1f1f1
        }

        .course-card {
            background-color: #f1f1f1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        }

        .course-card h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .course-card p {
            color: #777;
        }

        .upload-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        }

        .upload-form input[type="file"] {
            display: none;
        }

        .upload-btn {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-btn:hover {
            background-color: #1a2633;
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
                    <p class="email"><?php echo $user_email; ?></p>
                </div>
        </div>
            <div class="nav-item">
                <a href="dashboard.php"><input type="button"name="d"value="Dashboard"></a>
            </div>
            <div class="nav-item">
                <a href="courses.php"><input type="button"name="c"value="Courses"></a>
            </div>
            <div class="nav-item">
                <a href="notes.php"><input type="button"name="n"value="Notes"></a>
            </div>
            <div class="nav-item">
                <a href="settings.php"><input type="button"name="s"value="Settings"></a>
            </div>
            <div class="nav-item">
                <a href="logout.php"><input type="button"name="l"value="Sign out"></a>
            </div>
        </div>
        <div class="main-content">
            <h2>Welcome to Your User Dashboard</h2>
            <p>This is your dashboard where you can manage your courses and account.</p>

            <a href="https://www.geeksforgeeks.org/web-development/">
                <div class="course-card">
                <h4>Introduction to Web Development</h4>
                <p>Learn the basics of HTML, CSS, and JavaScript.</p>
                </div>
            </a>

    <a href="https://www.udemy.com/course/refactoru-intermediate-js/">
            <div class="course-card">
                <h4>Intermediate JavaScript</h4>
                <p>Take your JavaScript skills to the next level.</p>
            </div>
    </a>

    <a href="https://www.w3schools.com/html/html_responsive.asp">
            <div class="course-card">
                <h4>Responsive Web Design</h4>
                <p>Create websites that look great on any device.</p>
            </div>
    </a>

    <div class="upload-form">
    <h4>Upload Your Assignment</h4>
    <a href="upload.php" class="upload-btn">Upload</a>
</div>
        </div>
    </div>
</body>
</html>