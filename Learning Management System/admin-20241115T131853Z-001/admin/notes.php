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

<!DOCTYPE html>
<html>
<head>
    <title>Notes</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            padding: 20px;
        }

        .dashboard-container {
            display: flex;
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

        .semester-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .semester {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        }

        .semester h3 {
            margin-top: 0;
        }

        .subject-list {
            list-style: none;
            padding: 0;
        }

        .subject-list li {
            margin-bottom: 10px;
        }

        .subject-list a {
            color: #333;
            text-decoration: none;
        }

        .subject-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <!-- Dashboard navigation content -->
            <h3>Welcome Admin</h3>
            <div class="nav-item">
                <a href="dashboard.php"><input type="button"name="d"value="Dashboard"></a>
            </div>
            <div class="nav-item">
                <a href="notes.php"><input type="button"name="d"value="Notes"></a>
            </div>
            <div class="nav-item">
                <a href="students.php"><input type="button"name="d"value="List of Students"></a>
            </div>
            <div class="nav-item">
                <a href="logout.php"><input type="button"name="d"value="Sign out"></a>
            </div>
        </div>
        <div class="main-content">
            <!-- Notes section content -->
            <h2>Notes</h2>
            <div class="semester-list">
                <?php
                // Simulated semester and subject data
                $semesters = [
                    ['semester' => 'Semester 1', 'subjects' => [
                        'Operating System' => 'https://drive.google.com/drive/folders/12hjxJIEfz5ezVSOQq7teBjymXXCeuCnu?usp=sharing',
                        'Object Oriented Programming with C++' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                        'Digital Electronics' => 'https://drive.google.com/drive/folders/1iQxjSfsAgjc8-dUf04rSo1ShCgLwLwdX?usp=sharing',
                        'Mathematics 1' => 'https://drive.google.com/drive/folders/1L28e_6kdiLpH4P7FdGsyisEvMAbg3B1-?usp=sharing',
                        'Professional Communication Skills' => 'https://drive.google.com/drive/folders/1zRreKt3aX2CTcMUSTQpzUMj5wZwAlFAa?usp=sharing'
                    ]],
                    ['semester' => 'Semester 2', 'subjects' => [
                    'Python Programming' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Mathematics 2' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Microprocessor Architecture and Interfacing'=> 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing', 
                    'Introduction To Unity and Graphics'=> 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Green Computing'=> 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing'
                    ]],
                    ['semester' => 'Semester 3', 'subjects' => [
                    'Web Programming' => 'https://drive.google.com/drive/folders/1yO2TEu2rbp28QFJbkcyIjbptd1Il4TeS?usp=sharing', 
                    'Android Programming' => 'https://drive.google.com/drive/folders/1m0wFkPLLS7D82qWFePp7GZiF_gXpOXF1?usp=sharing', 
                    'Applied Mathematics' => 'https://drive.google.com/drive/folders/1K4jPfvoylBm4ZseAAUC708v-ZUg9DHQt?usp=sharing',
                    'Software Engineering' => 'https://drive.google.com/drive/folders/1yx2mLb6yq3EsGPiCUkchR-87nkmzIJ2v?usp=sharing', 
                    'Database Management System'  => 'https://drive.google.com/drive/folders/1jsRV51yd4ClTkbcE2krRrSd1yQlyIDQJ?usp=sharing'
                    ]],
                    ['semester' => 'Semester 4', 'subjects' => [
                    'Data Structure And Analysis' => 'https://drive.google.com/drive/folders/1hur2GXuXWPG99brmLV8OnCc9KGdj2fyJ?usp=sharing',
                    'Data Communication And Networking' => 'https://drive.google.com/drive/folders/1Vf1VpJlnR1KTunX5E_dwUg4LlQNmjkOh?usp=sharing', 
                    'Software testing and quality assurance' => 'https://drive.google.com/drive/folders/1LUFFWNbwKqeqi9BUwmg68XLaQKdrk5oR?usp=sharing',
                    '(Dot).Net Technologies' => 'https://drive.google.com/drive/folders/1U3c_kE43ucA91Kkt9sJoIcv7OCRN5DE2?usp=sharing',
                    'Core Java' => 'https://drive.google.com/drive/folders/1lONbZVL7GDvdLemTBCnQfcJW2UDj3MG8?usp=sharing'
                    ]],
                    ['semester' => 'Semester 5', 'subjects' => [
                    'Software Project Management' => 'https://drive.google.com/drive/folders/12w0i6EioglOYhYnBgAFh8-V3V9RIB5cj?usp=sharing',
                    'Embedded System with IoT' => 'https://drive.google.com/drive/folders/1IV3JUwesTjR8nzIQpmm9ZnXiw6okIW7P?usp=sharing',
                    'Enterprise Networking' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Virtual Reality' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing', 
                    'Enterprise Java' => 'https://drive.google.com/drive/folders/1UI9nwHqjF5Ysij6bF6iinAsT8bfZnfTo?usp=sharing'
                    ]],
                    ['semester' => 'Semester 6', 'subjects' => [
                    'Cryptography & Network Security' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing', 
                    'Data mining & Business Intelligence' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Cyber Laws, Compliance & Frameworks' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'DevOps' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing',
                    'Virtualization Concepts & Applications' => 'https://drive.google.com/drive/folders/1HjM36vxiasxQe2lBGZcZDIq_jwnwDLqh?usp=sharing'
                    ]],
                ];

                foreach ($semesters as $semester) {
                    echo '<div class="semester">';
                    echo '<h3>' . $semester['semester'] . '</h3>';
                    echo '<ul class="subject-list">';
                    foreach ($semester['subjects'] as $subject => $link) {
                        echo '<li><a href="' . $link . '" target="_blank">' . $subject . ' Notes</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
