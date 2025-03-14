
<!-- CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: register.php
-->

<?php 
// Include the db_config.php file to connect to database
require_once '../Model/db_config.php';
session_start();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve user information
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to report a pet.");
}

// Declare variables with empty values
$animal_type = $status = $location_ip = $picture = "";
$animal_type_err = $status_err = $location_err = $picture_err = "";

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
    
    // Handle file upload for pet picture
    if (isset($_FILES["picture"]) && $_FILES["picture"]["name"]) {
        $target_dir = "../View/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = basename($_FILES["picture"]["name"]);
        } else {
            $picture_err = "Error uploading picture.";
        }
    } else {
        $picture_err = "Please upload a picture of the animal.";
    }

    // Check for input errors before submitting to the database
    if (empty($animal_type_err) && empty($status_err) && empty($location_err) && empty($picture_err)) {
        // Prepare INSERT statement
        $sql = "INSERT INTO pets (user_id, animal_type, status, location_ip, picture) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "issss", $param_user_id, $param_animal, $param_status, $param_location, $param_picture);

            // Set parameters
            $param_user_id = $_SESSION['user_id'];
            $param_animal = $animal_type;
            $param_status = $status;
            $param_location = $location_ip;
            $param_picture = $picture;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to the pet listings page
                header("location: ../View/pet_list.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later. Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // Display validation errors
        if (!empty($animal_type_err)) echo $animal_type_err . "<br>";
        if (!empty($status_err)) echo $status_err . "<br>";
        if (!empty($location_err)) echo $location_err . "<br>";
        if (!empty($picture_err)) echo $picture_err . "<br>";
    }
}
mysqli_close($conn);
?>
