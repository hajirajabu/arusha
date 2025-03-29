<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Initialize variables
$full_name = $gender = $dob = $birth_region = $birth_district = $originality = "";
$marital_status = $govt_employment = $disability = $country = $contacts = "";
$current_region = $current_district = $zip_code = "";
$error = "";

// Get existing data if available
$stmt = $conn->prepare("SELECT * FROM personal_details WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    // Populate variables from database
    $full_name = $data['full_name'];
    $gender = $data['gender'];
    $dob = $data['date_of_birth'];
    $birth_region = $data['region_of_birth'];
    $birth_district = $data['district_of_birth'];
    $originality = $data['originality'];
    $marital_status = $data['marital_status'];
    $govt_employment = $data['government_employment_status'];
    $disability = $data['disability'];
    $country = $data['country'];
    $contacts = $data['contacts'];
    $current_region = $data['current_region'];
    $current_district = $data['current_district'];
    $zip_code = $data['zip_code'];
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $full_name = trim($_POST["full_name"]);
    $gender = trim($_POST["gender"]);
    $dob = trim($_POST["dob"]);
    $birth_region = trim($_POST["birth_region"]);
    $birth_district = trim($_POST["birth_district"]);
    $originality = trim($_POST["originality"]);
    $marital_status = trim($_POST["marital_status"]);
    $govt_employment = trim($_POST["govt_employment"]);
    $disability = trim($_POST["disability"]);
    $country = trim($_POST["country"]);
    $contacts = trim($_POST["contacts"]);
    $current_region = trim($_POST["current_region"]);
    $current_district = trim($_POST["current_district"]);
    $zip_code = trim($_POST["zip_code"]);

    // Validate required fields
    if (empty($full_name)) {
        $error = "Full name is required.";
    } elseif (empty($dob)) {
        $error = "Date of birth is required.";
    } elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dob)) {
        $error = "Invalid date format (YYYY-MM-DD).";
    } else {
        // Prepare insert/update statement
        $sql = "INSERT INTO personal_details (
                user_id, full_name, gender, date_of_birth, 
                region_of_birth, district_of_birth, originality, 
                marital_status, government_employment_status, 
                disability, country, contacts, current_region, 
                current_district, zip_code
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                full_name = VALUES(full_name),
                gender = VALUES(gender),
                date_of_birth = VALUES(date_of_birth),
                region_of_birth = VALUES(region_of_birth),
                district_of_birth = VALUES(district_of_birth),
                originality = VALUES(originality),
                marital_status = VALUES(marital_status),
                government_employment_status = VALUES(government_employment_status),
                disability = VALUES(disability),
                country = VALUES(country),
                contacts = VALUES(contacts),
                current_region = VALUES(current_region),
                current_district = VALUES(current_district),
                zip_code = VALUES(zip_code)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issssssssssssss",
                $_SESSION["id"],
                $full_name,
                $gender,
                $dob,
                $birth_region,
                $birth_district,
                $originality,
                $marital_status,
                $govt_employment,
                $disability,
                $country,
                $contacts,
                $current_region,
                $current_district,
                $zip_code
            );

            if ($stmt->execute()) {
                header("location: personal_details.php?success=1");
                exit;
            } else {
                $error = "Error saving details. Please try again.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personal Details</title>
</head>
<body>
    <h1>Personal Details</h1>
    <a href="home.php">Back to Dashboard</a>
    
    <?php if (isset($_GET['success'])): ?>
        <p style="color:green">Details saved successfully!</p>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
        <p style="color:red"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post">
        <!-- Personal Information -->
        <fieldset>
            <legend>Basic Information</legend>
            
            <label>Full Name*:</label>
            <input type="text" name="full_name" required value="<?php echo htmlspecialchars($full_name); ?>">
            
            <label>Gender:</label>
            <select name="gender">
                <option value="">Select</option>
                <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>
            
            <label>Date of Birth*:</label>
            <input type="date" name="dob" required value="<?php echo htmlspecialchars($dob); ?>">
        </fieldset>

        <!-- Birth Information -->
        <fieldset>
            <legend>Place of Birth</legend>
            
            <label>Country:</label>
            <input type="text" name="country" value="<?php echo htmlspecialchars($country); ?>">
            
            <label>Region of Birth:</label>
            <input type="text" name="birth_region" value="<?php echo htmlspecialchars($birth_region); ?>">
            
            <label>District of Birth:</label>
            <input type="text" name="birth_district" value="<?php echo htmlspecialchars($birth_district); ?>">
        </fieldset>

        <!-- Current Residence -->
        <fieldset>
            <legend>Current Address</legend>
            
            <label>Region:</label>
            <input type="text" name="current_region" value="<?php echo htmlspecialchars($current_region); ?>">
            
            <label>District:</label>
            <input type="text" name="current_district" value="<?php echo htmlspecialchars($current_district); ?>">
            
            <label>Zip Code:</label>
            <input type="text" name="zip_code" value="<?php echo htmlspecialchars($zip_code); ?>">
        </fieldset>

        <!-- Additional Information -->
        <fieldset>
            <legend>Other Details</legend>
            
            <label>Marital Status:</label>
            <select name="marital_status">
                <option value="">Select</option>
                <option value="Single" <?php echo ($marital_status == 'Single') ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo ($marital_status == 'Married') ? 'selected' : ''; ?>>Married</option>
                <option value="Divorced" <?php echo ($marital_status == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
            </select>
            
            <label>Government Employment:</label>
            <select name="govt_employment">
                <option value="">Select</option>
                <option value="Yes" <?php echo ($govt_employment == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo ($govt_employment == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            
            <label>Disability:</label>
            <input type="text" name="disability" value="<?php echo htmlspecialchars($disability); ?>">
            
            <label>Contact Number:</label>
            <input type="tel" name="contacts" value="<?php echo htmlspecialchars($contacts); ?>">
        </fieldset>

        <button type="submit">Save Details</button>
    </form>
</body>
</html>