<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: index.php
-->
<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Homepage</title>
    <link rel="stylesheet" type="text/css" href="/View/style.css">
  </head>

  <body>
    <!-- Navigation Menu -->
    <nav class="navmenu">
      <a href="/" class="logo">
        <img src="/View/images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo">
      </a>
      <div class="nav-links">
        <a href="/View/aboutpage.php">About Lost Paws</a>
        <a href="/View/howtousepage.php">How To Use</a>
        <a href="/View/reportpetpage.php">Report a Pet</a>
        <a href="/View/mainpage.php">Lost & Found</a>
      </div>
      <div class="button">
      <a href="/View/login.php" id="index-login-button">Login</a>
      <a href="/View/signup.php" id="index-signup-button">Sign up!</a>
      </div>
    </nav>

    <div class="index-container">
      <div class="index-top-half">
        <h1>Lost Paws</h1>
        <p>Sign up now and join the community to report lost pets and lost pet sightings!</p>
        <a href="/View/signup.php">Sign Up!</a>
      </div>
      
      <!-- Bottom text -->
      <div class="index-bottom-half">
        <p>Together, we can make a positive impact on the lives of countless animals. Sign up now and become part of our compassionate community. Your support means the world to us and to the animals we care for.</p>
        <a href="/View/mainpage.php">View Lost Pet Sightings</a>
      </div>
    </div>
  <footer class ="index-footer">
    <p>CS 476: Software Development Project</p>
  </footer>
  </body>
</html>