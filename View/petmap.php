<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: petmap.php
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
$sql = "SELECT p.animal_type, p.status, p.latitude, p.longitude, u.first_name, u.last_name
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

// Return data as JSON
// header('Content-Type: application/json');
// echo json_encode($pets);

const petsData = echo json_encode($pets);

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
        <a href="homepage.php">Homepage</a> 
        <a href="reportpetpage.php">Report a Pet</a>	
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
    </nav>
	
<div class="petmap-page">
  <div id="container">
    <main>
      <div id="petmap-container">
        <!-- Centered Toggle and Filter Section -->
        <div id="filter-section">
          <label class="switch">
            <input type="checkbox" id="toggle-lost-found">
            <span class="slider round"></span>
          </label>
          <span id="toggle-label">Lost Pets</span>

          <!-- Dropdown Filter for Pet Type -->
          <select id="pet-type-filter">
            <option value="all">All Pets</option>
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
    let map;
    let markers = [];

    // initialize map
    function initMap() {
      map = new google.maps.Map(document.getElementById('petmap-map'), {
        center: { lat: 50.4601, lng: -104.6639 },  // set initial center (Regina, SK)
        zoom: 12,
      });

      // display all pet locations initially
      displayPetLocations(petsData);
    }

        // Display pet locations on the map
        function displayPetLocations(pets) {
      // Clear existing markers
      markers.forEach(marker => marker.setMap(null));
      markers = [];

      // Loop through pets and add markers
      pets.forEach(pet => {
        const marker = new google.maps.Marker({
          position: { lat: parseFloat(pet.latitude), lng: parseFloat(pet.longitude) },
          map: map,
          title: `${pet.first_name} ${pet.last_name} - ${pet.animal_type}`,
        });
        markers.push(marker);
      });
    }

    // Filter pets based on selected type
    document.getElementById('pet-type-filter').addEventListener('change', (e) => {
      const selectedType = e.target.value;
      const filteredPets = petsData.filter(pet => selectedType === 'all' || pet.animal_type === selectedType);
      displayPetLocations(filteredPets);
    });

    // Toggle between Lost and Found Pets (you can enhance this filter as per your database structure)
    document.getElementById('toggle-lost-found').addEventListener('change', (e) => {
      const status = e.target.checked ? 'lost' : 'found';
      const filteredPets = petsData.filter(pet => pet.status === status || status === 'all');
      displayPetLocations(filteredPets);
    });
  </script>
	
</body>
</html>

