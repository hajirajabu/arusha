<?php
session_start();
require 'db_connection.php'; // Include your database connection

$user_id=$_SESSION["id"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'] ?? null;
    $institution = $_POST['institution'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $certificate_filename = null;

    // Handle file upload (optional)
    if (!empty($_FILES['certificate']['name'])) {
        $upload_dir = "uploads/"; // Ensure this folder exists
        $certificate_filename = time() . "_" . basename($_FILES["certificate"]["name"]);
        $file_path = $upload_dir . $certificate_filename;

        if (!move_uploaded_file($_FILES["certificate"]["tmp_name"], $file_path)) {
            $certificate_filename = null; // Reset if upload fails
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO trainings (user_id, name, description, institution, start_date, end_date, certificate_filename) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $name, $description, $institution, $start_date, $end_date, $certificate_filename);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Training/workshop added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Retrieve training/workshop records
$query = "SELECT * FROM trainings WHERE user_id = ? ORDER BY start_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training/Workshop Records</title>
</head>
<body>

<h2>Add Training/Workshop</h2>
<a href="homepage.php">← Back to Dashboard</a>
<form action="" method="post" enctype="multipart/form-data">
    <label>Training/Workshop Name:</label>
    <input type="text" name="name" required><br>

    <label>Description:</label>
    <textarea name="description"></textarea><br>

    <label>Institution/Organization:</label>
    <input type="text" name="institution" required><br>

    <label>Start Date:</label>
    <input type="date" name="start_date" required><br>

    <label>End Date:</label>
    <input type="date" name="end_date" required><br>

    <label>Upload Certificate (Optional):</label>
    <input type="file" name="certificate"><br>

    <input type="submit" value="Submit">
</form>

<h2>Training/Workshop History</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Institution</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Certificate</th>
    </tr>
    <?php while ($training = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($training['name']) ?></td>
            <td><?= htmlspecialchars($training['description'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($training['institution']) ?></td>
            <td><?= htmlspecialchars($training['start_date']) ?></td>
            <td><?= htmlspecialchars($training['end_date']) ?></td>
            <td>
                <?php if (!empty($training['certificate_filename'])): ?>
                    <a href="uploads/<?= htmlspecialchars($training['certificate_filename']) ?>" target="_blank">Download Certificate</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
