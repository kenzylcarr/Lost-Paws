<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: index.php
-->
<?php
include('db_config.php');
if($pdo) {
  echo "Connected to database!";
}
?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Homepage</title>
    <link rel="stylesheet" type="text/css" href="/View/style.css">
  </head>

  <body>
    <!-- Navigation Menu -->
    <nav class="navmenu">
      <div class="nav-links">
        <a href="/View/aboutpage.html">About Lost Paws</a>
        <a href="/View/howtousepage.html">How To Use</a>
        <a href="/View/reportpetpage.html">Report a Pet</a>
        <a href="/View/mainpage.html">Lost & Found</a>
      </div>
    </nav>

    <div class="container">
      <div class="top-half">
        <h1>Lost Paws</h1>
        <p>Sign up now and join the community to report lost pets and lost pet sightings!</p>
        <a href="/View/signup.html">Sign Up!</a>
      </div>
      
      <!-- Bottom text -->
      <div class="bottom-half">
        <p>Together, we can make a positive impact on the lives of countless animals. Sign up now and become part of our compassionate community. Your support means the world to us and to the animals we care for.</p>
        <a href="/View/mainpage.html">View Lost Pet Sightings</a>
      </div>
    </div>
  <footer>
    <p>CS 476: Software Development Project</p>
  </footer>
  </body>
</html>