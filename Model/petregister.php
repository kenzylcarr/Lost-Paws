
<!-- CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: petregister.php
-->

<?php 
// Include the db_config.php file to connect to database
require_once '../Model/db_config.php';
session_start();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../View/login.php"); 
    exit();
}

// Fetch user data
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
        $pet_photo = [];
        if (isset($_FILES['pet_photo']) && is_array($_FILES['pet_photo']['name'])) {
            $target_dir = "../View/pet-uploads/";
            // Check if the target directory exists, if not create one
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $total_files = count($_FILES['pet_photo']['name']);
    
            for ($i = 0; $i < $total_files; $i++) {
                $file_name = basename($_FILES['pet_photo']['name'][$i]);
                $target_file = $target_dir . $file_name;
                $uploadOK = 1;
    
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
            if (empty($pet_photo)) {
                echo "No pictures were uploaded.";
            } else {
                // Prepare INSERT statement
                $stmt = $conn->prepare("INSERT INTO pets (user_id, animal_type, status, location_ip, picture, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                // Insert into the database
                foreach ($pet_photo as $picture) {
                $stmt->bind_param("issssdd", $user_id, $animal_type, $status, $location_ip, $picture, $latitude, $longitude);
                if (!$stmt->execute()) {
                    echo "Error executing query: " . $stmt->error;
                } else {
                    echo "Pet reported successfully!";
                }
             }
             $end_time = microtime(true);
             $execution_time = $end_time - $start_time;
     
             echo "Execution time: " . $execution_time . " seconds.<br>";
     
             header("Location: ../View/reportpetpage.php");
             exit();
        }
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