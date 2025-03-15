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
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
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
        <a href="lostandfound.php">Lost & Found</a>
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
            <li><a href="javascript:void(0);" onclick="toggleSection('profile')">Profile</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('account')">Account</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('password')">Change Password</a></li>
            <li><a href="javascript:void(0);" onclick="toggleSection('delete')">Delete Account</a></li>
          </ul>
        </aside>

        <!-- Main Content -->
        <section class="settings-content">
          <h1>Account Settings</h1>

          <!-- Profile Section -->
          <div id="profile" class="settings-section" style="display: block;">
            <h3>Profile Information</h3>
            <form id="profile-form" method="post" action="save-profile.php">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" value="JohnDoe"/>
              <label for="email">Email</label>
              <input type="email" name="email" id="email" value="johndoe@example.com"/>
              <input type="submit" value="Save Changes" class="save-button"/>
            </form>
          </div>

          <!-- Account Section -->
		<div id="account" class="settings-section" style="display: none;">
		  <h3>Account Settings</h3>
		  <p>Here you can update your account settings.</p>
		  
		  <form id="account-settings-form" method="post" action="save-account-settings.php">
			<!-- Full Name -->
			<label for="full-name">Full Name</label>
			<input type="text" name="full-name" id="full-name" value="John Doe" required />
			
			<!-- Username -->
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="JohnDoe123" required />
			
			<!-- Email Address -->
			<label for="email">Email Address</label>
			<input type="email" name="email" id="email" value="johndoe@example.com" required />
			
			<!-- Phone Number -->
			<label for="phone">Phone Number</label>
			<input type="tel" name="phone" id="phone" value="123-456-7890" />

			<!-- Address -->
			<label for="address">Address</label>
			<input type="text" name="address" id="address" value="123 Main St, City, Country" />

			<!-- Privacy Settings (Optional) -->
			<h4>Privacy Settings</h4>
			<label for="email-preferences">Email Preferences</label>
			<select name="email-preferences" id="email-preferences">
			  <option value="all">All Emails</option>
			  <option value="updates">Only Updates</option>
			  <option value="none">No Emails</option>
			</select>

			<!-- Profile Picture (Optional) -->
			<label for="profile-picture">Profile Picture</label>
			<input type="file" name="profile-picture" id="profile-picture" />
			
			<!-- Save Changes Button -->
			<input type="submit" value="Save Changes" class="save-button"/>
		  </form>
		</div>

		 <!-- Change Password Section -->
          <div id="password" class="settings-section" style="display: none;">
            <h3>Change Password</h3>
            <form id="password-form" method="post" action="change-password.php">
              <label for="old-password">Old Password</label>
              <input type="password" name="old-password" id="old-password" required/>
              <label for="new-password">New Password</label>
              <input type="password" name="new-password" id="new-password" required/>
              <input type="submit" value="Change Password" class="save-button"/>
            </form>
          </div>

          <!-- Delete Account Section -->
          <div id="delete" class="settings-section" style="display: none;">
            <h3>Delete Account</h3>
            <p>Are you sure you want to delete your account? This action is irreversible.</p>
            <form id="delete-form" method="post" action="delete-account.php">
              <input type="submit" value="Delete Account" class="save-button"/>
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

