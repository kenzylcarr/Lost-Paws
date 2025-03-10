<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: petmap.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Find lost and found pets in your area with the Lost Paws interactive pet map.">
  <title>Pet Map | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="container">
  
	  <!-- Lost Paws Logo -->
    <nav class="navmenu">
        <div class="logo"> 
            <a href="mainpage.php">
			<p><img src="images/Logo.jpg" alt="Lost Paws Logo" class="logo"/></p>
		</a>
        </div>

      <!-- Navigation menu -->
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="reportpetpage.php">Report a Pet</a>
        <a href="mainpage-beforelogin.php">Lost & Found</a> 	<!-- Was seclectpostpage before (?) -->
        <a href="petmap.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="signup-button" href="signup.php">Sign Up!</a>
        <a id="login-button" href="login.php">Login</a>
      </div>
    </nav>

    <main>
      <div id="petmap-container">
        <!-- Centered Toggle and Filter Section -->
        <div id="filter-section">
          <label class="switch">
            <input type="checkbox" id="toggle-lost-found">
            <span class="slider round"></span>
          </label>
          <span id="toggle-label">Lost Pets</span>

          <!-- Dropdown Filter for Pet Type -->
          <select id="pet-type-filter">
            <option value="all">All Pets</option>
            <option value="feline">Feline</option>
            <option value="canine">Canine</option>
            <option value="other">Other</option>
          </select>
        </div>

        <!-- Embedded Google Map -->
        <div id="petmap-map">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" 
            width="100%" 
            height="600" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleSwitch = document.getElementById("toggle-lost-found");
      const toggleLabel = document.getElementById("toggle-label");
      const petFilter = document.getElementById("pet-type-filter");

      toggleSwitch.addEventListener("change", function () {
        toggleLabel.textContent = this.checked ? "Found Pets" : "Lost Pets";
        updateMap();
      });

      petFilter.addEventListener("change", function () {
        updateMap();
      });

      function updateMap() {
        const isFoundPets = toggleSwitch.checked;
        const selectedType = petFilter.value;

        console.log(`Displaying ${isFoundPets ? "Found" : "Lost"} Pets of type: ${selectedType}`);

        // Placeholder for map update logic
        // This would involve updating markers dynamically based on filters
      }
    });
  </script>

</body>

<footer>
  <p>CS 476: Software Development Project</p>
</footer>

</html>

