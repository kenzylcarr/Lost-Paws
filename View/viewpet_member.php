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
  $comment = $_POST['comment'];
  
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
  $stmt = $conn->prepare("SELECT comments.comment_id, comments.comment_content, comments.comment_date, users.username 
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
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
        </div>
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="homepage.php">Homepage</a>
          <a href="/View/reportpetpage.php">Report a Pet</a>
        </div>
  
        <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
      </nav>
      
      <!-- Left Section: Map-->
      <main id="select-post-main-left">
        <a href="homepage.php"><button id="all-button">View All Pets</button></a>
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
              <a href="messages.php"><button id="contact-user-button">Contact User</button></a>
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
              <div class="add-comment">
                <form action="" method="post">
                  <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($pet['pet_id']); ?>"> <!-- Hidden pet_id -->
                  <input type="text" placeholder="Add a comment" name="comment">
                  <button type="submit">Submit</button>
                </form>
              </div>
              
              <div class="all-comments">
              <?php
                if ($comment_result->num_rows > 0) {
                  while ($comment = $comment_result->fetch_assoc()) {
                    $comment_id = isset($comment['comment_id']) ? $comment['comment_id'] : null;
                    $comment_content = isset($comment['comment_content']) ? $comment['comment_content'] : null;
                    $comment_user_id = isset($comment['user_id']) ? $comment['user_id'] : null;

                    echo '<div class="comment-item">';
                    echo '<p><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['comment_content']) . '</p>';
                    echo '<p><em>' . htmlspecialchars($comment['comment_date']) . '</em></p>';
      
                    // debug 
                    echo "Comment User ID: " . $comment_user_id . "<br>";
                    echo "Logged-in User ID: " . $user_id . "<br>"; 
                    
                    // Show edit and delete options only for the comment owner
                    if ($comment_user_id == $user_id) {
                      echo '<form action="" method="post">
                              <input type="hidden" name="comment_id" value="' . $comment_id . '">
                              <button type="submit" name="delete_comment">Delete</button>
                              <button type="submit" name="edit_comment" value="' . $comment_id . '">Edit</button>
                            </form>';
                    }
                    echo '</div>';
                  }
                } else {
                  echo '<p>No comments yet.</p>';
                }
                ?>
            </div>
        </div>

      <?php
        // Handle edit and delete options
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // Delete comment
          if (isset($_POST['delete_comment'])) {
            $comment_id = $_POST['comment_id'];

            // Delete comment from database
            $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = ? AND user_id = ? ");
            $stmt->bind_param("ii", $comment_id, $user_id);
            if ($stmt->execute()) {
              echo "<script>window.location.href = window.location.href;</script>";
            } else {
              echo "Error deleting comment.";
            }
          }
          // Edit comment
          if (isset($_POST['edit_comment'])) {
            $comment_id = $_POST['edit_comment'];

            // Fetch comment from database
            $stmt = $conn->prepare("SELECT comment_content FROM comments WHERE comment_id = ? AND user_id = ? ");
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              $comment_data = $result->fetch_assoc();
              $comment_content = $comment_data['comment_content'];

              // Display form for editing the comment
              echo '
              <div class="edit-comment">
                <form action="" method="post">
                  <input type="hidden" name="comment_id" value="' . $comment_id . '">
                  <textarea name="comment" placeholder="Edit comment">' . htmlspecialchars($comment_content) . '</textarea>
                  <button type="submit" name="update_comment">Update</button>
                </form>
              </div>';
            } else {
              echo "Comment not found.";
            }
          }
          if (isset($_POST['update_comment'])) {
            $comment_id = $_POST['comment_id'];
            $new_comment_content = $_POST['comment'];

            // Update the comment content in the database
            $stmt = $conn->prepare("UPDATE comments SET comment_content = ? WHERE comment_id = ? AND user_id = ?");
            $stmt->bind_param("sii", $new_comment_content, $comment_id, $user_id);
            if ($stmt->execute()) {
              echo "<script>window.location.href = window.location.href;</script>";
            } else {
              echo "Error updating comment";
            }
          }
        }
      ?>
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
            <p><a href="/View/myposts.php">View My Posts</a></p>
            <p><a href="/View/accountpage.php">Account Settings</a></p>	
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
    </div>

  <script>
    const petLat = <?php echo isset($pet['latitude']) ? $pet['latitude'] : '0'; ?>;
    const petLng = <?php echo isset($pet['longitude']) ? $pet['longitude'] : '0'; ?>;
  </script>

  <script src="../Controller/map-loadLocation.js"></script>
  </body>
  </html>