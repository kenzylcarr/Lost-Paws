<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: login.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="/View/style.css">
  <script src="../Controller/eventHandler.js"></script>
</head>

<body>
  <div id="container">

    <nav class="navmenu">
      <!-- Lost Paws Logo -->
      <div class="logo"> 
          <a href="index.php">
            <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="logo"/></p>
          </a>
      </div>
      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="mainpage-beforelogin.php">Lost & Found</a>
        </div>
    </nav>

      <!-- Left-hand side of page  -->
    <main id="main-left-login">  
      <div class="login-header">
        <h1>LOST PAWS</h1>
        <h2>Welcome to Lost Paws!</h2>
      </div>
          <!-- Prompts for user input to login -->
          <form class="auth-form-login" id="login-form" action="signup.php" method="post">
            <h3>Login</h3>
            
            <!-- Username -->
            <div class="login-field">
              <label for="username">Username</lable>
              <input type="text" name="username" id="username"/>
              <p id="error-text-username" class="error-text hidden">Invalid username</p>
            </div>

            <!-- Password -->
            <div class="login-field">
              <label for="password">Password</label>
              <input type="password" name="password" id="password"/>
              <p id="error-text-password" class="error-text hidden">Invalid password</p>
            </div>

            <!-- Incase of Forgotten Password -->
            <div class="login-field">
              <p><a href="forgotpassword.php" class="forgot-password">Forgot Password</a></p>
             <br>
            </div>

            <!-- Submit Button to Login -->
            <div class="login-field">
              <input class="login-button" type="submit" value="Login" action="mainpage-afterlogin.php">
            </div>
          </form>
        <!-- If user does not have an account  -->
        <div class="login-footnote">
            <p>Don't have an account? <a class="signup-button" href="signup.php">Signup</a></p>
        </div>
    </main>

    <!-- Right-hand side of page -->
    <main id="main-right-login">
        <img>
    </main>
    <script src="../Controller/eventRegisterLogin.js"></script>
</body>

</html>
</DOCTYPE>
