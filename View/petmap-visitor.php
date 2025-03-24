<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: petmap-visitor.php
-->

<!-- PHP validation for the form begins -->
<?php
session_start();
require_once("../Model/db_config.php");

// Check if connection is successful
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

// Get filters from the request
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$animal_type = isset($_GET['animal_type']) ? $_GET['animal_type'] : 'all';

// Fetch data from database
$sql = "SELECT p.pet_id, p.animal_type, p.status, p.latitude, p.longitude, u.first_name, u.last_name
        FROM pets p
        LEFT JOIN users u ON p.user_id = u.user_id";

// Add filtering by status and animal type
if ($status !== 'all') {
  $sql .= " WHERE p.status = '" . mysqli_real_escape_string($conn, $status) . "'";
}

// Add filtering by animal type
if ($animal_type !== 'all') {
  if ($status !== 'all') {
    $sql .= " AND p.animal_type = '" . mysqli_real_escape_string($conn, $animal_type) . "'";
  } else {
    $sql .= " WHERE p.animal_type = '" . mysqli_real_escape_string($conn, $animal_type) . "'";
  }
}

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
  echo json_encode(["error" => "Failed to retrieve pet data."]);
  exit();
}

// Fetch all data
$pets = [];
while ($row = mysqli_fetch_assoc($result)) {
  $pets[] = $row;
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Find lost and found pets in your area with the Lost Paws interactive pet map.">
  <title>Pet Map | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYcE9zeJV6TUA9qrT07nqnn3h694xcKtw&callback=initMap" async defer></script>
  <script src="../Controller/map-filterLocation.js"></script>
</head>

<body>
<!-- Lost Paws Logo -->
    <nav class="navmenu">
        <div class="logo"> 
	  <a href="../index.php">
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
        </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="lostandfound.php">Lost & Found</a>
      </div>

      <div class="button">
        <a href="/View/login.php" id="login-button">Login</a>
        <a href="/View/signup.php" id="signup-button">Sign up!</a>
      </div>
    </nav>
	
<div class="petmap-page">
  <div id="container">
    <main>
      <div id="petmap-container">
        <!-- Centered Filter Section -->
        <div id="filter-section" >
	  <h1>View Pets on Our Map: </h1>
          <button id="all-button">All Pets</button>
          <button id="lost-button">Lost Pets</button>
          <button id="found-button">Found Pets</button>

          <!-- Dropdown filter for Pet Type -->
          <select id="pet-type-filter">
            <option value="all">All Types</option>
            <option value="cat">Cat</option>
            <option value="dog">Dog</option>
          </select>
	      </div>

        <!-- Google Map -->
        <div id="petmap-map" style="height: 600px;"></div>
      </div>
    </main>
  </div>
  </div>

  <script>
  let allPets = <?php echo json_encode($pets); ?>;
  const loggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
  </script>
	
</body>
</html>

