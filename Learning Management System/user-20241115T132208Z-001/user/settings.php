<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection here
require_once('db_connection.php');

// Get user's username from the session
$username = $_SESSION['user'];

// Initialize variables to store user information and errors
$user_name = '';
$user_email = '';
$updateError = '';
$passwordChangeError = '';

// Fetch user's current information from the database
$query = "SELECT Name, Email FROM user WHERE Username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_name = $user['Name'];
    $user_email = $user['Email'];
} else {
    // Handle the case where the user is not found in the database
    header("Location: login.php");
    exit();
}

// Check if the password change form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    // Retrieve and sanitize user input
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate and check the current password (you should implement proper password hashing)
    $query = "SELECT Password FROM user WHERE Username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $userPassword = $stmt->fetchColumn();

    if (password_verify($currentPassword, $userPassword)) {
        // Check if the new password and confirmation match
        if ($newPassword === $confirmPassword) {
            // Hash the new password before updating it in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $updateQuery = "UPDATE user SET Password = :password WHERE Username = :username";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->bindValue(':password', $hashedPassword);
            $updateStmt->bindValue(':username', $username);

            if ($updateStmt->execute()) {
                // Password updated successfully
                // You can redirect or display a success message here
            } else {
                $passwordChangeError = 'Error updating password.';
            }
        } else {
            $passwordChangeError = 'New password and confirmation do not match.';
        }
    } else {
        $passwordChangeError = 'Current password is incorrect.';
    }
}

// Check if the profile update form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Retrieve and sanitize user input
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];

    // Validate the new name and email (you can add more validation)
    if (empty($newName) || empty($newEmail)) {
        $updateError = 'Please fill in all fields.';
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $updateError = 'Invalid email format.';
    } else {
        // Update user's information in the database
        $updateQuery = "UPDATE user SET Name = :newName, Email = :newEmail WHERE Username = :username";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindValue(':newName', $newName);
        $updateStmt->bindValue(':newEmail', $newEmail);
        $updateStmt->bindValue(':username', $username);

        if ($updateStmt->execute()) {
            // User information updated successfully
            $user_name = $newName;
            $user_email = $newEmail;
            // You can also display a success message here if needed
        } else {
            $updateError = 'Error updating user information.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Settings</title>
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
            padding: 100px;
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
            margin-bottom: 5px;
        }

        p {
            color: #555;
        }

        .email{
            color:#f1f1f1
        }

        .form-group {
            margin-bottom: 5px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .btn-primary {
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #1a2633;
        }

        .alert {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Additional custom styles here */
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
            <h2>User Settings</h2>
            <!-- Display update error message, if any -->
            <?php
            if (!empty($updateError)) {
                echo '<div class="alert">' . $updateError . '</div>';
            }
            ?>
            <!-- Profile Update Form -->
            <form method="POST">
                <div class="form-group">
                    <label for="new_name">Name:</label>
                    <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo $user_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_email">Email:</label>
                    <input type="email" class="form-control" id="new_email" name="new_email" value="<?php echo $user_email; ?>" required>
                </div>
                <button type="submit" class="btn-primary" name="update_profile">Update Profile</button>
            </form>
            <!-- Password Change Form -->
            <form method="POST">
                <h3><br>Change Password</h3>
                <!-- Display password change error message, if any -->
                <?php
                if (!empty($passwordChangeError)) {
                    echo '<div class="alert">' . $passwordChangeError . '</div>';
                }
                ?>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn-primary" name="change_password">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>
