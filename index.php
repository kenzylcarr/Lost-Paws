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
    <nav class="index-navmenu">
      <a href="/" class="logo">
        <img src="/View/images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo">
      </a>
      <div class="index-nav-links">
        <a href="/View/aboutpage.php">About Lost Paws</a>
        <a href="/View/reportpetpage.php">Report a Pet</a>
        <a href="/View/mainpage.php">Lost & Found</a>
      </div>
      <div class="button">
        <p>Already have an account?</p>
        <a href="/View/login.php" id="index-login-button">Login</a>
      </div>
    </nav>

    <div class="custom-shape-divider-bottom-1741667979">
        <svg data-name="Layer 1"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1200 120"
          preserveAspectRatio="none">
          <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
        </svg>
    </div>

    <div class="index-container">
      <div class="index-top-half">
        <h1>Lost Paws</h1>
        <p>Sign up now and join the community to report lost pets and lost pet sightings!</p>
        <a href="/View/signup.php">Sign Up!</a>
      </div>
      
      <!-- Bottom text -->
      <div class="index-bottom-half">
        <p>Together, we can make a positive impact on the lives of countless animals. Sign up now and become part of our compassionate community. Your support means the world to us and to the animals we care for.</p>
        <a href="/View/mainpage-beforelogin.php">View Lost Pet Sightings</a>
      </div>
    </div>
  <footer class ="index-footer">
    <p>CS 476: Software Development Project</p>
  </footer>
  </body>
</html>