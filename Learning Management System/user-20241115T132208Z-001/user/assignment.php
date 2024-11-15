<!DOCTYPE html>
<html>
<head>
    <title>Assignment Upload</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, purple, cyan);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
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
            width: 250px;
            padding: 20px;
        }

        .main-content {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
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

        .assignments {
            margin-top: 20px;
        }

        .assignment {
            background-color: #f1f1f1;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <!-- Dashboard navigation content -->
            <h6>Welcome, User</h6>
            <div class="nav-item">
                <a href="#">Dashboard</a>
            </div>
            <div class="nav-item">
                <a href="#">Courses</a>
            </div>
            <div class="nav-item">
                <a href="#">Enrollments</a>
            </div>
            <div class="nav-item">
                <a href="#">Settings</a>
            </div>
            <div class="nav-item">
                <a href="#">Logout</a>
            </div>
        </div>
        <div class="main-content">
            <!-- Assignment upload and display content -->
            <h2>Assignment Upload</h2>
            <div class="upload-form">
                <h4>Upload Your Assignment</h4>
                <form action="#" method="post" enctype="multipart/form-data">
                    <label for="assignmentFile">Select a file:</label>
                    <input type="file" name="assignmentFile" id="assignmentFile">
                    <button type="submit" class="upload-btn">Upload</button>
                </form>
            </div>
            <div class="assignments">
                <h4>Your Uploaded Assignments</h4>
                <?php
                // Check if a file was uploaded
                if (isset($_FILES['assignmentFile'])) {
                    $targetDir = 'uploads/';
                    $targetFile = $targetDir . basename($_FILES['assignmentFile']['name']);
                    $uploadSuccess = move_uploaded_file($_FILES['assignmentFile']['tmp_name'], $targetFile);

                    if ($uploadSuccess) {
                        echo '<div class="assignment">';
                        echo '<p>Assignment successfully uploaded:</p>';
                        echo '<p><a href="' . $targetFile . '" target="_blank">' . basename($_FILES['assignmentFile']['name']) . '</a></p>';
                        echo '</div>';
                    } else {
                        echo '<div class="assignment">';
                        echo '<p>Failed to upload assignment.</p>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
