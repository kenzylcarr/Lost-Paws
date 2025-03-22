<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: deletepost.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
  }
  
  // Fetch user data from database
  $username = $_SESSION['username'];
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

  // Check if the delete request was sent
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
    $pet_id = $_POST['pet_id'];

    // Delete comments from database
    $delete_comments_stmt = $conn->prepare("DELETE FROM comments WHERE pet_id = ?");
    $delete_comments_stmt->bind_param("i", $pet_id);
    $delete_comments_stmt->execute();
    $delete_comments_stmt->close();

    // Delete from database
    $delete_stmt = $conn->prepare("DELETE FROM pets WHERE pet_id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $pet_id, $user_id);

    if ($delete_stmt->execute()) {
      echo "<p>Pet post deleted successfully.</p>";
    } else {
      echo "<p>Error deleting pet post.</p>";
    }
    $delete_stmt->close();
  }

  // Fetch user's pet posts
  $pets = [];
  $query = "SELECT pet_id, animal_type, status, location_ip, picture FROM pets WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
  }
  if (empty($pets)) {
    echo "<p>No pet posts found.</p>";
    }
?>