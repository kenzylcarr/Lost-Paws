<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: editpost.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
  }
  
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['field'])) {
  require_once("../Model/db_config.php");

  $field = $_POST['field'];
  $value = $_POST['value'];
  $pet_id = intval($_POST['pet_id']);

  $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();
  $user_id = $user['user_id'];

  $allowed_fields = ['animal_type', 'status', 'location_ip'];
  if (!in_array($field, $allowed_fields)) {
    exit();
  }

  $stmt = $conn->prepare("UPDATE pets SET $field = ? WHERE pet_id = ? AND user_id = ?");
  $stmt->bind_param("sii", $value, $pet_id, $user_id);

  if ($stmt->execute()) {
    header("Location: myposts.php");
    exit();
  }
  else {
    echo "Error updating.";
  }
  exit();
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

  if (isset($pet_photo) && count($pet_photo) > 0) {
    $new_picture = $pet_photo[0];

    // Update the pet's picture with the new one
    $stmt = $conn->prepare("UPDATE pets SET picture = ? WHERE pet_id = ?");
    $stmt->bind_param("si", $new_picture, $pet_id);
    $stmt->execute();
  }
}

  // Fetch pet ID data from database
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid pet ID.";
    exit();
  }

  $pet_id = intval($_GET['id']);

  // Fetch user information
  $stmt = $conn->prepare("SELECT user_id, email_address, phone_number, profile_photo FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $user_id = $user['user_id'];

  // Fetch pet information
  $stmt = $conn->prepare("SELECT animal_type, status, location_ip, picture FROM pets WHERE pet_id = ? AND user_id = ?");
  $stmt->bind_param("ii", $pet_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows === 0) {
    echo "Pet post not found.";
    exit();
  }

  $pet = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Post | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/reportpet-style.css">
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
        <a href="/View/homepage.php">Homepage</a>
        <a href="/View/reportpetpage.php">Report a Pet</a>
        <a href="/View/petmap-user.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="login-button" href="logout.php">Logout</a>
      </div>
        </nav>

    <main id="lost-found-database">
        <div class="pet-database-container"> 
        <div class="input-box">
        <form id="edit-post-form" method="POST" enctype="multipart/form-data">

	<!-- Do not let user update animal type
            <label for="animal_type">Animal Type:</label>
              <select name="animal_type">
                  <option value="cat"> <?php if ($pet['animal_type'] == 'cat'); ?>Cat</option>
                  <option value="dog"> <?php if ($pet['animal_type'] == 'dog'); ?>Dog</option>
              </select>
              <!-- <button type="button" id="update-animal-type">Update</button> -->
              <button type="button" onclick="updateField('animal_type')">Update</button>
	-->

              <!-- Status -->
              <label for="status">Status:</label>
              <select name="status">
                  <option value="lost"> <?php if ($pet['status'] == 'lost'); ?>Lost</option>
                  <option value="found"> <?php if ($pet['status'] == 'found'); ?>Found</option>
              </select>
              <button type="button" onclick="updateField('status')">Update</button>

              <!-- Location IP -->
              <label for="location_ip">Location Name:</label>
              <input type="text" id="location_ip" value="<?php echo htmlspecialchars($pet['location_ip']); ?>">
              <button type="button" onclick="updateField('location_ip')">Update</button>

              <!-- Animal Photo -->
              <label for="pet_photo">Upload Animal Photo:</label>
              <input type="file" id="pet_photo" name="pet_photo[]" multiple>
              <button type="button" id="update-photo">Update</button>
      </form>
	    </div>    
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
            <p><a href="/View/accountpage.php">Account Settings</a></p>	
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
    </div>

    <script>
      function updateField(fieldName) {
        let petId = <?php echo $pet_id; ?>;
        let inputElement = document.querySelector(`[name="${fieldName}"], #${fieldName}`);
        let newValue = inputElement.value;

        fetch('editpost.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `field=${fieldName}&value=${encodeURIComponent(newValue)}&pet_id=${petId}`
        })
        .then(response => response.text())
        .then(data => { 
          window.location.href = "myposts.php";
        })
        .catch(error => console.error('Error:', error));
      }
      </script>
      
    </body>
</html>
