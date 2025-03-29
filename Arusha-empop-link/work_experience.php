<?php
session_start();
require 'db_connection.php'; // Include your database connection

$user_id = $_SESSION['user_id'] ?? 1; // Change this based on your authentication system

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $institution = $_POST['institution'];
    $job_title = $_POST['job_title'];
    $supervisor_name = $_POST['supervisor_name'] ?? null;
    $supervisor_phone = $_POST['supervisor_phone'] ?? null;
    $supervisor_address = $_POST['supervisor_address'] ?? null;
    $institution_address = $_POST['institution_address'] ?? null;
    $duties = $_POST['duties'] ?? null;
    $start_date = $_POST['start_date'];
    $is_current_job = isset($_POST['is_current_job']) ? 1 : 0;
    $end_date = $_POST['end_date'] ?? null;
    $file_path = null;

    // Handle file upload
    if (!empty($_FILES['file']['name'])) {
        $upload_dir = "uploads/"; // Ensure this folder exists
        $file_name = time() . "_" . basename($_FILES["file"]["name"]);
        $file_path = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
            $file_path = null; // Reset if upload fails
        }
    }

    // Insert into database
    $sql = "INSERT INTO work_experience 
            (user_id, institution_organization, job_title, supervisor_name, supervisor_telephone, 
            supervisor_address, institution_address, duties_responsibilities, start_date, is_current_job, end_date, file_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssis", $user_id, $institution, $job_title, $supervisor_name, $supervisor_phone, 
        $supervisor_address, $institution_address, $duties, $start_date, $is_current_job, $end_date, $file_path);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Work experience added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Retrieve work experience records
$query = "SELECT * FROM work_experience WHERE user_id = ? ORDER BY start_date DESC";
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
    <title>Work Experience</title>
</head>
<body>

<h2>Add Work Experience</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label>Institution/Organization:</label>
    <input type="text" name="institution" required><br>

    <label>Job Title:</label>
    <input type="text" name="job_title" required><br>

    <label>Supervisor Name:</label>
    <input type="text" name="supervisor_name"><br>

    <label>Supervisor Phone:</label>
    <input type="text" name="supervisor_phone"><br>

    <label>Supervisor Address:</label>
    <textarea name="supervisor_address"></textarea><br>

    <label>Institution Address:</label>
    <textarea name="institution_address"></textarea><br>

    <label>Duties & Responsibilities:</label>
    <textarea name="duties"></textarea><br>

    <label>Start Date:</label>
    <input type="date" name="start_date" required><br>

    <label>Current Job?</label>
    <input type="checkbox" name="is_current_job" value="1"><br>

    <label>End Date:</label>
    <input type="date" name="end_date"><br>

    <label>Upload Supporting Document (Optional):</label>
    <input type="file" name="file"><br>

    <input type="submit" value="Submit">
</form>

<h2>Work Experience History</h2>
<table border="1">
    <tr>
        <th>Institution</th>
        <th>Job Title</th>
        <th>Supervisor</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Supporting Document</th>
    </tr>
    <?php while ($exp = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($exp['institution_organization']) ?></td>
            <td><?= htmlspecialchars($exp['job_title']) ?></td>
            <td><?= htmlspecialchars($exp['supervisor_name'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($exp['start_date']) ?></td>
            <td><?= $exp['is_current_job'] ? 'Present' : htmlspecialchars($exp['end_date'] ?? 'N/A') ?></td>
            <td>
                <?php if (!empty($exp['file_path'])): ?>
                    <a href="<?= htmlspecialchars($exp['file_path']) ?>" target="_blank">Download</a>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
