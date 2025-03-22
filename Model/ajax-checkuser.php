<!--  
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: ajax-checkuser.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in."]);
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Prepare query to fetch user info
$stmt = $conn->prepare("SELECT first_name, last_name, email, profile_picture FROM users WHERE user_id = ?");
if ($stmt === false) {
    echo json_encode(["error" => "Failed to prepare statement."]);
    exit();
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user was found
if ($result->num_rows > 0) {
    // Fetch data
    $user = $result->fetch_assoc();

    // Return data as JSON object
    echo json_encode($user);
} else {
    echo json_encode(["error" => "User not found."]);
}

// Close connection
$stmt->close();
$conn->close();
?>
