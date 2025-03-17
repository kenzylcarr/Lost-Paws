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

    // JavaScript to dynamically populate cities based on selected province
    const citiesByProvince = {
      BC: ['Vancouver', 'Victoria', 'Kelowna'],
      AB: ['Calgary', 'Edmonton', 'Lethbridge'],
      SK: ['Regina', 'Saskatoon', 'Moose Jaw'],
      MB: ['Brandon', 'Winnipeg', 'Churchill'],
      ON: ['Toronto', 'Ottawa', 'Hamilton'],
    };

    function updateCities() {
      const province = document.getElementById('province').value;
      const cityDropdown = document.getElementById('city');
      cityDropdown.innerHTML = '<option value="">Select City</option>'; // Clear previous cities

      if (province) {
        const cities = citiesByProvince[province] || [];
        cities.forEach(city => {
          const option = document.createElement('option');
          option.value = city.toLowerCase();
          option.textContent = city;
          cityDropdown.appendChild(option);
        });
        cityDropdown.disabled = false; // Enable city dropdown
      } else {
        cityDropdown.disabled = true; // Disable city dropdown if no province selected
      }
    }

    // Function to validate address format
    function validateAddress(input) {
      const addressError = document.getElementById("address-error");
      const addressPattern = /^[A-Za-z0-9\s,.'-]{3,}$/; // Simple check for valid address characters

      if (!addressPattern.test(input.value)) {
        addressError.textContent = "Please enter a valid address in the form 123 Main st.";
        input.style.borderColor = "red";
      } else {
        addressError.textContent = "";
        input.style.borderColor = "";
      }
    }

    // Validate Current Password
	function validateCurrentPassword(input) {
	  const password = input.value;
	  const errorMessage = document.getElementById("current-password-error");

	  // Regular expression to check for at least one capital letter, one special character, and minimum 6 characters
	  const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

	  if (!password.match(passwordRegex)) {
		errorMessage.textContent = "Password must be at least 6 characters, include one capital letter, and one special character.";
	  } else {
		errorMessage.textContent = "";
	  }
	}

	// Validate New Password
	function validatePassword(input) {
	  const password = input.value;
	  const errorMessage = document.getElementById("new-password-error");

	  // Regular expression to check for at least one capital letter, one special character, and minimum 6 characters
	  const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

	  if (!password.match(passwordRegex)) {
		errorMessage.textContent = "Password must be at least 6 characters, include one capital letter, and one special character.";
	  } else {
		errorMessage.textContent = "";
	  }
	}

	// Validate Confirm Password
	function validateConfirmPassword(input) {
	  const confirmPassword = input.value;
	  const newPassword = document.getElementById("new-password").value;
	  const errorMessage = document.getElementById("confirm-password-error");

	  if (confirmPassword !== newPassword) {
		errorMessage.textContent = "Passwords do not match.";
	  } else {
		errorMessage.textContent = "";
	  }
	}

	// Validate Current Password and New Password Cannot Be the Same
	function validatePasswordChange() {
	  const currentPassword = document.getElementById("current-password").value;
	  const newPassword = document.getElementById("new-password").value;
	  const currentPasswordError = document.getElementById("current-password-error");

	  if (currentPassword === newPassword) {
		currentPasswordError.textContent = "Old password and new password cannot be the same.";
		return false;
	  } else {
		currentPasswordError.textContent = "";
	  }
	  return true;
	}

  </script>
