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
// display PHP version
echo "Current PHP Version: " . phpversion();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lost & Found Hpomepage</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="container">
       <!-- Lost Paws Logo -->
      <nav class="navmenu">
          <div class="logo"> 
            <a href="mainpage.html" class="logo">L·ᴥ·st Paws</a>
          </div>
  
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="aboutpage.html">About Lost Paws</a>
          <a href="howtousepage.html">How To Use</a>
          <a href="reportpetpage.html">Report a Pet</a>
          <a href="index.html">Lost & Found</a>
          <a href="petmap.html">Pet Map</a>
        </div>
  
        <div class="button">
          <a id="signup-button" href="signup.html">Sign Up!</a>
          <a id="login-button" href="login.html">Login</a>
        </div>
      </nav>
      
      <main id="lost-found-database">
        <!-- Lost or Found Buttons Row -->
            <div class="lost-or-found-buttons">
                <button id="lost-button">Lost Pets</button>
                <button id="found-button">Found Pets</button>
            </div>
        <!-- Search and Filter Row -->
            <div class="search-filter">         
                <div class="search-field">
                 <!-- Submit Button to Search -->
                    <form action="">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit" value="Search"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="pet-database-container"> 
              <div class="pet-brief-info">
                  <img alt="Photo">
                  <p>Brief Pet Information</p>
                  <p><a href="selectpostpage.html">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                  <img alt="Photo">
                  <p>Brief Pet Information</p>
                  <p><a href="selectpostpage.html">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                  <img alt="Photo">
                  <p>Brief Pet Information</p>
                  <p><a href="selectpostpage.html">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                <img alt="Photo">
                <p>Brief Pet Information</p>
                <p><a href="selectpostpage.html">View Post</a></p>
            </div>
            <div class="pet-brief-info">
                <img alt="Photo">
                <p>Brief Pet Information</p>
                <p><a href="selectpostpage.html">View Post</a></p>
            </div>
            <div class="pet-brief-info">
              <img alt="Photo">
              <p>Brief Pet Information</p>
              <p><a href="selectpostpage.html">View Post</a></p>
           </div>
           <div class="pet-brief-info">
              <img alt="Photo">
              <p>Brief Pet Information</p>
              <p><a href="selectpostpage.html">View Post</a></p>
          </div>
          <div class="pet-brief-info">
            <img alt="Photo">
            <p>Brief Pet Information</p>
            <p><a href="selectpostpage.html">View Post</a></p>
          </div>
          <div class="pet-brief-info">
            <img alt="Photo">
            <p>Brief Pet Information</p>
            <p><a href="selectpostpage.html">View Post</a></p>
          </div>
        </div>
      </main>
  
      <main id="index-main-right">
        <h3>Sign in to get alerts and to connect with your community!</h3>
        <p>Don't have an account?<a class="signup-button" href="signup.html">Register</a></p>
      </main>
  
    </div>
  </body>
  
  <!-- Footer -->
  <footer>
    <p>CS 476: Software Development Project</p>
  </footer>
  
  </html>


  
