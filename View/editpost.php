<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: editpost.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
  }
  
  // Fetch pet ID data from database
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid pet ID.";
    exit();
  }

  $pet_id = intval($_GET['id']);
  $username = $_SESSION['username'];

  // Fetch user information
  $stmt = $conn->prepare("SELECT user_id, email_address, phone_number, profile_photo FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $user_id = $user['user_id'];

  // Fetch pet information
  $stmt = $conn->prepare("SELECT animal_type, status, location_ip, picture FROM pets WHERE pet_id = ? AND user_id = ?");
  $stmt->bind_param("ii", $pet_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows === 0) {
    echo "Pet post not found.";
    exit();
  }

  $pet = $result->fetch_assoc();

  // Handle form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_type = $_POST['animal_type'];
    $status = $_POST['status'];
    $location_ip = $_POST['location_ip'];

    $stmt = $conn->prepare("UPDATE pets SET animal_type = ?, status = ?, location_ip = ? WHERE pet_id = ? AND user_id = ?");
    $stmt->bind_param("sssii", $animal_type, $status, $location_ip, $pet_id, $user_id);

    if ($stmt->execute()) {
        header("Location: myposts.php");
        exit();
    } else {
        echo "Error updating pet post.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Post | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/reportpet-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="mainpage-container">
       <!-- Lost Paws Logo -->
       <nav class="navmenu">
        <div class="logo"> 
			<p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
    </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="/View/homepage.php">Homepage</a>
        <a href="/View/reportpetpage.php">Report a Pet</a>
        <a href="/View/petmap.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
        </nav>

    <main id="lost-found-database">
        <div class="pet-database-container"> 
            <form method="POST">
            <!-- Animal Type -->
            <label for="animal_type">Animal Type:</label>
                <select name="animal_type">
                    <option value="cat">Cat</option>
                    <option value="dog">Dog</option>
                </select>

                <!-- Status -->
                <label for="status">Status:</label>
                <select name="status">
                    <option value="lost">Lost</option>
                    <option value="found">Found</option>
                </select>

                <!-- Location IP -->
                <label for="location_ip">Location Name:</label>
                <input type="text" name="location_ip" required>

                <!-- Animal Photo -->
                <label for="pet_photo">Upload Animal Photo:</label>
                <input type="file" id="pet_photo" name="pet_photo[]" multiple>
                
                <button type="submit">Update</button>
            </form>
        </div>
      </main>

      <main id="mainpage-right-afterlogin">
        <div class="user-photo">
          <img src="/View/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="user photo" />
        </div>
    
        <div class="user-name">
          <p><?php echo htmlspecialchars($username); ?></p>
        </div>
    
        <div class="user-options">
            <p><a href="/View/accountpage.php">Account Settings</a></p>	
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
    </div>
    </body>
</html>