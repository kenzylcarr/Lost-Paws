
<!-- CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
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

// Declare variables with empty values
$username = $email = $phone = $password = "";
$username_err = $email_err = $phone_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare SELECT query
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)) {
                $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
// Validate email address
if(empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email address.";
} else {
    $email = trim($_POST["email"]);
}

// Validate phone number
if(empty(trim($_POST["phone"]))) {
    $phone_err = "Please enter a phone number.";
} else {
    $phone = trim($_POST["phone"]);
}

// Validate password
if(empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
} elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must contain at least 6 characters.";
} else {
    $password = trim($_POST["password"]);
}
// Check for input errors before submitting to database
if (empty($username_err) && empty($email_err) && empty($phone_err) && empty($password_err)) {
    // Handle file upload for profile photo
    $profile_photo = "";
    if (isset($_FILES["profilephoto"]) && $_FILES(["profilephoto"]["name"])) {
        $target_dir = "../View/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_dir = $target_dir . basename($_FILES["profilephoto"]["name"]);
        if (move_uploaded_file(["profilephoto"]["tmp_name"], $target_file)) {
            $profile_photo = basename($_FILES["profilephoto"]["name"]);
        }
    // Prepare INSERT statement
    $sql = "INSERT INTO users (username, email_address, phone_number, password, profile_photo) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_email, $param_phone, $param_password, $param_profile_photo);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_phone = $phone;
            $param_password = $password;
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
    } else {
        // Display validation errors
        if (!empty($username_err)) echo $username_err . "<br>";
        if (!empty($email_err)) echo $email_err . "<br>";
        if (!empty($phone_err)) echo $phone_err . "<br>";
        if (!empty($password_err)) echo $password_err . "<br>";
    }
    mysqli_close($conn);
}
?>