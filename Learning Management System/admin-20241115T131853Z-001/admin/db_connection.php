<?php
// Database configuration
$host = "localhost";
$dbname = "lms";
$username = "root";
$password = "";

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set character encoding for communication between PHP and MySQL
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Display an error message and terminate the script if connection fails
    die("Connection failed: " . $e->getMessage());
}

?>
