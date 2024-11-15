<?php
session_start();

// Define the correct admin password (you should securely store this)
$correctPassword = 'your_admin_password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredPassword = $_POST['password'];

    // Check if the entered password matches the correct password
    if ($enteredPassword === '12345') {
        // Password is correct, set a session variable to indicate admin login
        $_SESSION['admin1'] = true;

        // Redirect to the admin dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Password is incorrect, display an error message
        echo "Invalid password. Please try again.";
    }
}
?>
