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

// Check if connection is successful
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
  header("Location: ../View/login.php");
  exit();
}

// Fetch data from database
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
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

// Declare variables with empty values
$animal_type = $status = $location_ip = $picture = $latitude = $longitude = "";
$animal_type_err = $status_err = $location_err = $picture_err = $latitude_err = $longitude_err = "";
$pet_photo = array();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // debugging
    echo "Latitude: " . $_POST["latitude"] . "<br>";
    echo "Longitude: " . $_POST["longitude"] . "<br>";

    // Validate animal type
    if (empty($_POST["animal_type"]) || !in_array($_POST["animal_type"], ["cat", "dog"])) {
        $animal_type_err = "Please select an animal type.";
    } else {
        $animal_type = trim($_POST["animal_type"]);
    }

    // Validate status
    if (empty($_POST["status"]) || !in_array($_POST["status"], ["lost", "found"])) {
        $status_err = "Please select the status of the pet.";
    } else {
        $status = trim($_POST["status"]);
    }

    // Validate location
    if (empty($_POST["location_ip"])) {
        $location_err = "Please enter the location.";
    } else {
        $location_ip = trim($_POST["location_ip"]);
    }

    // Validate latitude and longitude
    if (empty($_POST["latitude"]) || empty($_POST["longitude"])) {
        $latitude_err = "Please select a location on the map.";
    } else {
        $latitude = trim($_POST["latitude"]);
        $longitude = trim($_POST["longitude"]);
    }

    // Handle file uploads
    if (isset($_FILES['pet_photo']) && is_array($_FILES['pet_photo']['name'])) {
      $target_dir = "../View/pet-uploads/";
      $total_files = count($_FILES['pet_photo']['name']);
  
      for ($i = 0; $i < $total_files; $i++) {
        $file_name = basename($_FILES['pet_photo']['name'][$i]);
        $target_file = $target_dir . $file_name;
        $uploadOK = 1;
  
        // Check if the file is an image
        $check = getimagesize($_FILES['pet_photo']['tmp_name'][$i]);
        if ($check === false) {
          echo "File is not an image.";
          $uploadOK = 0;
        }
  
        // Check file size
        if ($_FILES['pet_photo']['size'][$i] > 1000000) {
          echo "File is too large. Maximum 1MB.";
          $uploadOK = 0;
        }
        
        // Allow certain file types
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
          echo "Sorry, only JPG, JPEG, PNG and GIF files are accepted.";
          $uploadOK = 0;
        }
        // Attempt to upload the file if all checks pass
        if ($uploadOK == 1) {
          if (move_uploaded_file($_FILES['pet_photo']['tmp_name'][$i], $target_file)) {
              $pet_photo[] = $target_file; // Store the path for database insertion
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
        }
      }
    }

    // Check for input errors before submitting to the database
    if (empty($animal_type_err) && empty($status_err) && empty($location_err) && empty($latitude_err) && empty($longitude_err)) {
        // Prepare INSERT statement
        $stmt = $conn->prepare("INSERT INTO pets (user_id, animal_type, status, location_ip, picture, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Insert into the database
        foreach ($pet_photo as $picture) {
          $stmt->bind_param("issssff", $user_id, $animal_type, $status, $location_ip, $picture, $latitude, $longitude);
          if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
          }
        }
        header("Location: ../View/homepage.php");
        exit();
    } else {
        // Display validation errors
        if (!empty($animal_type_err)) echo $animal_type_err . "<br>";
        if (!empty($status_err)) echo $status_err . "<br>";
        if (!empty($location_err)) echo $location_err . "<br>";
        if (!empty($picture_err)) echo $picture_err . "<br>";
        if (!empty($latitude_err)) echo $latitude_err . "<br>";
        if (!empty($longitude_err)) echo $longitude_err . "<br>";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report A Pet</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/reportpet-style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYcE9zeJV6TUA9qrT07nqnn3h694xcKtw&callback=initMap" async defer></script>
</head>

<style>
  /* Set a height for the map */
  #map {
    height: 400px;
    width: 100%;
  }
</style>

<body>
<div class="reportpet-page">
  <div id="container">
     <!-- Lost Paws Logo -->
    <nav class="navmenu">
        <div class="logo"> 
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
        </div>

      <!-- Navigation menu -->
      <div class="nav-links">
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

      <!-- Prompts user to input their information -->     
      <form class="auth-form-register" id="register-form" action="../Controller/petregister.php" method="post" enctype="multipart/form-data">
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
          <label for="pet_photo">Upload Animal Photo:</label>
          <input type="file" id="pet_photo" name="pet_photo[]" multiple>

          <!-- Google Map for Location -->
          <label for="map">Select Location on Map:</label>
          <div id="map"></div>
          
          <!-- Hidden Fields for Latitude and Longitude -->
          <input type="hidden" name="latitude" id="latitude">
          <input type="hidden" name="longitude" id="longitude">

          <button type="submit">Submit</button>
      </form>

    </main>
  </div>
</div>
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
  <script src="../Controller/map-location.js"></script>
</body>
</html>
