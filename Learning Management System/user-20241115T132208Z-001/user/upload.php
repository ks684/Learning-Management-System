<?php
session_start();

// Check if the user is logged in (you can replace this with your own authentication logic)
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include your database connection here
require_once('db_connection.php');

// Handle file upload
if (isset($_POST['upload'])) {
    $fileName = basename($_FILES["assignmentFile"]["name"]);
    $fileData = file_get_contents($_FILES["assignmentFile"]["tmp_name"]);

    // Allow only certain file formats (you can modify this)
    $allowedTypes = array('pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'pptx');
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    if (in_array($fileType, $allowedTypes)) {
        // Insert file information into the database
        $userId = $_SESSION['user']; // Adjust this based on your session structure
        $insertQuery = "INSERT INTO s_assignments (assignmentId, file_name, file_data) VALUES (:assignmentId, :file_name, :file_data)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':assignmentId', $userId);
        $stmt->bindParam(':file_name', $fileName);
        $stmt->bindParam(':file_data', $fileData, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            // File uploaded successfully, show success alert
            echo '<script>alert("File uploaded successfully.");</script>';
        } else {
            // File upload failed, show error alert
            echo '<script>alert("File upload failed.");</script>';
        }
    } else {
        // Unsupported file type, show error alert
        echo '<script>alert("Unsupported file type.");</script>';
    }
}

// Fetch and display the user's assignments
$userId = $_SESSION['user']; // Adjust this based on your session structure
$selectQuery = "SELECT * FROM s_assignments WHERE assignmentId = :assignmentId";
$stmt = $pdo->prepare($selectQuery);
$stmt->bindParam(':assignmentId', $userId);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Assignments</title>
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

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .btn {
            border: 2px solid gray;
            color: gray;
            background-color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        .file-name {
            margin-left: 10px;
        }

        .assignments {
            margin-top: 20px;
        }

        .assignment {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .assignment a {
            text-decoration: none;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
    <script>
        function updateFileName() {
            var input = document.getElementById('assignmentFile');
            var fileName = input.files[0].name;
            document.querySelector('.file-name').textContent = fileName;
        }

        function deleteAssignment(assignmentId) {
            if (confirm("Are you sure you want to delete this assignment?")) {
                // Implement the deletion logic here using AJAX or form submission to a delete endpoint
                // For now, we'll just reload the page to simulate deletion
                window.location.reload();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Upload Assignments</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="upload-btn-wrapper">
                <button class="btn">Choose a file</button>
                <input type="file" name="assignmentFile" id="assignmentFile" onchange="updateFileName()">
            </div>
            <br><br><button type="submit" class="btn btn-success" name="upload">Submit</button>
        </form>
        <br><h5><span class="file-name">No file selected</span></h5>

        <!-- Display uploaded assignments -->
    </div>

</body>
</html>
