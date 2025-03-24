<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: update-accountSettings.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = null; // update user-specific data


// Fetch user data from the database
$stmt = $conn->prepare("SELECT user_id, email_address, phone_number, profile_photo FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
} else {
    echo "User not found.";
    exit();
}

$stmt->close();

// Handle profile update (Full Name, Email, Phone, Username)
if (isset($_POST['fullname'], $_POST['email'], $_POST['phone'], $_POST['username'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $username_new = mysqli_real_escape_string($conn, $_POST['username']);

    // update profile info in the database
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email_address = ?, phone_number = ?, username = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $fullname, $email, $phone, $username_new, $user_id);
    
    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}


?>