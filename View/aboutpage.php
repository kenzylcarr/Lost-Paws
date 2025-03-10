<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: aboutpage.php
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>About Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/style.css">
  <script src="https://kit.fontawesome.com/da5adf624f.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="container">
     <!-- Lost Paws Logo -->
    <nav class="navmenu">
        <div class="logo"> 
            <a href="/View/mainpage.php">
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
    
    <main id="aboutPage-info">
        <div id="aboutPage-row1">
            <div class="aboutPage-description"> 
                <h1>About Lost Paws</h1>
                <p class="description">Welcome to Lost Paws, a project dedicated to reuniting lost pets with their loving families. Our platform allow users to post about their lost pets and 
                    connect them with stray animal sightings from community members, making it easier to help animals find their way home. Whether your furry friend has wandered 
                    off or you've found an animal in need of help, we are here to support you in every step of the way. We believe that every pet deserves to be safe, and 
                    we are here to make sure no one has to search alone. Thank you for being part of a community that cares.</p>
            </div>
            <div class="aboutPage-photo1"> 
                <img>   
            </div>
            <div class="aboutPage-map"> 
                <h3>Check Out Our Map!</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div id="aboutPage-row2">
            <div class="aboutPage-offer"> 
                <h3>What We Offer</h3>
                    <p> * Geo-location Service</p>
                    <p> * Real-time Communication</p>
                    <p> * Advance Search Bar/Filter</p>
            </div>
            <div class="aboutPage-photo2"> 
                <img>
            </div>
            <div class="aboutPage-mission-statement"> 
                <h3>Mission Statement</h3>
                <p class="description">At Lost Paws, our mission is to reunite lost pets with their families by providing a compassionate, community-driven platform. We strive to make pet 
                    recovery easier through real-time alerts, verified reports, and seamless connections between pet owners and kind-hearted finders. Our goal is to ensure 
                    that no lost pet goes unnoticed and that every animal has the best chance of returning home safely. Together, we can create a world where no one has to 
                    search alone.</p>
            </div>   
        </div>
      </main>

    <main id="main-left">
      
    </main>

    <main id="main-bottom">

    </main>

  </div>
</body>
<footer>
  <p>CS 476: Software Development Project</p>
</footer>
</html>
