<!--
  CS 476: Lost Paws Project
  Group Members: 
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
  <link rel="stylesheet" type="text/css" href="style2.css">
  <script src="../Controller/eventHandler.js"></script>
    <script>
    // JavaScript function to toggle visibility of sections
    function toggleSection(sectionId) {
      const sections = document.querySelectorAll('.settings-section');
      sections.forEach(section => {
        if (section.id === sectionId) {
          section.style.display = section.style.display === 'none' ? 'block' : 'none';
        } else {
          section.style.display = 'none';
        }
      });
    }

    // Function to validate username (no spaces allowed)
    function validateUsername(input) {
      const usernameError = document.getElementById("username-error");
      if (input.value.includes(" ")) {
        usernameError.textContent = "Username cannot contain spaces";
        input.style.borderColor = "red";
      } else {
        usernameError.textContent = "";
        input.style.borderColor = "";
      }
    }

    // Function to validate email format
    function validateEmail(input) {
      const emailError = document.getElementById("email-error");
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(input.value)) {
        emailError.textContent = "Please enter a valid email address";
        input.style.borderColor = "red";
      } else {
        emailError.textContent = "";
        input.style.borderColor = "";
      }
    }
  </script>
</head>

<body>
<div class="settings-page">
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
        <aside class="sidebar">
          <div class="profile-info">
            <img src="images/default-profile.png" alt="Profile Picture" class="profile-pic">
            <p class="username">John Doe</p>
          </div>
          <ul class="settings-menu">
            <li><a href="javascript:void(0);" onclick="toggleSection('profile')">Profile</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('account')">Account</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('password')">Change Password</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('delete')">Delete Account</a></li>
          </ul>
        </aside>

        <section class="settings-content">
          <h1>Account Settings</h1>

          <div id="profile" class="settings-section" style="display: block;">
            <h3>Profile Information</h3>
            <form id="profile-form" method="post" action="save-profile.php">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" value=""/>
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value=""/>
              <input type="submit" value="Save Changes" class="save-button"/>
            </form>
          </div>

          <div id="account" class="settings-section" style="display: none;">
            <h3>Account Settings</h3>
            <form id="account-settings-form" method="post" action="save-account-settings.php">
              <label for="full-name">Full Name</label>
              <input type="text" name="full-name" id="full-name" value="" required />
              
              <label for="username">Username</label>
              <input type="text" name="username" id="username" value="" required />
              
              <label for="email">Email Address</label>
              <input type="email" name="email" id="email" value="" required />
              
              <label for="phone">Phone Number</label>
              <input type="tel" name="phone" id="phone" value="" />
              
              <label for="address">Address</label>
              <input type="text" name="address" id="address" value="" />
              
              <h4>Privacy Settings</h4>
              <label for="email-preferences">Email Preferences</label>
              <select name="email-preferences" id="email-preferences">
                <option value="all">All Emails</option>
                <option value="updates">Only Updates</option>
                <option value="none">No Emails</option>
              </select>
              
              <label for="profile-picture">Profile Picture</label>
              <input type="file" name="profile-picture" id="profile-picture" />
              
              <input type="submit" value="Save Changes" class="save-button"/>
            </form>
          </div>
        </section>
      </div>
    </main>
  </div>
</div>

<footer>
  <p>CS 476: Software Development Project</p>
</footer>

</body>
</html>

