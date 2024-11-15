<?php
session_start();
if (!isset($_SESSION['admin1'])) {
    header("Location: login.php"); // Redirect to admin login page if not logged in
    exit();
}

// Include your database connection
require_once('db_connection.php');

// Retrieve a list of registered users
$query = "SELECT * FROM admin";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pagination variables
$recordsPerPage = 10; // Number of records to display per page
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $recordsPerPage);

// Get the current page from the URL, default to page 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start = ($currentPage - 1) * $recordsPerPage;

// Slice the array to display only the records for the current page
$usersOnPage = array_slice($users, $start, $recordsPerPage);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Registered Users</title>
    <!-- Include Bootstrap CSS from CDN or your local setup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>List of Registered Teachers</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersOnPage as $user) : ?>
                    <tr>
                        <td><?php echo $user['KC_ID']; ?></td>
                        <td><?php echo $user['Name']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo $user['Username']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination links -->
        <ul class="pagination">
            <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>
        </ul>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
