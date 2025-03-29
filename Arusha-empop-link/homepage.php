<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "db_connection.php"; // Contains database connection details
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>
    
    <h2>Please Complete Your Profile:</h2>
    
    <nav>
        <ul>
            <!-- <?php
            // Check declaration status
            // $declaration_completed = false;
            // $stmt = $conn->prepare("SELECT id FROM declarations WHERE user_id = ?");
            // $stmt->bind_param("i", $_SESSION["id"]);
            // $stmt->execute();
            // $stmt->store_result();
            // if ($stmt->num_rows > 0) {
            //     $declaration_completed = true;
            // }
            // $stmt->close();
            ?> -->
            
            <li>
                <a href="personal_details.php">Personal Details</a> 
                - (<?php echo (has_data($_SESSION["id"], "personal_details")) ? "Completed" : "Pending"; ?>)
            </li>
            <li>
                <a href="academic_qualification.php">Academic Qualifications</a> 
                - (<?php echo (has_data($_SESSION["id"], "academic_qualifications")) ? "Completed" : "Add"; ?>)
            </li>
            <li>
                <a href="work_experience.php">Work Experience</a> 
                - (<?php echo (has_data($_SESSION["id"], "work_experience")) ? "Completed" : "Add"; ?>)
            </li>
            <li>
                <a href="training_workshop.php">Trainings & Workshops</a> 
                - (<?php echo (has_data($_SESSION["id"], "trainings")) ? "Completed" : "Add"; ?>)
            </li>
            <li>
                <a href="referees.php">Referees</a> 
                - (<?php echo (has_data($_SESSION["id"], "referees")) ? "Completed" : "Add"; ?>)
            </li>
            <!-- <li>
                <a href="declaration.php">Declaration</a> 
                - (<?php 
                // echo $declaration_completed ? "Signed" : "Pending Signature";
                 ?>)
            </li> -->
        </ul>
    </nav>

    <p><a href="logout.php">Log Out</a></p>

    <?php
    // Helper function to check if user has data in a table
    function has_data($user_id, $table_name) {
        global $conn;
        $stmt = $conn->prepare("SELECT id FROM $table_name WHERE user_id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $has_data = $stmt->num_rows > 0;
        $stmt->close();
        return $has_data;
    }
    ?>
</body>
</html>