<!DOCTYPE html>
<html>
<head>
    <title>Learning Management System</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <?php
    if (isset($adminPage)) {
        echo '<link rel="stylesheet" type="text/css" href="../css/admin-styles.css">';
    } else {
        echo '<link rel="stylesheet" type="text/css" href="../css/user-styles.css">';
    }
    ?>
</head>
<body>
    <div class="container">
        <header>
            <img src="images\logo.jpg" alt="LMSLogo" _blank="index.php"><b><h2>Learning Management System</h2></b>
            <nav>
                <ul>
                    <li><h4><a href="user/login.php">Student</a></h4></li>
                    <li><h4><a href="admin/login.php">Teacher</a></h4></li>
                    <li><h4><a href="about.php">About Us</a></h4></li>
                </ul>
            </nav>
        </header>
</body>
</html>
