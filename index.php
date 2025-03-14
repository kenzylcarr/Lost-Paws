<!--
  CS 476: Lost Paws Project
  Group Members: 
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
    <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
    <link rel="stylesheet" type="text/css" href="/View/CSS/index-style.css">
  </head>

  <body>
    <!-- Navigation Menu -->
    <nav class="navmenu">
      <a href="index.php" class="logo">
        <img src="/View/images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo">
      </a>
      <div class="nav-links">
        <a href="/View/aboutpage.php">About Lost Paws</a>
        <a href="/View/lostandfound.php">Lost & Found</a>
      </div>
      <div class="button">
      <a href="/View/login.php" id="index-login-button">Login</a>
      <a href="/View/signup.php" id="index-signup-button">Sign up!</a>
      </div>
    </nav>

    <div class="index-container">
      <!-- Top Half -->
      <div class="index-top-half">
        <div class="index-top-half-text">
          <h1>Lost Paws</h1>
          <p>Sign up now and join the community to report lost pets and lost pet sightings!</p>
          <a href="/View/signup.php">Sign Up!</a>
        </div>
        <img src="View/images/index-pets.png" alt="Group of Pets" class="index-image">
      </div>
      
      <!-- Wave Half-->
      <div class="wave-container">
        <div class="wave-text">
          <p>Together, we can make a positive impact on the lives of countless animals. Sign up now and become part of our compassionate community. Your support means the world to us and to the animals we care for.</p>
          <a href="/View/lostandfound.php">View Lost Pet Sightings</a>
        </div>

        <!-- The wave, waves characteristic made from haikei app -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path fill="#FFFFFF" fill-opacity="1"
              d="M0,300L34.3,270C68.6,240,137,180,206,180C274.3,180,343,240,411,230C480,220,549,140,617,120C685.7,100,754,140,823,150C891.4,160,960,130,1029,140C1097.1,150,1166,180,1234,170C1302.9,160,1371,100,1406,70L1440,40L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
          </path>

          <!-- rectangle to fill below the wave -->
          <rect x="0" y="300" width="1440" height="300" fill="#FFFFFF"></rect>  <!-- !!! change rec colour IF changing wave colour!!! -->
        </svg>
      </div>
    </div>
  </body>
</html>
