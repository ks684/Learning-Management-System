<?php
session_start();
require_once('db_connection.php'); // Include your database connection here


$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform form validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        // Retrieve user data from the database based on the username
        $query = "SELECT * FROM user WHERE Username = :username"; // Use the correct column name
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);



        if ($user && isset($user['Password']) && password_verify($password, $user['Password'])) {
            $_SESSION['user'] = $username; // Store user session
            header("Location: dashboard.php"); // Redirect to user dashboard
            exit();
        } else {
            $errors[] = "Invalid username or password.";
        }
    }
}
?>

<!-- Your HTML and form code here -->




<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('../images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the opacity here */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Adjust width as needed */
        }

        .login-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            display: flex;
            justify-content: center; /* Center the button horizontally */
            align-items: center; /* Center the button vertically */
            width: 100%; /* Take up the full width of the container */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="login-form">
            <div class="text-center">
                <a href="index.php">
                    <img src="../images/logo.jpg" alt="LMS Logo" height="150px" width="200px">
                </a>
                <h2 class="mb-3">User Login</h2>
            </div>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post"> <!-- No need to link to dashboard.php -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Sign in</button>
            </form>
            <p class="mt-3">Don't have an account? <a href="registration.php">Sign up</a></p>
        </section>
    </div>
</body>
</html>
