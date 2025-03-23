<?php
require_once("../Model/db_config.php");

$response = array("emailTaken" => false, "usernameTaken" => false, "phoneTaken" => false);

// Check if email exists
if (isset($_POST["email"]) && !empty($_POST["email"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $sql = "SELECT user_id FROM users WHERE email_address = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $response["emailTaken"] = true;
            }
        }
        mysqli_stmt_close($stmt);
    }
}

// Check if username exists
if (isset($_POST["username"]) && !empty($_POST["username"])) {
    $username = mysqli_real_escape_string($conn, trim($_POST["username"]));
    $sql = "SELECT user_id FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $response["usernameTaken"] = true;
            }
        }
        mysqli_stmt_close($stmt);
    }
}

// Check if phone number exists
if (isset($_POST["phone"]) && !empty($_POST["phone"])) {
    $phone = mysqli_real_escape_string($conn, trim($_POST["phone"]));
    $sql = "SELECT user_id FROM users WHERE phone_number = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $phone);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $response["phoneTaken"] = true;
            }
        }
        mysqli_stmt_close($stmt);
    }
}

echo json_encode($response);
mysqli_close($conn);
?>