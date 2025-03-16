
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
$animal_type = $status = $location_ip = $picture = "";
$animal_type_err = $status_err = $location_err = $picture_err = "";
$picture_paths = [];

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
    
    // Check for input errors before submitting to the database
    if (empty($animal_type_err) && empty($status_err) && empty($location_err) && empty($picture_err)) {
        // Prepare INSERT statement
        $stmt = $conn->prepare("INSERT INTO pets (user_id, animal_type, status, location_ip, picture) VALUES (?, ?, ?, ?, ?)");

        foreach ($picture_paths as $picture) {
            $stmt->bind_param("issss", $user_id, $animal_type, $status, $location_ip, $picture);
            $stmt->execute();
        }

        // Handle file upload for pet picture
        if (isset($_FILES['petImages'])) {
            $target_dir = "../View/pet-uploads/";
            $total_files = count($_FILES['petImages']['name']);

            for ($i = 0; $i < $total_files; $i++) {
                $file_name = basename($_FILES['petImages']['name'][$i]);
                $target_file = $target_dir . $file_name;
                $uploadOK = 1;

                // Check if the file is an image
                $check = getimagesize($_FILES['petImages']['tmp_name'][$i]);
                if ($check === false) {
                    echo "File is not an image.";
                    $uploadOK = 0;
                }

                // Check file size
                if ($_FILES['petImages']['size'][$i] > 1000000) {
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
                    if (move_uploaded_file($_FILES['petImages']['tmp_name'][$i], $target_file)) {
                        $picture_paths[] = $target_file; // Store the path for database insertion
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
    }
        // Insert into database
        if (empty($animal_type_err) && empty($status_err) && empty($location_err)) {
            $stmt = $conn->prepare("INSERT INTO pets (user_id, animal_type, status, location_ip, picture) VALUES (?, ?, ?, ?, ?)");
            foreach($picture_paths as $picture) {
                $stmt->bind_param("issss", $user_id, $animal_type, $status, $location_ip, $picture);
                $stmt->execute();
            }
            echo "Pet reported successfully.";
            header("Location: homepage.php");
            exit();
        } else {
            // Display validation errors
            if (!empty($animal_type_err)) echo $animal_type_err . "<br>";
            if (!empty($status_err)) echo $status_err . "<br>";
            if (!empty($location_err)) echo $location_err . "<br>";
    }
}
mysqli_close($conn);
?>
