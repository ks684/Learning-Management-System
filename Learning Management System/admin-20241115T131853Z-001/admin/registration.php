<?php
session_start();
require_once('db_connection.php'); // Include your database connection here

$signup_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $kc_id = $_POST["kc_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform form validation
    if (empty($kc_id)) {
        $signup_errors[] = "KC ID is required.";
    }
    if (empty($name)) {
        $signup_errors[] = "Name is required.";
    }
    if (empty($email)) {
        $signup_errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_errors[] = "Invalid email format.";
    }
    if (empty($mobile)) {
        $signup_errors[] = "Mobile is required.";
    }
    if (empty($username)) {
        $signup_errors[] = "Username is required.";
    }
    if (empty($password)) {
        $signup_errors[] = "Password is required.";
    }

    // If no errors, insert the user into the database
    if (empty($signup_errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO admin (KC_ID, Name, Email, Mobile, Username, Password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$kc_id, $name, $email, $mobile, $username, $hashedPassword]);

            // Redirect to login page after successful registration
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            // Handle database errors
            //$signup_errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Signup</title>
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

        .signup-form {
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the opacity here */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Adjust width as needed */
        }

        .signup-form h2 {
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
        <section class="signup-form">
            <div class="text-center">
                <a href="index.php">
                    <img src="../images/logo.jpg" alt="LMS Logo" height="150px" width="200px">
                </a>
                <h2 class="mb-3">Teacher's Signup</h2>
            </div>
            <?php if (!empty($signup_errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($signup_errors as $signup_error) : ?>
                        <p><?php echo $signup_error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post"> <!-- No need to link to any specific page -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="kc_id" placeholder="KC ID">
                </div>
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
                <button type="submit" class="btn btn-primary btn-block" name="signup">Sign up</button>
            </form>
            <p class="mt-3">Already have an account? <a href="login.php">Sign in</a></p>
        </section>
    </div>
</body>
</html>
