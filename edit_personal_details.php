<?php
session_start();
include 'db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$userid = $_SESSION["id"];

// Fetch user details
$sql = "SELECT marital_status, government_employment_status, disability, contacts, current_region, current_district, zip_code, passport_image FROM personal_details WHERE user_id = ?";
$stmt = $conn->prepare($sql);

// Check if prepare() failed
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();

// Initialize values
$marital_status = $userData['marital_status'] ?? '';
$employment_status = $userData['government_employment_status'] ?? '';
$disability = $userData['disability'] ?? '';
$contacts = $userData['contacts'] ?? '';
$current_region = $userData['current_region'] ?? '';
$current_district = $userData['current_district'] ?? '';
$zip_code = $userData['zip_code'] ?? '';
$passport_image = $userData['passport_image'] ?? '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marital_status = $_POST['marital_status'];
    $employment_status = $_POST['government_employment_status'];
    $disability = $_POST['disability'];
    $contacts = $_POST['contacts'];
    $current_region = $_POST['current_region'];
    $current_district = $_POST['current_district'];
    $zip_code = $_POST['zip_code'];

    // Handle passport image upload (if a new image is uploaded)
    if (!empty($_FILES['passport_image']['name'])) {
        $target_dir = "uploads/passports/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $passport_image = $target_dir . "passport_" . time() . "_" . basename($_FILES["passport_image"]["name"]);
        move_uploaded_file($_FILES["passport_image"]["tmp_name"], $passport_image);
    }

    // Update query
    $sql = "UPDATE personal_details SET 
        marital_status=?, government_employment_status=?, disability=?, contacts=?, 
        current_region=?, current_district=?, zip_code=?, passport_image=?, updated_at=NOW() 
        WHERE user_id=?";

    $stmt = $conn->prepare($sql);

    // Check if prepare() failed
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssssssi", 
        $marital_status, $employment_status, $disability, $contacts, 
        $current_region, $current_district, $zip_code, $passport_image, $userid
    );

    if ($stmt->execute()) {
        echo "Details updated successfully!";
        header("refresh:2; url=personal_details.php");
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Personal Details</title>
</head>
<body>
    <h2>Edit Your Details</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label>Marital Status:</label>
        <input type="text" name="marital_status" value="<?php echo htmlspecialchars($marital_status); ?>"><br>

        <label>Government Employment Status:</label>
        <input type="text" name="government_employment_status" value="<?php echo htmlspecialchars($employment_status); ?>"><br>

        <label>Disability:</label>
        <input type="text" name="disability" value="<?php echo htmlspecialchars($disability); ?>"><br>

        <label>Contacts:</label>
        <input type="text" name="contacts" value="<?php echo htmlspecialchars($contacts); ?>"><br>

        <label>Current Region:</label>
        <input type="text" name="current_region" value="<?php echo htmlspecialchars($current_region); ?>"><br>

        <label>Current District:</label>
        <input type="text" name="current_district" value="<?php echo htmlspecialchars($current_district); ?>"><br>

        <label>ZIP Code:</label>
        <input type="text" name="zip_code" value="<?php echo htmlspecialchars($zip_code); ?>"><br>

        <label>Passport Image:</label>
        <input type="file" name="passport_image"><br>
        <?php if (!empty($passport_image)) { ?>
            <img src="<?php echo htmlspecialchars($passport_image); ?>" width="100" alt="Passport Image"><br>
        <?php } ?>

        <input type="submit" value="Update">
    </form>
</body>
</html>
