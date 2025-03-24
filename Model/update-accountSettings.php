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

ini_set('display_errors', 1);
error_reporting(E_ALL); 

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
$stmt = $conn->prepare("SELECT user_id, first_name, last_name, email_address, phone_number, profile_photo FROM users WHERE username = ?");
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

// Prepare an array to hold updated data
$updatedFields = [];

// Handle profile update (Full Name, Email, Phone, Username)
if (isset($_POST['first_name'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $updatedFields['first_name'] = $first_name;
}

if (isset($_POST['last_name'])) {
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $updatedFields['last_name'] = $last_name;
}

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Check if the new email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email_address = ? AND user_id != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists. Please choose another.";
        exit();
    }

    $updatedFields['email_address'] = $email;
}

if (isset($_POST['phone'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $updatedFields['phone_number'] = $phone;
}

if (isset($_POST['username'])) {
    $username_new = mysqli_real_escape_string($conn, $_POST['username']);
    // Check if the new username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_id != ?");
    $stmt->bind_param("si", $username_new, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another.";
        exit();
    }

    $updatedFields['username'] = $username_new;
}

// Handle password update (Current Password, New Password)
if (isset($_POST['current-password'], $_POST['new-password'], $_POST['confirm-password'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current-password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new-password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    // Check current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        if (password_verify($current_password, $user_data['password'])) {
            if ($new_password === $confirm_password) {
                // hash new password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updatedFields['password'] = $hashed_new_password;
            } else {
                echo "New passwords do not match.";
                exit();
            }
        } else {
            echo "Current password is incorrect.";
            exit();
        }
    }

    // If there are any fields to update, perform the update query
    if (!empty($updatedFields)) {
        // Build the update query dynamically based on provided fields
        $updateQuery = "UPDATE users SET ";
        $updateParams = [];
        $updateTypes = "";

        foreach ($updatedFields as $field => $value) {
            $updateQuery .= "$field = ?, ";
            $updateParams[] = $value;
            $updateTypes .= "s";  // assuming all fields are strings. Adjust as needed
        }

        // Remove the trailing comma and space
        $updateQuery = rtrim($updateQuery, ", ");

        // Add the WHERE condition
        $updateQuery .= " WHERE user_id = ?";

        // Add the user_id to the parameters
        $updateParams[] = $user_id;
        $updateTypes .= "i"; // "i" for integer (user_id)

        // Prepare the update statement
        $stmt = $conn->prepare($updateQuery);

        // Bind the parameters
        $stmt->bind_param($updateTypes, ...$updateParams);

        // Execute the update query
        if ($stmt->execute()) {
            echo "Profile updated successfully.";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No changes detected.";
    }
}
?>