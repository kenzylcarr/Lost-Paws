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

<!-- PHP validation for the form begins -->
<?php
session_start();
require_once("../Model/db_config.php");

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit();
}

// Fetch user data from database
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT user_id, email_address, phone_number, profile_photo FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  $user_id = $user['user_id'];
} else {
  echo "User not found.";
  exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Account Settings</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <script src="../Controller/eventHandler.js"></script>
  <script>
    
    // JavaScript function to toggle visibility of sections
    function toggleSection(sectionId) {
      const sections = document.querySelectorAll('.settings-section');
      sections.forEach(section => {
        section.style.display = section.id === sectionId ? 'block' : 'none';
      });
    }

    // Function to validate username (only letters and numbers allowed)
    function validateUsername(input) {
      const usernameError = document.getElementById(input.id + "-error");
      const usernamePattern = /^[A-Za-z0-9]+$/; // Only allows letters and numbers

      if (input.value.trim() === "") {
        usernameError.textContent = "Username cannot be empty.";
        input.style.borderColor = "red";
      } else if (!usernamePattern.test(input.value)) {
        usernameError.textContent = "Username can only contain letters and numbers (no spaces or special characters).";
        input.style.borderColor = "red";
      } else {
        usernameError.textContent = "";
        input.style.borderColor = "";
      }
    }

    // Function to validate email format
    function validateEmail(input) {
      const emailError = document.getElementById(input.id + "-error");
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(input.value)) {
        emailError.textContent = "Please enter a valid email address";
        input.style.borderColor = "red";
      } else {
        emailError.textContent = "";
        input.style.borderColor = "";
      }
    }

    // Function to validate Full Name (Only letters & spaces, Auto Title Case)
    function validateFullName(input) {
      const fullNameError = document.getElementById("fullname-error");
      const namePattern = /^[A-Za-z]+(?:\s[A-Za-z]+)*$/;

      // Automatically format name to "Title Case"
      input.value = input.value
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());

      if (!namePattern.test(input.value)) {
        fullNameError.textContent = "Full name can only contain letters and spaces.";
        input.style.borderColor = "red";
      } else {
        fullNameError.textContent = "";
        input.style.borderColor = "";
      }
    }

    // Function to validate phone number format
    function validatePhoneNumber(input) {
      const phoneError = document.getElementById("phone-error");
      // Regular expression to match the three formats
      const phonePattern = /^(?:\(\d{3}\)\s?\d{3}-\d{4}|\d{10}|\d{3}-\d{3}-\d{4})$/;

      if (input.value && !phonePattern.test(input.value)) {
        phoneError.textContent = "Phone number must be in one of the following formats: (000) 000-0000, 0000000000, or 000-000-0000.";
        input.style.borderColor = "red";
      } else {
        phoneError.textContent = "";
        input.style.borderColor = "";
      }
    }

// Keep this for future updates
    // JavaScript to dynamically populate cities based on selected province
    // const citiesByProvince = {
    //   BC: ['Vancouver', 'Victoria', 'Kelowna'],
    //   AB: ['Calgary', 'Edmonton', 'Lethbridge'],
    //   SK: ['Regina', 'Saskatoon', 'Moose Jaw'],
    //   MB: ['Brandon', 'Winnipeg', 'Churchill'],
    //   ON: ['Toronto', 'Ottawa', 'Hamilton'],
    // };

    // function updateCities() {
    //   const province = document.getElementById('province').value;
    //   const cityDropdown = document.getElementById('city');
    //   cityDropdown.innerHTML = '<option value="">Select City</option>'; // Clear previous cities

    //   if (province) {
    //     const cities = citiesByProvince[province] || [];
    //     cities.forEach(city => {
    //       const option = document.createElement('option');
    //       option.value = city.toLowerCase();
    //       option.textContent = city;
    //       cityDropdown.appendChild(option);
    //     });
    //     cityDropdown.disabled = false; // Enable city dropdown
    //   } else {
    //     cityDropdown.disabled = true; // Disable city dropdown if no province selected
    //   }
    // }

    // Function to validate address format
    // function validateAddress(input) {
    //   const addressError = document.getElementById("address-error");
    //   const addressPattern = /^[A-Za-z0-9\s,.'-]{3,}$/; // Simple check for valid address characters

    //   if (!addressPattern.test(input.value)) {
    //     addressError.textContent = "Please enter a valid address in the form 123 Main st.";
    //     input.style.borderColor = "red";
    //   } else {
    //     addressError.textContent = "";
    //     input.style.borderColor = "";
    //   }
    // }
