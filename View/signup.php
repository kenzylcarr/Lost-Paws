<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
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
$errors = array();
$username = "";
$email = "";
$phone = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Extract all form inputs from the superglobal $_POST variable and store into different variables
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $phone = test_input($_POST["phone"]);
  $password = test_input($_POST["password"]);
  $cpassword = test_input($_POST["cpassword"]);

  // Regular expressions for validation
  $usernameRegex = "/^[a-zA-Z0-9_]+$/";
  $emailRegex = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
  $phoneRegex = "/^\d{10}$/";
  $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/";

  // Error messages array
  $errors = [];

  // Validate Username
  if (!preg_match($usernameRegex, $username)) {
    $errors[] = "Invalid username. Only letters, numbers, and underscores are allowed.";
  }

  // Validate Email
  if (!preg_match($emailRegex, $email)) {
    $errors[] = "Invalid email address.";
  }

  // Validate Phone
  if (!preg_match($phoneRegex, $phone)) {
    $errors[] = "Invalid phone number. It must contain exactly 10 digits.";
  }

  // Validate Password
  if (!preg_match($passwordRegex, $password)) {
    $errors[] = "Invalid password. Must contain at least one uppercase, one lowercase, one digit, one special character (@$!%*?&) and be at least 6 characters long.";
  }

  // Confirm Passwords Match
  if ($password !== $cpassword) {
    $errors[] = "Passwords do not match.";
  }

  // Check for errors
  if (!empty($errors)) {
    foreach ($errors as $error) {
      echo "<p style='color: red;'>$error</p>";
    }
  } else {
    echo "<p style='color: green;'>Form submitted successfully!</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Signup Page</title>
  <link rel="stylesheet" type="text/css" href="/View/style.css">
  <script src="../Controller/eventHandler.js"></script>
</head>

<body>
  <div id="container">
    <nav class="navmenu">
      <!-- Lost Paws Logo -->
      <div class="logo"> 
          <a href="../index.php">
            <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="logo"/></p>
          </a>
      </div>
  
      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="/View/aboutpage.php">About Lost Paws</a>
        <a href="../index.php">Lost & Found</a>
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
                   <input class="signup-button" type="submit" value="Sign Up!" action="mainpage-afterlogin.php"/>
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
