<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: reportpetpage.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Report A Pet</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="reportpet-page">
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
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="reportpetpage.php">Report a Pet</a>
        <a href="lostandfound.php">Lost & Found</a>	
        <a href="petmap.php">Pet Map</a>
      </div>

      <div class="button">
        <a id="signup-button" href="signup.php">Sign Up!</a>
        <a id="login-button" href="login.php">Login</a>
      </div>
    </nav>
    
      <main>
	  
        <h1> Report a Lost or Found Pet:</h1>
        <div class="container">
            <div class="map-container">
                <h2>Drop a pin on the map:</h2>
              
              <div class="map">
   		 <iframe 
        width="100%" 
        height="400px" 
        frameborder="0" 
        style="border:0" 
        allowfullscreen 
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
   		 </iframe>
			</div>
            </div>
            
          <div class="form-container">
                <p> Report a pet by providing the following information!</p>
				</br>
                
                <!-- Embedded Form -->
                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeX-rwts6_gJn5A0nXWU2nHLG06chqNJUSW3mN022037sx4FA/viewform?usp=header" width="100%" height="500px" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
		</br>
		
		<div class="upload-container">
			<p><strong>Please upload 1-5 images of your pet:</strong></p>
			<input type="file" id="petImages" name="petImages" accept="image/*" multiple>
			<label for="petImages">Choose Files</label> <!-- Custom "Choose Files" button -->
			<button type="submit" id="submitImages" class="upload-button">Submit Images</button>
		</div>
      </div>

	</main>
</html>