// end code for address
	  
	    // Validate Current Password
	function validateCurrentPassword(input) {
	  const password = input.value;
	  const errorMessage = document.getElementById("current-password-error");
	
	  // Regular expression to check for at least one capital letter, one special character, and minimum 6 characters
	  const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;
	
	  if (!password.match(passwordRegex)) {
	    errorMessage.textContent = "Password must be at least 6 characters, include one capital letter, and one special character.";
	    input.style.borderColor = "red";
	  } else {
	    errorMessage.textContent = ""; // Clear error message when validation passes
	    input.style.borderColor = ""; // Reset the border color to default
	  }
	}
	
	// Validate New Password
	function validatePassword(input) {
	  const password = input.value;
	  const errorMessage = document.getElementById("new-password-error");
	
	  // Regular expression to check for at least one capital letter, one special character, and minimum 6 characters
	  const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;
	
	  if (!password.match(passwordRegex)) {
	    errorMessage.textContent = "Password must 6 characters, include one capital letter, and one special character.";
	    input.style.borderColor = "red";
	  } else {
	    errorMessage.textContent = ""; // Clear error message when validation passes
	    input.style.borderColor = ""; // Reset the border color to default
	  }
	}
	
	// Validate Confirm Password
	function validateConfirmPassword(input) {
	  const confirmPassword = input.value;
	  const newPassword = document.getElementById("new-password").value;
	  const errorMessage = document.getElementById("confirm-password-error");
	
	  if (confirmPassword !== newPassword) {
	    errorMessage.textContent = "Passwords do not match.";
	    input.style.borderColor = "red";
	  } else {
	    errorMessage.textContent = ""; // Clear error message when passwords match
	    input.style.borderColor = ""; // Reset the border color to default
	  }
	}
  </script>
</head>

<body>
  <div class="settings-page">
  <div id="mainpage-container">
      <nav class="navmenu">
        <div class="logo"> 
          <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
        </div>
        <div class="nav-links">
          <a href="homepage.php">Homepage</a>
          <a href="reportpetpage.php">Report a Pet</a>
        </div>
        <div class="button">
          <a id="login-button" href="logout.php">Logout</a>
        </div>
      </nav>

      <main id="account-settings-main">
        <div class="settings-container">
          <!-- Sidebar -->
          <aside class="sidebar">
            <div class="profile-info">
              <div class="user-photo">
                <img src="/View/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="user photo" />
              </div>
              <p><?php echo htmlspecialchars($username); ?></p>
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
                <label for="profile-username">Username</label>
                <input type="text" name="username" id="profile-username" value="" oninput="validateUsername(this)" />
                <p id="profile-username-error" class="error-message"></p>

                <label for="profile-email">Email</label>
                <input type="email" name="email" id="profile-email" value="" oninput="validateEmail(this)" />
                <p id="profile-email-error" class="error-message"></p>

                <input type="submit" value="Save Changes" class="save-button" />
              </form>
            </div>

            <!-- Account Section -->
            <div id="account" class="settings-section" style="display: none;">
              <h3>Account Settings</h3>
              <p>Here you can update your account settings.</p>

              <form id="account-settings-form" method="post" action="save-account-settings.php">
                <!-- Full Name -->
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" id="fullname" value="" required oninput="validateFullName(this)" />
                <p id="fullname-error" class="error-message"></p>

                <!-- Username -->
                <label for="account-username">Username</label>
                <input type="text" name="username" id="account-username" value="" required oninput="validateUsername(this)" />
                <p id="account-username-error" class="error-message"></p>

                <!-- Email Address -->
                <label for="account-email">Email Address</label>
                <input type="email" name="email" id="account-email" value="" required oninput="validateEmail(this)" />
                <p id="account-email-error" class="error-message"></p>

                <!-- Phone Number -->
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" value="" oninput="validatePhoneNumber(this)" />
                <p id="phone-error" class="error-message"></p>

                <!-- Province -->
                <!-- <label for="province">Province</label>
                <select name="province" id="province" onchange="updateCities()">
                  <option value="">Select Province</option>
                  <option value="BC">British Columbia</option>
                  <option value="AB">Alberta</option>
                  <option value="SK">Saskatchewan</option>
                  <option value="MB">Manitoba</option>
                  <option value="ON">Ontario</option>
                </select> -->

                <!-- City -->
                <!-- <label for="city">City</label>
                <select name="city" id="city" disabled>
                  <option value="">Select City</option>
                </select> -->

                <!-- Address -->
                <!-- <label for="address">Address</label>
                <input type="text" name="address" id="address" value="" required oninput="validateAddress(this)" />
                <p id="address-error" class="error-message"></p> -->

                <input type="submit" value="Save Changes" class="save-button" />
              </form>
            </div>

            <!-- Change Password Section -->
			<div id="password" class="settings-section" style="display: none;">
			  <h3>Change Password</h3>
			  <form id="change-password-form" method="post" action="save-password.php" onsubmit="return validatePasswordChange()">
				
				<!-- Current Password -->
				<label for="current-password">Current Password</label>
				<input type="password" name="current-password" id="current-password" required oninput="validateCurrentPassword(this)" />
				<p id="current-password-error" class="error-message"></p>

				<!-- New Password -->
				<label for="new-password">New Password</label>
				<input type="password" name="new-password" id="new-password" required oninput="validatePassword(this)" />
				<p id="new-password-error" class="error-message"></p>

				<!-- Confirm New Password -->
				<label for="confirm-password">Confirm New Password</label>
				<input type="password" name="confirm-password" id="confirm-password" required oninput="validateConfirmPassword(this)" />
				<p id="confirm-password-error" class="error-message"></p>

				<input type="submit" value="Save Changes" class="save-button" />
			  </form>
			</div>

            <!-- Delete Account Section -->
            <div id="delete" class="settings-section" style="display: none;">
              <h3>Delete Account</h3>
              <p>Once your account is deleted, you will not be able to recover it. This action is permanent.</p>
              <button class="delete-button">Delete Account</button>
            </div>
			
          </section>
        
	</div>
      </main>
    
    </div>
  </div>

</body>
</html>

