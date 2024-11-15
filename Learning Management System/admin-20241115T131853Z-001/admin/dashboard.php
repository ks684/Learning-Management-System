<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection here
require_once('db_connection.php');

// Get user's name and email from the database
$username = $_SESSION['admin']; // Assuming you store user's username in the session
$query = "SELECT Name, Email FROM admin WHERE Username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // User not found in the database
    header("Location: login.php");
    exit();
}

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["assignmentFile"])) {
    $targetDirectory = "uploads/"; // Define the directory where you want to save the files
    $targetFile = $targetDirectory . basename($_FILES["assignmentFile"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is a PDF or any allowed file type
    $allowedTypes = array("pdf", "doc", "docx", "txt"); // Add more allowed types if needed
    if (!in_array($fileType, $allowedTypes)) {
        echo "Only PDF, DOC, DOCX, or TXT files are allowed.";
    } else {
        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["assignmentFile"]["tmp_name"], $targetFile)) {
            echo "File has been uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
                    <h6>Welcome Teacher</h6>
                </div>
            </div>
            <div class="nav-item">
                <a href="dashboard.php"><input type="button"name="d"value="Dashboard"></a>
            </div>
            <div class="nav-item">
                <a href="students.php"><input type="button"name="l"value="List of Students"></a>
            </div>
            <div class="nav-item">
                <a href="notes.php"><input type="button"name="n"value="Notes"></a>
            </div>
            <div class="nav-item">
                <a href="logout.php"><input type="button"name="l"value="Sign out"></a>
            </div>
            
        </div>
        <div class="main-content">
            <h2>Welcome to Your User Dashboard</h2>
            <p>This is your dashboard where you can manage your courses and account.</p>


            <div class="upload-form">
                <h4>Upload Your Assignment</h4>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="assignmentFile">Select a file:</label>
                    <input type="file" name="assignmentFile" id="assignmentFile">
                    <button type="submit" class="upload-btn" name="upload">Upload</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
