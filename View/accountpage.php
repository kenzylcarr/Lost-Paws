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
  <title>Account Settings</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="../Controller/eventHandler.js"></script>
</head>

<body>
  <div id="container">
    <nav class="navmenu">
      <div class="logo">
        <a href="index.php">
          <img src="images/lp-logo.png" alt="Lost Paws Logo" class="logo"/>
        </a>
      </div>
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="reportpetpage.php">Report a Pet</a>
        <a href="mainpage-beforelogin.php">Lost & Found</a>
        <a href="petmap.php">Pet Map</a>
      </div>
      <div class="button">
        <a href="logout.php">Logout</a>
      </div>
    </nav>

    <main id="account-settings-main">
      <div class="settings-container">
        <!-- Sidebar -->
        <aside class="sidebar">
          <div class="profile-info">
            <img src="images/default-profile.png" alt="Profile Picture" class="profile-pic">
            <p class="username">John Doe</p>
          </div>
          <ul class="settings-menu">
            <li><a href="#profile">Profile</a></li>
            <li><a href="#account">Account</a></li>
            <li><a href="#password">Change Password</a></li>
            <li><a href="#delete">Delete Account</a></li>
          </ul>
        </aside>

        <!-- Main Content -->
        <section class="settings-content">
          <h1>Account Settings</h1>
          <div id="profile" class="settings-section">
            <h3>Profile Information</h3>
            <form id="profile-form" method="post" action="save-profile.php">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" value="JohnDoe"/>
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="johndoe@example.com"/>
              <input type="submit" value="Save Changes" class="save-button"/>
            </form>
          </div>
        </section>
      </div>
    </main>

    <footer>
      <p>CS 476: Software Development Project</p>
    </footer>
  </div>
</body>
</html>
