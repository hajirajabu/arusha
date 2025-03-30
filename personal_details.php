<?php
session_start(); // Start the session
include 'db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$userid = $_SESSION["id"]; // Get the logged-in user's ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $country = $_POST['country'];
    $region_of_birth = $_POST['region_of_birth'];
    $district_of_birth = $_POST['district_of_birth'];
    $marital_status = $_POST['marital_status'];
    $government_employment_status = $_POST['government_employment_status'];
    $disability = $_POST['disability'];
    $contacts = $_POST['contacts'];
    $current_region = $_POST['current_region'];
    $current_district = $_POST['current_district'];
    $zip_code = $_POST['zip_code'];

    // Handle file upload
    $passport_image = NULL;
    if (!empty($_FILES['passport_image']['name'])) {
        $target_dir = "uploads/passports/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create folder if not exists
        }
        $passport_image = $target_dir . "passport_" . time() . "_" . basename($_FILES["passport_image"]["name"]);
        move_uploaded_file($_FILES["passport_image"]["tmp_name"], $passport_image);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO personal_details (
        user_id, full_name, gender, date_of_birth, 
        country, region_of_birth, district_of_birth, marital_status, 
        government_employment_status, disability, contacts, current_region, current_district, 
        zip_code, passport_image, created_at, updated_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

    $stmt->bind_param("issssssssssssss", 
        $userid, $full_name, $gender, $date_of_birth, $country, 
        $region_of_birth, $district_of_birth, $marital_status, 
        $government_employment_status, $disability, $contacts, $current_region, 
        $current_district, $zip_code, $passport_image
    );

    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


// Check if user details already exist
$sql = "SELECT * FROM personal_details WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Personal Details</title>
</head>
<body>
  <h2>Personal Details</h2>
  <a href="homepage.php">← Back to Dashboard</a>
  <?php if ($userData) : ?>
    <!-- Display the data in a table if details exist -->
    <table border="1">
      <tr>
        <th>Full Name</th>
        <td><?php echo htmlspecialchars($userData['full_name']); ?></td>
      </tr>
      <tr>
        <th>Gender</th>
        <td><?php echo htmlspecialchars($userData['gender']); ?></td>
      </tr>
      <tr>
        <th>Date of Birth</th>
        <td><?php echo htmlspecialchars($userData['date_of_birth']); ?></td>
      </tr>
      <tr>
        <th>Country</th>
        <td><?php echo htmlspecialchars($userData['country']); ?></td>
      </tr>
      <tr>
        <th>Region of Birth</th>
        <td><?php echo htmlspecialchars($userData['region_of_birth']); ?></td>
      </tr>
      <tr>
        <th>District of Birth</th>
        <td><?php echo htmlspecialchars($userData['district_of_birth']); ?></td>
      </tr>
      <tr>
        <th>Marital Status</th>
        <td><?php echo htmlspecialchars($userData['marital_status']); ?></td>
      </tr>
      <tr>
        <th>Government Employment Status</th>
        <td><?php echo htmlspecialchars($userData['government_employment_status']); ?></td>
      </tr>
      <tr>
        <th>Disability</th>
        <td><?php echo htmlspecialchars($userData['disability']); ?></td>
      </tr>
      <tr>
        <th>Contacts</th>
        <td><?php echo htmlspecialchars($userData['contacts']); ?></td>
      </tr>
      <tr>
        <th>Current Region</th>
        <td><?php echo htmlspecialchars($userData['current_region']); ?></td>
      </tr>
      <tr>
        <th>Current District</th>
        <td><?php echo htmlspecialchars($userData['current_district']); ?></td>
      </tr>
      <tr>
        <th>Zip Code</th>
        <td><?php echo htmlspecialchars($userData['zip_code']); ?></td>
      </tr>
      <tr>
        <th>Passport Image</th>
        <td>
          <?php if (!empty($userData['passport_image'])) : ?>
            <img src="<?php echo htmlspecialchars($userData['passport_image']); ?>" width="100">
          <?php else : ?>
            No Image
          <?php endif; ?>
        </td>
      </tr>
    </table>
    <br>
    <a href="edit_personal_details.php">Edit Details</a>
    <br><br>
    <a href="logout.php">Logout</a>

  <?php else : ?>
    <!-- No details found: display the insert form -->
    <h3>Insert Your Personal Details</h3>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>! Please enter your details below.</p>
    <form action="personal_details.php" method="POST" enctype="multipart/form-data">
      <label>Full Name:</label>
      <input type="text" name="full_name" required><br><br>

      <label>Gender:</label>
      <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select><br><br>

      <label>Date of Birth:</label>
      <input type="date" name="date_of_birth" required><br><br>

      <label>Country:</label>
      <input type="text" name="country" required><br><br>

      <label>Region of Birth:</label>
      <input type="text" name="region_of_birth" required><br><br>

      <label>District of Birth:</label>
      <input type="text" name="district_of_birth" required><br><br>

      <label>Marital Status:</label>
      <select name="marital_status">
        <option value="Single">Single</option>
        <option value="Married">Married</option>
      </select><br><br>

      <label>Government Employment Status:</label>
      <input type="text" name="government_employment_status"><br><br>

      <label>Disability:</label>
      <input type="text" name="disability"><br><br>

      <label>Contacts:</label>
      <input type="text" name="contacts" required><br><br>

      <label>Current Region:</label>
      <input type="text" name="current_region" required><br><br>

      <label>Current District:</label>
      <input type="text" name="current_district" required><br><br>

      <label>Zip Code:</label>
      <input type="text" name="zip_code"><br><br>

      <label>Passport Image:</label>
      <input type="file" name="passport_image"><br><br>

      <button type="submit" name="submit">Submit</button>
    </form>
    <br>
    <a href="logout.php">Logout</a>
  <?php endif; ?>
</body>
</html>
