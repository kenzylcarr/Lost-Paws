<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: reportpetpage.php
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

// Fetch data from database
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get form data
  $animal_type = $_POST['animal_type'];
  $status = $_POST['status'];
  $location_ip = $_POST['location_ip'];

  // Prepare INSERT statement for putting data into database
  $stmt = $conn->prepare("INSERT INTO pets (user_id, animal_type, status, location_ip, picture) VALUES (?, ?, ?, ?, ?)");
  $picture_paths = [];

  // Handle file uploads
  if (isset($_FILES['petPhotos'])) {
    $target_dir = "../View/pet-uploads/";
    $total_files = count($_FILES['petPhotos']['name']);

    for ($i = 0; $i < $total_files; $i++) {
      $file_name = basename($_FILES['petPhotos']['name'][$i]);
      $target_file = $target_dir . $file_name;
      $uploadOK = 1;

      // Check if the file is an image
      $check = getimagesize($_FILES['petPhotos']['tmp_name'][$i]);
      if ($check === false) {
        echo "File is not an image.";
        $uploadOK = 0;
      }

      // Check file size
      if ($_FILES['petPhotos']['size'][$i] > 1000000) {
        echo "File is too large. Maximum 1MB.";
        $uploadOK = 0;
      }
      
      // Allow certain file types
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG and GIF files are accepted.";
        $uploadOK = 0;
      }

      if ($uploadOK == 1) {
        if (move_uploaded_file($_FILES['petPhotos']['tmp_name'][$i], $target_file)) {
          $picture_paths[] = $target_file;
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      }
    }
  }
    // Insert into the database
    foreach ($picture_paths as $picture) {
      $stmt->bind_param("issss", $user_id, $animal_type, $status, $location_ip, $picture);
      $stmt->execute();
    }
    echo "Pet reported successfully!";
    header("Location: homepage.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report A Pet</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/reportpet-style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYcE9zeJV6TUA9qrT07nqnn3h694xcKtw&callback=initMap" async defer></script>
  <style>
    #map1, #map2 { height: 400px; width: 100%; margin-bottom: 20px; }
    #submitBtn {
      margin-top: 20px;
    }
  </style>
</head>

<body>
<div class="reportpet-page">
  <div id="container">
     <!-- Lost Paws Logo -->
    <nav class="navmenu">
        <div class="logo"> 
            <a href="../index.php">
			<p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
		</a>
        </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="homepage.php">Homepage</a>	
        <a href="petmap.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
    </nav>
    
    <main id="main-center">
      <div class="signup-header">
          <h2>Report a Lost or Found Pet:</h2>
      </div>
	   								 <!-- Remove sign-up form? -->
      <!-- Prompts user to input their information -->     
      <form action="reportpetpage.php" method="post" enctype="multipart/form-data">
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
          <label for="location_ip">Location:</label>
          <input type="text" name="location_ip" required>

          <!-- Animal Photo -->
          <label for="petPhoto">Upload Animal Photo:</label>
          <input type="file" name="petPhotos[]" multiple accept="image/*">

          <button type="submit">Submit</button>
      </form>
        <!-- <h1> Report a Lost or Found Pet:</h1> -->
        <!-- <div class="container">
            <div class="map-container">
                <h2>Drop a pin on the map:</h2>
              
              <div class="map">
   		 <iframe 
        width="100%" 
        height="400px" 
        frameborder="0" 
        style="border:0" 
        allowfullscreen 
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
   		 </iframe>
			</div>
            </div>
          <div class="form-container">
                <p> Report a pet by providing the following information!</p>
				</br>
                
                <-- Embedded Form -->
                <!-- <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeX-rwts6_gJn5A0nXWU2nHLG06chqNJUSW3mN022037sx4FA/viewform?usp=header" width="100%" height="500px" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
		</br> -->
    </div>
	</main>

  <h1>Click on the map to select a location, then submit to save it</h1>
  
  <!-- First Map -->
  <div id="map1"></div>
  
  <button id="submitBtn" style="display:none;">Submit Location</button>

  <!-- Second Map -->
  <h2>All Saved Locations - automatically displays a new pinned location in REAL TIME</h2>
  <div id="map2"></div>
  
  <script>
    let map1;
    let map2;
    let currentMarker = null;  // Store the current marker
    let selectedLocation = null;  // Store the selected location (lat, lng)

    // Initialize both maps
    function initMap() {
      // First Map Initialization
      map1 = new google.maps.Map(document.getElementById("map1"), {
        center: { lat: 50.4454, lng: -104.6189 },  // Regina coordinates
        zoom: 12,
      });

      // Second Map Initialization (show all saved locations)
      map2 = new google.maps.Map(document.getElementById("map2"), {
        center: { lat: 50.4454, lng: -104.6189 },  // Same center as the first map
        zoom: 12,
      });

      // Add a click event listener to the first map
      google.maps.event.addListener(map1, "click", function(event) {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();

        // If a marker already exists, remove it
        if (currentMarker) {
          currentMarker.setMap(null);
        }

        // Create a new marker at the clicked position
        currentMarker = new google.maps.Marker({
          position: event.latLng,
          map: map1,
        });

        // Store the location for submission
        selectedLocation = { lat, lng };

        // Show the submit button after a location is selected
        document.getElementById("submitBtn").style.display = "inline-block";
      });

      // Load all locations on the second map
      loadAllLocations();
    }

    // Function to save the selected location
    function saveLocation(lat, lng) {
      fetch("save_location.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ lat, lng }),
      })
      .then(response => response.json())
      .then(data => {
        console.log("Location saved:", data);
        alert('Location saved successfully!');
        
        // After saving the location, reload all markers on the second map
        loadAllLocations();
      })
      .catch(error => {
        console.error("Error saving location:", error);
        alert('Error saving location!');
      });
    }

    // Function to load all locations from the database and display them on map2
    function loadAllLocations() {
      fetch("get_locations.php")
        .then(response => response.json())
        .then(data => {
          // Clear all existing markers before adding new ones
          clearMarkers(map2);

          data.forEach(location => {
            const latLng = new google.maps.LatLng(location.latitude, location.longitude);
            new google.maps.Marker({
              position: latLng,
              map: map2,
            });
          });
        })
        .catch(error => {
          console.error("Error loading locations:", error);
        });
    }

    // Function to clear existing markers on a given map
    function clearMarkers(map) {
      const markers = map.markers || [];
      markers.forEach(marker => {
        marker.setMap(null);
      });
      map.markers = [];
    }

    // Function to handle submit click
    function handleSubmit() {
      if (selectedLocation) {
        const { lat, lng } = selectedLocation;
        saveLocation(lat, lng);

        // Reset the selected location and hide the submit button
        selectedLocation = null;
        document.getElementById("submitBtn").style.display = "none";

        // Optionally, you can remove the marker here if needed:
        currentMarker.setMap(null);
      } else {
        alert('Please select a location on the map before submitting!');
      }
    }

    // Attach the handleSubmit function to the button's click event
    document.getElementById("submitBtn").addEventListener("click", handleSubmit);
  </script>
</body>
</html>
