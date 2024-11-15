<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin1'])) {
    header("Location: pass.php"); // Redirect to admin login page if not logged in
    exit();
}

// Your admin dashboard content goes here
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
            <div class="nav-item">
                <a href="S.php"><input type="button"name="d"value="List Of Students"></a>
            </div>
            <div class="nav-item">
                <a href="T.php"><input type="button"name="c"value="List Of Teachers"></a>
            </div>
        </div>
        <div class="main-content">
            <h2>Welcome to Your Admin Dashboard</h2>
            <p>This is your dashboard where you can see list of students and teachers.</p>
        </div>
    </div>
</body>
</html>