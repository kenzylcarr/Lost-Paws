<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: lostandfound.php
-->

<!-- PHP validation for the form begins -->
<?php
session_start();
require_once("../Model/db_config.php");
  // Fetch pet data from database
  $pets = [];
  $stmt = $conn->prepare("SELECT pet_id, animal_type, status, location_ip, picture FROM pets");
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
  <title>Lost & Found</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="mainpage-container">
       <!-- Lost Paws Logo -->
      <nav class="navmenu">
          <div class="logo"> 
            <a href="../index.php">
              <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
            </a>
          </div>
  
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
        </div>
  
        <div class="button">
          <p>Already have an account? </p>
          <a id="login-button" href="/View/login.php">Login</a>
        </div>
      </nav>
      
      <main id="lost-found-database">
        <!-- Lost or Found Buttons Row -->
            <div class="lost-or-found-buttons">
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
                <img src="<?php echo htmlspecialchars($pet['picture']); ?>" alt="Photo of a <?php echo htmlspecialchars($pet['animal_type']); ?>">
                <p> Type: <?php echo htmlspecialchars($pet['animal_type']); ?></p>
                <p> Status: <?php echo htmlspecialchars($pet['status']); ?></p>
                <p> Location: <?php echo htmlspecialchars($pet['location_ip']); ?></p>
                <p><a href="/View/viewpet_visitor.php?id=<?php echo $pet['pet_id']; ?>">View Post</a></p>
              </div>
              <?php endforeach; ?>
        </div>
      </main>
  
      <main id="mainpage-right-beforelogin">
        <h3>Sign in to get alerts and to connect with your community!</h3>
        <p>Don't have an account?<a id="signup-button" href="/View/signup.php">Sign Up!</a></p>
      </main>
  
    </div>
  </body>
  </html>
