<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: login.php
-->
<?php
// Start the session
session_start();


// Include database configuration file
require_once '../Model/db_config.php';

// Initialize variables
$username = "";
$password = "";
$username_err = "";
$password_err = "";
$login_err = "";



// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter your username.";
  } else {
    $username = trim($_POST["username"]);
  }
  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }
  // Check for errors before querying database
  if (empty($username_err) && empty($password_err)) {
    // Prepare SELECT statement
    $sql = "SELECT user_id, username, password FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      $param_username = $username;

      // Execute prepared statement
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        // Check if the username exists, then verify password if it does
        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              if (session_status() == PHP_SESSION_NONE) {
                // Password is valid, start new session
                session_start();
              }
              // Store data in session variables
              $_SESSION["signedin"] = true;
              $_SESSION["id"] = $user_id;
              $_SESSION["username"] = $username;

              // Redirect user to mainpage after login
              header("location: homepage.php");
              exit();
            } else {
              // Invalid password
              $_SESSION['login_err'] = "Invalid username or password.";
              header("location: login.php");
              exit();
            }
          }
        } else {
          // Invalid username
          $_SESSION['login_err'] = "Invalid username or password.";
          header("location: login.php");
          exit();
        }
      } else {
        $_SESSION['login_err'] = "Something went wrong. Please try again.";
        header("location: login.php");
        exit();
      }
      // Close statment
      mysqli_stmt_close($stmt);
    }
  }
  // Close connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/login-style.css">
  <script src="../Controller/eventHandler.js"></script>
</head>

<body>
  <div id="container">
    <nav class="navmenu">
      <!-- Lost Paws Logo -->
      <div class="logo">
        <a href="../index.php">
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo" /></p>
        </a>
      </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="lostandfound.php">Lost & Found</a>
        <a href="/View/petmap-visitor.php">Pet Map</a>
      </div>
    </nav>


    <!-- Left-hand side of page  -->
    <main id="main-left-login">
      <div class="login-header">
        <h1>L·ᴥ·st Paws</h1>
        <h2>Welcome to Lost Paws!</h2>
      </div>

      <!-- Show login error if exists -->
      <?php if (!empty($login_err)): ?>
        <div class="login-error"><?php echo $login_err; ?></div>
      <?php endif; ?>

      <!-- Prompts for user input to login -->
      <form class="auth-form-login" id="login-form" action="../View/login.php" method="post">
        <h3>Login</h3>

        <!-- Username -->
        <div class="login-field">
          <label for="username">Username</label>
          <input type="text" name="username" id="username">
          <p id="error-text-username" class="error-text <?php echo empty($username_err) ? 'hidden' : ''; ?>">
            <?php echo $username_err; ?>
          </p>
        </div>

        <!-- Password -->
        <div class="login-field">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" />
          <p id="error-text-password" class="error-text <?php echo empty($password_err) ? 'hidden' : ''; ?>">
            <?php echo $password_err; ?>
          </p>
        </div>

        <!-- Incase of Forgotten Password
            <div class="login-field">
              <p><a href="forgotpassword.php" class="forgot-password">Forgot Password</a></p>
             <br>
            </div> -->

        <!-- Submit Button to Login -->
        <div class="login-field">
          <input id="login-button" type="submit" value="Login">
        </div>
      </form>

      <!-- If user does not have an account  -->
      <div class="login-footnote">
        <p>Don't have an account? <a id="signup-button" href="signup.php">Signup</a></p>
      </div>
    </main>

    <!-- Right-hand side of page -->
    <main id="main-right-login">
      <!-- <div class="login-image1"> 
        <img src="images/PawPrints.png" alt="Paw Prints">
      </div> -->
      <div class="login-image2">
        <img src="images/DogStack.png" alt="Stack of Dogs">
      </div>
    </main>

    <script src="../Controller/eventRegisterLogin.js"></script>

  </div>
</body>

</html>
</DOCTYPE>