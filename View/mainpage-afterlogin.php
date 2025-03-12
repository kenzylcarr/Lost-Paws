<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: mainpage-afterlogin.php
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
            <a href="../index.php">
			<p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
		</a>
        </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="/View/reportpetpage.php">Report a Pet</a>
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

    <main id="mainpage-right-afterlogin">
        <div class="user-photo">
            <img src="images/user-photo.jpg" alt="user photo" />
        </div>
    
        <div class="user-name">
            <p>John Doe</p>
        </div>
    
        <div class="user-options">
            <p><a href="">View My Posts</a></p>
            <p><a href="/View/acctsettings.php">Account Settings</a></p>		<!-- Delete acctsettings.php ??? -->
            <p><a href="">Messages</a></p>
        </div>
    </main>

    </div>
</body>
</html>
