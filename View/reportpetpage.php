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

// Execution time
// $start_time = microtime(true);

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

// Start measuring the execution time
$start_time = microtime(true);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $start_time = microtime(true);

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
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $end_time = microtime(true);
    $execution_time = number_format(($end_time - $start_time), 4);
  }

  echo "Execution time: " . $execution_time . " seconds.<br>";

  header("Location: ../View/homepage.php");
  exit();
} 
else {
    // Display validation errors
    if (!empty($animal_type_err)) echo $animal_type_err . "<br>";
    if (!empty($status_err)) echo $status_err . "<br>";
    if (!empty($location_err)) echo $location_err . "<br>";
    if (!empty($picture_err)) echo $picture_err . "<br>";
    if (!empty($latitude_err)) echo $latitude_err . "<br>";
    if (!empty($longitude_err)) echo $longitude_err . "<br>";
}

// Execution time
$end_time = microtime(true);
$execution_time = number_format(($end_time - $start_time), 4);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report A Pet | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/reportpet-style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYcE9zeJV6TUA9qrT07nqnn3h694xcKtw&callback=initMap" async defer></script>
</head>

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
        <a href="/View/petmap-user.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
    </nav>
    
    <main id="main-center">
      <div class="report-header">
          <h2>Report a Lost or Found Pet</h2>
      </div>

      <!-- Prompts user to input their information -->     
      <form class="auth-form-register" id="register-form" action="../Model/petregister.php" method="post" enctype="multipart/form-data">
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
          <input type="file" id="pet_photo" name="pet_photo[]">

          <!-- Google Map for Location -->
          <label for="map">Select Location on Map: </label>
          <div id="map"></div>
          
          <!-- Hidden Fields for Latitude and Longitude -->
          <input type="hidden" name="latitude" id="latitude">
          <input type="hidden" name="longitude" id="longitude">

          <button type="submit">Submit</button>
      </form>
    </main>
  </div>
</div>

<?php if(isset($execution_time)): ?>
<div id="execution-time" style="margin-top: 10px; font-size: 14px; color: gray;">
  Page generated in <?php echo $execution_time; ?> seconds.
</div>
<?php endif; ?>

<script src="../Controller/map-saveLocation.js"></script>
</body>
</html>