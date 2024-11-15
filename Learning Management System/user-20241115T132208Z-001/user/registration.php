<?php
session_start();
require_once('db_connection.php'); // Include your database connection here

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform form validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($mobile)) {
        $errors[] = "Mobile is required.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If no errors, insert the user into the database
    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO user (name, email, mobile, username, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $mobile, $username, $hashedPassword]);

            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            //$errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
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

        .registration-form {
            background-color: rgba(173, 216, 230, 0.7); /* Adjust the opacity here */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Adjust width as needed */
        }

        .registration-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="registration-form">
            <div class="text-center">
                <a href="index.php">
                    <img src="../images/logo.jpg" alt="LMS Logo" height="150px" width="200px">
                </a>
                <h2 class="mb-3">User Registration</h2>
            </div>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error) : ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Name">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="mobile" placeholder="Mobile">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            </form>
            <p class="mt-3">Already have an account? <a href="login.php">Sign in</a></p>
        </section>
    </div>
</body>
</html>
