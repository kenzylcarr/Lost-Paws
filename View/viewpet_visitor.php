<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: viewpet_visitor.php
-->
<?php
session_start();
require_once("../Model/db_config.php");

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
  // Get the pet_id and comment from the form
  $pet_id = isset($_POST['pet_id']) ? $_POST['pet_id'] : null; // Get pet_id from POST data
  $comment = htmlspecialchars($_POST['comment']);
  
  if (!empty($pet_id) && !empty($comment)) {
    // Insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (pet_id, user_id, comment_content, comment_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $pet_id, $user_id, $comment);
    
    if ($stmt->execute()) {
      echo "<script>window.location.href = window.location.href;</script>";
    } else {
      echo "Error adding comment.";
    }
  } else {
    echo "Comment or pet_id is missing.";
  }
}

// Get the pet_id from the URL
if (isset($_GET['id'])) {
  $pet_id = $_GET['id'];

  // Fetch specific pet data from the database along with the username
  $stmt = $conn->prepare("
    SELECT pets.pet_id, pets.user_id, pets.animal_type, pets.status, pets.location_ip, pets.picture, pets.latitude, pets.longitude, users.username 
    FROM pets 
    JOIN users ON pets.user_id = users.user_id 
    WHERE pets.pet_id = ?");
  $stmt->bind_param("i", $pet_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $pet = $result->fetch_assoc();
  } else {
      echo "Pet not found.";
      exit();
  }
} else {
    exit();
  }

  // Fetch comments for the pet
  $stmt = $conn->prepare("SELECT comments.comment_content, comments.comment_date, users.username 
                          FROM comments 
                          JOIN users ON comments.user_id = users.user_id 
                          WHERE comments.pet_id = ? 
                          ORDER BY comments.comment_date DESC");
  $stmt->bind_param("i", $pet_id);
  $stmt->execute();
  $comment_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Post</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYcE9zeJV6TUA9qrT07nqnn3h694xcKtw&callback=initMap" async defer></script>
  <style>
    #map {
      height: 300px;
      width: 280px;
    }
  </style>
</head>

<body>
    <div id="container">
      <nav class="navmenu">
        <!-- Lost Paws Logo -->
        <div class="logo"> 
          <a href="../index.php">
            <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
          </a>
        </div>
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
          <a href="/View/lostandfound.php">Lost & Found</a>
        </div>
  
        <div class="button">
          <a id="signup-button" href="signup.php">Sign Up!</a>
          <a id="login-button" href="/View/login.php">Login</a>
        </div>
      </nav>
      
      <!-- Left Section: Map-->
      <main id="select-post-main-left">
      <a href="lostandfound.php"><button id="all-button">View All Pets</button></a>
        <h3>Location Last Seen:</h3>
        
        <!-- Google Map -->
        <div id="map"></div>
      </main>

      <!-- Center Section: Full Post Information-->
      <main id="select-post-main-center">
        <!-- Lost or Found Label -->
            <div class="lost-or-found-label">
              <h1><?php echo htmlspecialchars($pet['status']); ?> Pet</h1> 
            </div>
        <!-- Title of Post -->
            <div class="title-post">
              <h1>Title of Post</h1> 
            </div>
        <!-- Container for Information -->
            <div class="description-container">
              <!-- Column 1: Pet Photo, Contact User-->
              <div class="description-column1">
              <img src="<?php echo htmlspecialchars($pet['picture']); ?>" alt="Photo of a <?php echo htmlspecialchars($pet['animal_type']); ?>">
              <p>Posted by: <?php echo htmlspecialchars($pet['username']); ?></p>
              <a href="login.php"><button id="contact-user-button">Contact User</button></a>
              </div>
              <!-- Column 2: Written Pet Description -->
              <div class="description-column2">
                <p> Type: <?php echo htmlspecialchars($pet['animal_type']); ?></p>
                <p> Status: <?php echo htmlspecialchars($pet['status']); ?></p>
                <p> Location: <?php echo htmlspecialchars($pet['location_ip']); ?></p>
              </div>
            </div>

          <!-- Display Comments -->
          <div class="display-comments">
            <h3>Comments</h3>
            <div class="all-comments">
              <?php
              if ($comment_result->num_rows > 0) {
                while ($comment = $comment_result->fetch_assoc()) {
                  echo '<div class="comment-item">';
                  echo '<p><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['comment_content']) . '</p>';
                  echo '<p><em>' . htmlspecialchars($comment['comment_date']) . '</em></p>';
                  echo '</div>';
                }
              } else {
                echo '<p>No comments yet.</p>';
              }
              ?>
            </div>
        </div>
      </main>
  
      <!-- Right Section: User Prompt to Signup/Login-->
      <main id="select-post-main-right">
        <h3>Sign in to get alerts and to connect with your community!</h3>
        <p>Don't have an account?</p>
        <br>
        <p><a class="signup-button" href="/View/signup.php">Register</a></p>
      </main>
  
    </div>

  <script>
  const petLat = <?php echo isset($pet['latitude']) ? $pet['latitude'] : '0'; ?>;
  const petLng = <?php echo isset($pet['longitude']) ? $pet['longitude'] : '0'; ?>;
  </script>

  <script src="../Controller/map-loadLocation.js"></script>
  </body>
  </html>
