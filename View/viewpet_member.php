<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: viewpet_member.php
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
    SELECT pets.pet_id, pets.user_id, pets.animal_type, pets.status, pets.location_ip, pets.picture, users.username 
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="container">
    <nav class="navmenu">
        <!-- Lost Paws Logo -->
        <div class="logo"> 
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
        </div>
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
          <a href="/View/reportpetpage.php">Report a Pet</a>
          <a href="../index.php">Lost & Found</a>
          <a href="/View/petmap.php">Pet Map</a>
        </div>
  
        <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
      </nav>
      
      <!-- Left Section: Map-->
      <main id="select-post-main-left">
        <a href="../index.php"><button id="view-all-button">&#x1F804; View All Pets</button> </a>
        <h3>Location Last Seen</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                <button id="contact-user-button">Contact User</button>
              </div>
              <!-- Column 2: Written Pet Description -->
              <div class="description-column2">
                <p> Type: <?php echo htmlspecialchars($pet['animal_type']); ?></p>
                <p> Status: <?php echo htmlspecialchars($pet['status']); ?></p>
                <p> Location: <?php echo htmlspecialchars($pet['location_ip']); ?></p>
              </div>
            </div>
          
          <!-- Container for Comment Section -->
          <div class="comment-container">
              <h3>Comments</h3>
              <form action="" method="post">
                <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($pet['pet_id']); ?>"> <!-- Hidden pet_id -->
                <input type="text" placeholder="Add a comment" name="comment">
                <button type="submit">Submit</button>
              </form>

            <!-- Display Comments -->
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
  
      <!-- Right Section: Display User Profile -->
      <main id="select-post-main-right-member">
      <div class="user-photo">
          <img src="/View/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="user photo" />
        </div>
    
        <div class="user-name">
          <p><?php echo htmlspecialchars($username); ?></p>
        </div>
    
        <div class="user-options">
            <!-- <p><a href="">View My Posts</a></p> -->
            <p><a href="/View/accountpage.php">Account Settings</a></p>	
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
  
    </div>
  </body>
  
  </html>