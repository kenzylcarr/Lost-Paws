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
// Include the db_config.php file to connect to database
require_once '../Model/db_config.php';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Array to keep track of any errors while processing the form
$username = "";
$email = "";
$phone = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
      $username_err = "Please enter a username.";
    } else {
      // Prepare SELECT query
      $sql = "SELECT user_id FROM users WHERE username = ?";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = trim($_POST["username"]);
        if (mysqli_stmt_execute($stmt)) {
          $username_err = "This username is already taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Something went wrong. Please try again later.";
      }
      mysqli_stmt_close($stmt);
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
    if (isset($_FILES["profilephoto"]) && $_FILES["profilephoto"]["name"]) {
      $target_dir = "../View/uploads/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename($_FILES["profilephoto"]["name"]);
      if (move_uploaded_file($_FILES["profilephoto"]["tmp_name"], $target_file)) {
        $profile_photo = basename($_FILES["profilephoto"]["name"]);
      }
    }

    // Hash password before storing it
    $param_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare INSERT statement
    $sql = "INSERT INTO users (username, email_address, phone_number, password, profile_photo) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_email, $param_phone, $param_password, $param_profile_photo);

      // Set parameters
      $param_username = $username;
      $param_email = $email;
      $param_phone = $phone;
      $param_profile_photo = $profile_photo;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: ../View/login.php");
        exit();
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
}
mysqli_close($conn);
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
          <form class="auth-form-signup" id="signup-form" action="../Controller/register.php" method="post">
              <!-- Username -->
              <div class="signup-field">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username"/><br />
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
                  <p id="error-text-profilephoto" class="error-text hidden">Choose a valid file.</p>
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
