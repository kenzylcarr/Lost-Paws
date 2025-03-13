<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: accountpage.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Account Settings - Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="style.css">
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
        <a href="reportpetpage.php">Report a Pet</a>
        <a href="mainpage-beforelogin.php">Lost & Found</a>
        <a href="petmap.php">Pet Map</a>
        <a href="mainpage-afterlogin.php">After Login</a>
      </div>
      <div class="button">
        <a href="logout.php">Logout</a>
      </div>
    </nav>

    <main id="account-settings-main">
      <h1>Account Settings</h1>

      <!-- Profile Section -->
      <section id="profile-section">
        <h3>Profile Information</h3>
        <form id="profile-form" method="post" action="save-profile.php">
          <div class="account-field">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="current_username"/>
          </div>

          <div class="account-field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="user@example.com"/>
          </div>

          <div class="account-field">
            <label for="profile-picture">Profile Picture</label>
            <input type="file" name="profile-picture" id="profile-picture"/>
          </div>
          
          <input type="submit" value="Save Changes" class="save-button"/>
        </form>
      </section>

      <!-- Password Change Section -->
      <section id="password-section">
        <h3>Change Password</h3>
        <form id="password-form" method="post" action="save-password.php">
          <div class="account-field">
            <label for="old-password">Old Password</label>
            <input type="password" name="old-password" id="old-password" required/>
          </div>

          <div class="account-field">
            <label for="new-password">New Password</label>
            <input type="password" name="new-password" id="new-password" required/>
          </div>

          <div class="account-field">
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" name="confirm-password" id="confirm-password" required/>
          </div>

          <input type="submit" value="Change Password" class="save-button"/>
        </form>
      </section>
    </main>

    <footer>
      <p>CS 476: Software Development Project</p>
    </footer>
  </div>
</body>
</html>
