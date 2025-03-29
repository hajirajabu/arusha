<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$error = $success = "";
$education_level = $institution = $program_category = $program_name = "";
$date_from = $date_to = "";
$upload_error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST["education_level"]) || empty($_POST["institution"]) || 
        empty($_POST["date_from"]) || empty($_POST["program_category"])) {
        $error = "Please fill in all required fields.";
    } else {
        // Sanitize inputs
        $education_level = trim($_POST["education_level"]);
        $institution = trim($_POST["institution"]);
        $program_category = trim($_POST["program_category"]);
        $program_name = trim($_POST["program_name"]);
        $date_from = trim($_POST["date_from"]);
        $date_to = trim($_POST["date_to"]);

        // Handle file upload
        $certificate_path = $original_filename = "";
        if (!empty($_FILES["certificate"]["name"])) {
            $target_dir = "uploads/certificates/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $original_filename = basename($_FILES["certificate"]["name"]);
            $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
            $new_filename = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Validate file
            $max_size = 2 * 1024 * 1024; // 2MB
            $allowed_types = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
            
            if ($_FILES["certificate"]["size"] > $max_size) {
                $upload_error = "File size 2MB limit.";
            } elseif (!in_array(strtolower($file_extension), $allowed_types)) {
                $upload_error = "Only PDF, Word, and image files are allowed.";
            } elseif (move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file)) {
                $certificate_path = $target_file;
            } else {
                $upload_error = "Error uploading file.";
            }
        }

        if (empty($error) && empty($upload_error)) {
            // Insert into database
            $sql = "INSERT INTO academic_qualifications (
                    user_id, education_level, institution_name, 
                    programme_category, programme_name, date_from, 
                    date_to, certificate_file_path, certificate_original_name
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("issssssss",
                    $_SESSION["id"],
                    $education_level,
                    $institution,
                    $program_category,
                    $program_name,
                    $date_from,
                    $date_to,
                    $certificate_path,
                    $original_filename
                );

                if ($stmt->execute()) {
                    // Redirect to prevent form resubmission
                    header("Location: academic.php?success=1");
                    exit;
                } else {
                    $error = "Error saving qualification: " . $conn->error;
                }
                $stmt->close();
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
    }
}

// Show success message after redirect
if (isset($_GET['success'])) {
    $success = "Qualification added successfully!";
}

// Fetch existing qualifications
$qualifications = [];
$stmt = $conn->prepare("SELECT * FROM academic_qualifications WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $qualifications = $result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Qualifications</title>
</head>
<body>
    <h1>Academic Qualifications</h1>
    <a href="homepage.php">← Back to Dashboard</a>

    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    
    <?php if ($upload_error): ?>
        <p style="color: red;"><?= $upload_error ?></p>
    <?php endif; ?>

    <h2>Add New Qualification</h2>
    <form method="post" action="#" enctype="multipart/form-data">
        <div>
            <label>Education Level*:</label>
            <select name="education_level" required>
                <option value="">Select</option>
                <option value="Primary">Primary Education</option>
                <option value="Secondary">Secondary Education</option>
                <option value="Diploma">Diploma</option>
                <option value="Bachelor">Bachelor's Degree</option>
                <option value="Master">Master's Degree</option>
                <option value="PhD">Doctorate (PhD)</option>
            </select>
        </div>

        <div>
            <label>Institution Name*:</label>
            <input type="text" name="institution" required value="<?= htmlspecialchars($institution) ?>">
        </div>

        <div>
            <label>Programme Category*:</label>
            <select name="program_category" required>
                <option value="">Select</option>
                <option value="Science">Science & Technology</option>
                <option value="Arts">Arts & Humanities</option>
                <option value="Business">Business Studies</option>
                <option value="Medical">Medical Sciences</option>
                <option value="Engineering">Engineering</option>
            </select>
        </div>

        <div>
            <label>Programme Name:</label>
            <input type="text" name="program_name" value="<?= htmlspecialchars($program_name) ?>">
        </div>

        <div>
            <label>Start Date*:</label>
            <input type="date" name="date_from" required value="<?= $date_from ?>">
        </div>

        <div>
            <label>End Date:</label>
            <input type="date" name="date_to" value="<?= $date_to ?>">
        </div>

        <div>
            <label>Certificate (optional, max 2MB):</label>
            <input type="file" name="certificate">
        </div>

        <button type="submit">Add Qualification</button>
    </form>

    <h2>Existing Qualifications</h2>
    <?php if (empty($qualifications)): ?>
        <p>No qualifications added yet.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Education Level</th>
                <th>Institution</th>
                <th>Programme</th>
                <th>Duration</th>
                <th>Certificate</th>
            </tr>
            <?php foreach ($qualifications as $q): ?>
            <tr>
                <td><?= htmlspecialchars($q['education_level']) ?></td>
                <td><?= htmlspecialchars($q['institution_name']) ?></td>
                <td>
                    <?= htmlspecialchars($q['programme_category']) ?><br>
                    <?= htmlspecialchars($q['programme_name']) ?>
                </td>
                <td>
                    <?= date('M Y', strtotime($q['date_from'])) ?> - 
                    <?= $q['date_to'] ? date('M Y', strtotime($q['date_to'])) : 'Present' ?>
                </td>
                <td>
                    <?php if ($q['certificate_file_path']): ?>
                        <a href="<?= $q['certificate_file_path'] ?>">View</a>
                    <?php else: ?>
                        None
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>