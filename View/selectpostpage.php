<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: selectpostpage.php
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Post</title>
  <link rel="stylesheet" type="text/css" href="/View/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="container">
       <!-- Lost Paws Logo -->
      <div class="logo"> 
          <a href="index.php">
            <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="logo"/></p>
          </a>
      </div>
      <nav class="navmenu">
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
          <a href="/View/reportpetpage.php">Report a Pet</a>
          <a href="index.php">Lost & Found</a>
          <a href="/View/petmap.php">Pet Map</a>
        </div>
  
        <div class="button">
          <a id="signup-button" href="signup.php">Sign Up!</a>
          <a id="login-button" href="/View/login.php">Login</a>
        </div>
      </nav>
      
      <!-- Left Section: Map-->
      <main id="select-post-main-left">
        <a href="index.php"><button id="view-all-button">&#x1F804; View All Pets</button> </a>
        <h3>Location Last Seen</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d81279.3134140618!2d-104.66390488857418!3d50.460124225863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x531c1e40fba53deb%3A0x354a3296b77b54b1!2sRegina%2C%20SK!5e0!3m2!1sen!2sca!4v1740001571797!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </main>

      <!-- Center Section: Full Post Information-->
      <main id="select-post-main-center">
        <!-- Lost or Found Label -->
            <div class="lost-or-found-label">
                <h1>Lost Pet</h1>
            </div>
        <!-- Title of Post -->
            <div class="title-post">
              <h1>Title of Post</h1>  
            </div>
        <!-- Container for Information -->
            <div class="description-container">
              <!-- Column 1: Pet Photo, Contact User-->
              <div class="description-column1">
                <img alt="Photo of Pet">
                <p>Posted by: John Doe</p>
                <button id="contact-user-button">Contact User</button>
              </div>
              <!-- Column 2: Written Pet Description -->
              <div class="description-column2">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet ex vitae erat pretium eleifend. Ut aliquam orci in lectus sollicitudin, sed dictum nulla interdum. Nunc condimentum tortor ut enim maximus, non condimentum eros tincidunt. Cras ut suscipit nulla. Aliquam erat volutpat. Phasellus suscipit metus ut felis scelerisque, vel lacinia ligula sodales. Integer laoreet augue in eros dictum, sit amet aliquet velit fermentum. In tempor orci id nisl malesuada, et porttitor orci fermentum. Donec gravida sapien non gravida auctor. Fusce ac turpis varius, luctus odio sed, euismod purus. Integer venenatis, erat ac tincidunt placerat, eros velit dapibus urna, nec efficitur neque augue id dui. Curabitur vel ipsum a velit interdum gravida at at ligula. Pellentesque vel metus at sem varius tempor. Quisque vitae turpis malesuada, luctus nisi eu, cursus odio. Curabitur eget turpis eros. Phasellus at mi orci. Nullam vulputate augue sit amet dolor tristique, et volutpat orci eleifend. Vivamus nec vestibulum ante, sed tempor enim. Nulla viverra ac dui ac faucibus. Integer vulputate purus eu lorem feugiat, in sodales lorem gravida. Nulla facilisi. Vestibulum dapibus auctor arcu vel faucibus. Ut cursus quam vel bibendum vehicula. Suspendisse iaculis lorem ac vestibulum feugiat. Mauris eget felis felis. Ut facilisis ligula risus, sit amet auctor enim aliquam nec. Proin in lectus in dui auctor auctor non eu purus. Aenean sit amet diam vitae velit viverra auctor. Curabitur convallis tempor lectus, sit amet dapibus purus suscipit nec. Integer viverra vitae enim nec pretium. Pellentesque tincidunt fringilla nisi, eget convallis ipsum facilisis nec. Aliquam erat volutpat. Donec tempus, nisl a varius tempus, lectus magna dictum augue, nec posuere risus tortor a ipsum. Sed sit amet magna eu mi gravida gravida non vel justo. Proin sit amet lectus sapien. Nam malesuada elit vel purus iaculis lobortis. Nam condimentum risus eu arcu cursus, id tristique justo tincidunt. In gravida sapien non enim ullamcorper, sit amet tincidunt libero feugiat. Fusce suscipit tortor at risus congue tincidunt. Nam eleifend ac nisi non auctor. Nulla quis ante ac ligula venenatis iaculis. Quisque at tincidunt mi. Ut iaculis quam sapien, ac tincidunt odio volutpat eu. Mauris lobortis libero sed sollicitudin sodales. Nam et felis id ligula tempor sodales et vel magna. Etiam feugiat tristique lacus sed placerat. In lobortis tincidunt elit sed mollis. Nunc ut condimentum neque, ut cursus eros. Vivamus tristique orci a sapien vulputate, nec fermentum est scelerisque. Pellentesque non dui ex. Nullam non purus justo. Vivamus ac fermentum sapien, eu interdum lorem. Aenean sit amet laoreet libero. Mauris in suscipit lectus. Morbi nec eros vitae est tincidunt posuere. Fusce tincidunt, metus nec viverra interdum, ligula magna posuere eros, vel aliquet leo metus eget mauris. Integer egestas elit et magna dignissim, nec lacinia leo sollicitudin. Aenean sagittis sem nec orci ultricies mollis. In pharetra ligula et lectus luctus tempor. Sed eget maximus arcu, vel ultricies libero. Nunc elementum, ante eget convallis vestibulum, odio augue consectetur neque, eget tristique leo arcu in sapien. </p>
              </div>
            </div>
          
          <!-- Container for Comment Section -->
            <div class="comment-container">
              <h3>Comments</h3>
              <form action="">
                <input type="text" placeholder="Add a comment" name="comment">
            </form>
            </div>
      </main>
  
      <!-- Right Section: User Prompt to Signup/Login-->
      <main id="select-post-main-right">
        <h3>Sign in to get alerts and to connect with your community!</h3>
        <p>Don't have an account?<a class="signup-button" href="/View/signup.php">Register</a></p>
      </main>
  
    </div>
  </body>
  
  <footer>
    <p>CS 476: Software Development Project</p>
  </footer>
  
  </html>
