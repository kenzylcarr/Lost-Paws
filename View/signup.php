<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: signup.php
-->

<!-- PHP validation for the form begins -->
<?php
session_start();
require_once("../Model/db_config.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$firstname = "";
$lastname = "";
$username = "";
$email = "";
$password = "";
$phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $cpassword = test_input($_POST["cpassword"]);
    $phone = test_input($_POST["phone"]);

    $nameRegex = "/^[a-zA-Z\s]+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $passwordRegex = "/^(?=.*\W).{6,}$/";
    $phoneRegex = "/^\d{10}$/";

    if (!preg_match($nameRegex, $firstname)) {
        $errors['firstname'] = "Invalid first name";
    }
    if (!preg_match($nameRegex, $lastname)) {
        $errors['lastname'] = "Invalid last name";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors['username'] = "Invalid Username";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors['email'] = "Invalid Email";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors['password'] = "Invalid Password";
    }
    if ($password !== $cpassword) {
        $errors['cpassword'] = "Passwords do not match";
    }
    if (!preg_match($phoneRegex, $phone)) { // Validate phone number
        $errors['phone'] = "Invalid Phone Number";
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT username FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->fetch_assoc()) {
        $errors["Account Taken"] = "A user with that username already exists.";
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $avatar_temp = "avatar_temp"; // Temporary value for profile photo

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO Users (username, email_address, password, phone, profile_photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashedPassword, $phone, $avatar_temp);
        $result = $stmt->execute();

        if (!$result) {
            $errors["Database Error:"] = "Failed to insert user";
        } else {
            // Handle file upload
            $target_dir = "../View/uploads/";
            $uploadOK = true;
            $imageFileType = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
            $uid = $conn->insert_id; // Get the last inserted ID
            $target_file = $target_dir . "$uid.$imageFileType";

            if (file_exists($target_file)) {
                $errors['profile_photo'] = "Sorry, this file already exists.";
                $uploadOK = false;
            }

            if ($_FILES["profile_photo"]["size"] > 1000000) {
                $errors["profile_photo"] = "File is too large. Maximum 1MB.";
                $uploadOK = false;
            }

            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $errors['profile_photo'] = "Sorry, only JPG, JPEG, PNG and GIF files are accepted.";
                $uploadOK = false;
            }

            if ($uploadOK) {
                if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                    // Update the user's profile_photo field in the Users table
                    $stmt = $conn->prepare("UPDATE Users SET profile_photo = ? WHERE username = ?");
                    $stmt->bind_param("ss", $target_file, $username);
                    $stmt->execute();
                    header("Location: login.php");
                    exit();
                } else {
                    $errors['profile_photo'] = "Sorry, the image could not be moved.";
                }
            } else {
                // Remove the temporary user record if upload fails
                $stmt = $conn->prepare("DELETE FROM Users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
            }
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Signup Page</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/signup-style.css">
  <script src="../Controller/eventHandler.js"></script>
</head>

<body>
  <div id="container">
    <nav class="navmenu">
      <!-- Lost Paws Logo -->
      <div class="logo"> 
          <a href="../index.php">
            <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
          </a>
      </div>
  
      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="/View/aboutpage.php">About Lost Paws</a>
        <a href="/View/mainpage-beforelogin.php">Lost & Found</a>
      </div>
    </nav>

  <!-- Left-hand side of page  -->
    <main id="main-left-signup">
      <h1>Welcome</h1>
      <h2>Join Our Lost Paws Community!</h2>
    </main>

  <!-- Right-hand side of page  -->
    <main id="main-right-signup">
      <div class="signup-header">
          <h2>Hello! Tell us a bit about yourself.</h2>
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
                    <input type="file" id="profilephoto" name="profilephoto" />
                    <p id="error-text-profile_photo" class="error-text hidden">Choose a valid file.</p>
                </div>
                <!-- Submit button that redirects user to mainpage -->
                <div class="signup-field">
                    <input class="signup-button" type="submit" value="Sign Up!" action="login.php"/>
                </div>
            </form>
      <!-- If user already has an account  -->
      <div class="signup-footnote">
          <p>Already have an account? <a class="login-button" href="/View/login.php">Login</a></p>
      </div>
   </main>
  </div>
  <script src="../Controller/eventRegisterSignup.js"></script>
</body>

</html>
