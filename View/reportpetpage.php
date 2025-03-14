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
    header("Location: lostandfound.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report A Pet</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
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
      <!-- Prompts user to input their information -->
      <form class="auth-form-signup" id="signup-form" action="../Controller/register.php" method="post" enctype="multipart/form-data">
          <!-- First Name -->
          <div class="signup-field">
              <label for="firstname">First Name</label>
              <input type="text" name="firstname" id="firstname"/><br />
              <span id="error-text-firstname" class="error-text hidden">Invalid first name.</span><br />
          </div>    
          <!-- Last Name -->
          <div class="signup-field">
              <label for="lastname">Last Name</label>
              <input type="text" name="lastname" id="lastname"/><br />
              <span id="error-text-lastname" class="error-text hidden">Invalid last name.</span><br />
          </div>
          <!-- Username -->
          <div class="signup-field">
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" />
                  <span id="error-text-username" class="error-text hidden">Invalid username.</span><br />
          </div>
          <!-- Email Address -->
          <div class="signup-field">
              <label for="email">Email</label>
              <input type="email" name="email" id="email"/><br />
              <span id="error-text-email" class="error-text hidden">Invalid email address.</span><br />
          </div>
      
          <!-- Phone Number -->
          <div class="signup-field">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone"/><br />
              <p id="error-text-phone" class="error-text hidden">Enter a valid phone number.</p>
          </div>
          <!-- Password -->
          <div class="signup-field">
              <label for="password">Password</label>
              <input type="password" name="password" id="password"/><br />
              <span id="error-text-password" class="error-text hidden">Invalid password. Must be at least 6 characters long, and contain one special character.</span><br />
          </div>
          <!-- Confirm Password -->
          <div class="signup-field">
              <label for="cpassword">Confirm Password</label>
              <input type="password" name="cpassword" id="cpassword"/><br />
              <span id="error-text-cpassword" class="error-text hidden">Passwords do not match.</span><br />
          </div>
          <!-- Profile Photo -->
          <div class="signup-field">
              <label for="profilephoto">Profile Picture</label>
              <input type="file" id="profile_photo" name="profile_photo" />
              <p id="error-text-profile_photo" class="error-text hidden">Choose a valid file.</p>
          </div>
          <!-- Submit button that redirects user to mainpage -->
          <div class="signup-field">
              <input class="signup-button" type="submit" value="Sign Up!" action="login.php"/>
          </div>
        </form>

        <!-- <h1> Report a Lost or Found Pet:</h1>
        <div class="container">
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
                
                <!-- Embedded Form -->
                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeX-rwts6_gJn5A0nXWU2nHLG06chqNJUSW3mN022037sx4FA/viewform?usp=header" width="100%" height="500px" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
		</br> -->
		
		<div class="upload-container">
			<p><strong>Please upload 1-5 images of your pet:</strong></p>
			<input type="file" id="petImages" name="petImages" accept="image/*" multiple>
			<label for="petImages">Choose Files</label> <!-- Custom "Choose Files" button -->
			<button type="submit" id="submitImages" class="upload-button">Submit Images</button>
		</div>
      </div>

	</main>
</html>
