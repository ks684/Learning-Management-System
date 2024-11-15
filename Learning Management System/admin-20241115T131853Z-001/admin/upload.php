<?php
// Include your database connection code here
require_once('db_connection.php');

// Initialize variables
$assignmentId = "";
$assignmentName = "";
$assignmentDescription = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        // Add new assignment
        $assignmentName = $_POST["assignmentName"];
        $assignmentDescription = $_POST["assignmentDescription"];

        // Perform database insertion here
        $sql = "INSERT INTO assignments (name, description) VALUES (:name, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $assignmentName);
        $stmt->bindParam(':description', $assignmentDescription);
        $stmt->execute();
    } elseif (isset($_POST["edit"])) {
        // Edit assignment (populate form fields)
        $assignmentId = $_POST["assignmentId"];

        // Fetch assignment data from the database
        $sql = "SELECT * FROM assignments WHERE assignmentId = :assignmentId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':assignmentId', $assignmentId);
        $stmt->execute();
        $assignmentData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Populate form fields with assignment data
        $assignmentName = $assignmentData['name'];
        $assignmentDescription = $assignmentData['description'];
        
    } elseif (isset($_POST["delete"])) {
        // Delete assignment
        $assignmentId = $_POST["assignmentId"];

        // Perform database deletion here
        $sql = "DELETE FROM assignments WHERE assignmentId = :assignmentId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':assignmentId', $assignmentId);
        $stmt->execute();
    }
}

// Retrieve existing assignments from the database
$sql = "SELECT * FROM assignments";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Management</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Additional custom styles */
        /* Add your custom CSS styling here */
    </style>
</head>
<body>
    <div class="container">
        <h1>Assignment Management</h1>
        <form method="post">
            <div class="mb-3">
                <input type="hidden" name="assignmentId" value="<?php echo $assignmentId; ?>">
                <label for="assignmentName" class="form-label">Assignment Name</label>
                <input type="text" class="form-control" name="assignmentName" value="<?php echo $assignmentName; ?>" required>
            </div>
            <div class="mb-3">
                <label for="assignmentDescription" class="form-label">Assignment Description</label>
                <textarea class="form-control" name="assignmentDescription" rows="3"><?php echo $assignmentDescription; ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="add">Add Assignment</button>
                <button type="submit" class="btn btn-success" name="update">Update Assignment</button>
                <button type="submit" class="btn btn-danger" name="delete">Reset</button>
            </div>
        </form>

        <!-- Display existing assignments in a table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignments as $assignment) : ?>
                    <tr>
                        <td><?php echo $assignment['assignmentId']; ?></td>
                        <td><?php echo $assignment['name']; ?></td>
                        <td><?php echo $assignment['description']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="assignmentId" value="<?php echo $assignment['assignmentId']; ?>">
                                <button type="submit" class="btn btn-sm btn-warning" name="edit">Edit</button>
                                <button type="submit" class="btn btn-sm btn-danger" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><br>
        <h3><a href="dashboard.php">Back to dashboard</a></h3>
    </div>
    
</body>
</html>
