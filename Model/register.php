
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
require_once("../Model/db_config.php");

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Declare variables with empty values
$firstname = $last_name = $username = $email = $phone = $password = "";
$firstname_err = $lastname_err = $username_err = $email_err = $phone_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    if(empty(trim($_POST["firstname"]))) {
      $firstname_err = "Please enter a first name.";
  } else {
    $firstname = trim($_POST["firstname"]);
  }
  
    // Validate last name
    if(empty(trim($_POST["lastname"]))) {
        $lastname_err = "Please enter a last name.";
    } else {
      $lastname = trim($_POST["lastname"]);
    }
    
  // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare SELECT query
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            // Execute the statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists
                if(mysqli_stmt_num_rows($stmt) > 0) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
        mysqli_stmt_close($stmt);
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

  // Validate email address
  $email = isset($_POST["email"]) ? trim($_POST["email"]) : ""; // Check if email exists
  if (empty($email)) {
    $email_err = "Please enter an email address.";
  } 

  // Validate phone number
  $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : ""; // Check if phone exists
  if (empty($phone)) {
    $phone_err = "Please enter a phone number.";
  }

  // Validate password
  $password = isset($_POST["password"]) ? trim($_POST["password"]) : ""; // Check if password exists
  if (empty($password)) {
    $password_err = "Please enter a password.";
  } elseif (strlen($password) < 6) {
    $password_err = "Password must contain at least 6 characters.";
  }

  // Validate confirm password
  $cpassword = isset($_POST["cpassword"]) ? trim($_POST["cpassword"]) : ""; // Check if confirm password exists
  if ($password !== $cpassword) {
    $password_err = "Passwords do not match.";
  }

  // Check for input errors before submitting to database
  if (empty($username_err) && empty($email_err) && empty($phone_err) && empty($password_err)) {
    // Handle file upload for profile photo
    $profile_photo = "";
    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["name"]) {
      $target_dir = "../View/uploads/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
      if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        $profile_photo = basename($_FILES["profile_photo"]["name"]);
        echo "The file ". basename($_FILES["profile_photo"]["name"]). " has been uploaded.";
      } else {
        // Error occurred
        echo "Sorry, there was an error uploading your file.";
    }
    }

    // Hash password before storing it
    $param_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare INSERT statement
    $sql = "INSERT INTO users (first_name, last_name, username, email_address, phone_number, password, profile_photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssss", $param_first_name, $param_last_name, $param_username, $param_email, $param_phone, $param_password, $param_profile_photo);

      // Set parameters
      $param_first_name = $first_name;
      $param_last_name = $last_name;
      $param_username = $username;
      $param_email = $email;
      $param_phone = $phone;
      $param_profile_photo = $profile_photo;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: ../View/login.php");
      } else {
        echo "Something went wrong. Please try again later. Error: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
  }
}
mysqli_close($conn);
?>