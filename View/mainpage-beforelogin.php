<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: mainpage-beforelogin.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lost & Found</title>
  <link rel="stylesheet" type="text/css" href="/View/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="container">
       <!-- Lost Paws Logo -->
      <nav class="navmenu">
          <div class="logo"> 
            <a href="/View/index.php">
              <p><img src="images/Logo.jpg" alt="Lost Paws Logo" class="logo"/></p>
            </a>
          </div>
  
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
          <a href="/View/reportpetpage.php">Report a Pet</a>
          <a href="/View/mainpage-beforelogin.php">Lost & Found</a>
          <a href="/View/petmap.php">Pet Map</a>
        </div>
  
        <div class="button">
          <a id="signup-button" href="/View/signup.php">Sign Up!</a>
          <a id="login-button" href="/View/login.php">Login</a>
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
                  <p><a href="/View/selectpostpage.php">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                  <img alt="Photo">
                  <p>Brief Pet Information</p>
                  <p><a href="/View/selectpostpage.php">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                  <img alt="Photo">
                  <p>Brief Pet Information</p>
                  <p><a href="/View/selectpostpage.php">View Post</a></p>
              </div>
              <div class="pet-brief-info">
                <img alt="Photo">
                <p>Brief Pet Information</p>
                <p><a href="/View/selectpostpage.php">View Post</a></p>
            </div>
            <div class="pet-brief-info">
                <img alt="Photo">
                <p>Brief Pet Information</p>
                <p><a href="/View/selectpostpage.php">View Post</a></p>
            </div>
            <div class="pet-brief-info">
              <img alt="Photo">
              <p>Brief Pet Information</p>
              <p><a href="/View/selectpostpage.php">View Post</a></p>
           </div>
           <div class="pet-brief-info">
              <img alt="Photo">
              <p>Brief Pet Information</p>
              <p><a href="/View/selectpostpage.php">View Post</a></p>
          </div>
          <div class="pet-brief-info">
            <img alt="Photo">
            <p>Brief Pet Information</p>
            <p><a href="/View/selectpostpage.php">View Post</a></p>
          </div>
          <div class="pet-brief-info">
            <img alt="Photo">
            <p>Brief Pet Information</p>
            <p><a href="/View/selectpostpage.php">View Post</a></p>
          </div>
        </div>
      </main>
  
      <main id="mainpage-right-beforelogin">
        <h3>Sign in to get alerts and to connect with your community!</h3>
        <p>Don't have an account?<a class="signup-button" href="/View/signup.php">Register</a></p>
      </main>
  
    </div>
  </body>
  
  <!-- Footer -->
  <footer>
    <p>CS 476: Software Development Project</p>
  </footer>
  
  </html>
