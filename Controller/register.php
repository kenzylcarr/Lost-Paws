<?php 
// include the db_config.php file to connect to database
require_once '../Model/db_config.php';

// declare variables with empty values
$username = $email = $phone = $password = "";
$username_err = $email_err = $phone_err = $password_err = "";

// processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate username
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // prepare SELECT query
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)) {
                $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
            }
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}




?>