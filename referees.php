<?php
session_start();
require_once "db_connection.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$user_id=$_SESSION["id"];
// echo $user_id;
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $institution = $_POST['institution'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];

    $sql = "INSERT INTO referees (user_id, full_name, title, email, institution, address, telephone) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $full_name, $title, $email, $institution, $address, $telephone);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Referee added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error saving referee: " . $stmt->error . "</p>";
    }
}

// Retrieve referees
$sql = "SELECT * FROM referees WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Referees</title>
</head>
<body>
    <h2>Referees</h2>
    <a href="homepage.php">← Back to Dashboard</a>
    <form method="POST">
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>

        <label>Title:</label>
        <input type="text" name="title"><br>

        <label>Email:</label>
        <input type="email" name="email"><br>

        <label>Institution:</label>
        <input type="text" name="institution"><br>

        <label>Address:</label>
        <textarea name="address"></textarea><br>

        <label>Telephone:</label>
        <input type="text" name="telephone"><br>

        <button type="submit">Save Referee</button>
    </form>

    <h3>Referee List</h3>
    <table border="1">
        <tr>
            <th>Full Name</th>
            <th>Title</th>
            <th>Email</th>
            <th>Institution</th>
            <th>Address</th>
            <th>Telephone</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['institution']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['telephone']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
