<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: homepage.php
-->

<!-- PHP validation for the form begins -->
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

  // Get the 'status' parameter from the URL (if present)
  $status = isset($_GET['status']) ? $_GET['status'] : '';

  // Fetch pet data from database, with filtering based on status if present
  $pets = [];
  $query = "SELECT pet_id, animal_type, status, location_ip, picture FROM pets";
  if ($status == 'lost' || $status == 'found') {
      $query .= " WHERE status = ?";
  }
  $stmt = $conn->prepare($query);

  // If filtering by status, bind the parameter
  if ($status == 'lost' || $status == 'found') {
      $stmt->bind_param("s", $status);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $pets[] = $row;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lost & Found | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
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
        <a href="/View/reportpetpage.php">Report a Pet</a>
        <a href="/View/petmap.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
        </nav>

    <main id="lost-found-database">
        <!-- Lost or Found Buttons Row -->
            <div class="lost-or-found-buttons">
                <button id="all-button">All Pets</button>
		<button id="lost-button">Lost Pets</button>
                <button id="found-button">Found Pets</button>
            </div>
         <!-- Search and Filter Row -->
         <div class="search-filter">         
            <div class="search-field">
             <!-- Submit Button to Search -->
                <form action="">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit" value="Search"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="pet-database-container"> 
        <?php foreach ($pets as $pet): ?>
              <div class="pet-brief-info">
                <img src="/View/pet-uploads/<?php echo htmlspecialchars($pet['picture']); ?>" alt="Photo of a <?php echo htmlspecialchars($pet['animal_type']); ?>">
                <p> Type: <?php echo htmlspecialchars($pet['animal_type']); ?></p>
                <p> Status: <?php echo htmlspecialchars($pet['status']); ?></p>
                <p> Location: <?php echo htmlspecialchars($pet['location_ip']); ?></p>
                <p><a href="/View/viewpet_member.php?id=<?php echo $pet['pet_id']; ?>">View Post</a></p>
              </div>
              <?php endforeach; ?>
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
            <!-- <p><a href="">View My Posts</a></p> -->
            <p><a href="/View/accountpage.php">Account Settings</a></p>	
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
    </div>

      <!-- Adding JavaScript to handle lost-or-found button clicks -->
      <script>
        // when the "All Pets" button is clicked
        document.getElementById('all-button').addEventListener('click', function() {
          window.location.href = window.location.pathname;
        });

        // when the "Lost Pets" button is clicked
        document.getElementById('lost-button').addEventListener('click', function() {
          window.location.href = "?status=lost";  // update URL with status parameter
        });

        // when the "Found Pets" button is clicked
        document.getElementById('found-button').addEventListener('click', function() {
          window.location.href = "?status=found";  // update URL with status parameter
        });
    </script>
</body>
</html>
