<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: lostandfound.php
-->

<!-- PHP validation for the form begins -->
<?php
  session_start();
  require_once("../Model/db_config.php");

  // Get the 'status' parameter from the URL (if present)
  $status = isset($_GET['status']) ? $_GET['status'] : '';
  $search = isset($_GET['search']) ? trim($_GET['search']) : '';                      //!

  // Fetch pet data from database, with filtering based on status if present
  $pets = [];
  $query = "SELECT pet_id, animal_type, status, location_ip, picture FROM pets";
  if ($status == 'lost' || $status == 'found') {
      $query .= " WHERE status = ?";
  }

  // Searching using key words
  if(!empty($search))                                                                   //!
  {
    $query .= ($status == 'lost' || $status == 'found') ? " AND" : " WHERE";
    $query .= " (animal_type LIKE ? OR location_ip LIKE ?)";
  }

  $stmt = $conn->prepare($query);

  // If filtering by status, bind the parameter
  if (!empty($search) && ($status == 'lost' || $status == 'found'))
  {
    $searchWildcard = "%$search%";
    $stmt->bind_param("sss", $status, $searchWildcard, $searchWildcard);
  }
  elseif (!empty($search))
  {
    $searchWildcard = "%$search%";
    $stmt->bind_param("ss", $searchWildcard, $searchWildcard);
  }
  elseif ($status == 'lost' || $status == 'found')
  {
    $stmt->bind_param("s", $status);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $pets[] = $row;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Lost & Found | Lost Paws</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div id="mainpage-container">
       <!-- Lost Paws Logo -->
      <nav class="navmenu">
          <div class="logo"> 
            <a href="../index.php">
              <p><img src="images/lp-logo.png" alt="Lost Paws Logo" class="nav-logo"/></p>
            </a>
          </div>
  
        <!-- Navigation menu -->
        <div class="nav-links">
          <a href="/View/aboutpage.php">About Lost Paws</a>
          <a href="/View/petmap-visitor.php">Pet Map</a>
        </div>
  
        <div class="button">
          <p>Already have an account? </p>
          <a id="login-button" href="/View/login.php">Login</a>
        </div>
      </nav>
      
      <main id="lost-found-database">
        <!-- Lost or Found Buttons Row -->
        <div class="lost-found-search-container">
          <div class="lost-or-found-buttons">
               <button id="all-button">All Pets</button>
               <button id="lost-button">Lost Pets</button>
               <button id="found-button">Found Pets</button>
          </div>
          
          <!-- Search and Filter Row -->
          <div class="search-field">
                <form action="lostandfound.php" method="GET">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit" value="Search"><i class="fa fa-search"></i></button>
                </form>
          </div>
        </div>

        <div class="pet-database-container"> 
        <?php foreach ($pets as $pet): ?>
              <div class="pet-brief-info">
                <img src="<?php echo htmlspecialchars($pet['picture']); ?>" alt="Photo of a <?php echo htmlspecialchars($pet['animal_type']); ?>">
                <p> Type: <?php echo htmlspecialchars($pet['animal_type']); ?></p>
                <p> Status: <?php echo htmlspecialchars($pet['status']); ?></p>
                <p> Location: <?php echo htmlspecialchars($pet['location_ip']); ?></p>
                <p><a href="/View/viewpet_visitor.php?id=<?php echo $pet['pet_id']; ?>">View Post</a></p>
              </div>
              <?php endforeach; ?>
        </div>
      </main>
  
      <main id="mainpage-right-beforelogin">
      <h3>Join us and connect with your community today!</h3>
        <p>Don't have an account?  <a id="signup-button" href="/View/signup.php">Sign Up!</a></p>
      </main>
    </div>

      <!-- Adding JavaScript to handle lost-or-found button clicks -->
    <script>
      // when the "All Pets" button is clicked
      document.getElementById('all-button').addEventListener('click', function() {
        window.location.href = window.location.pathname;
      });

      // when the "Lost Pets" button is clicked
      document.getElementById('lost-button').addEventListener('click', function() {
        window.location.href = "?status=lost";  // update URL with status parameter
      });

      // when the "Found Pets" button is clicked
      document.getElementById('found-button').addEventListener('click', function() {
        window.location.href = "?status=found";  // update URL with status parameter
      });

      // searching while real-time filtering                                                        //!
      document.addEventListener("DOMContentLoaded", function()
      {
        const searchInput = document.querySelector(".search-field input");
        const petCards = document.querySelectorAll(".pet-brief-info");
        
        searchInput.addEventListener("keyup", function()
        {
          const searchTerm = searchInput.value.toLowerCase();

          petCards.forEach(pet => 
          {
            const petType = pet.querySelector("p:nth-of-type(1)").textContent.toLowerCase();
            const location = pet.querySelector("p:nth-of-type(3)").textContent.toLowerCase();

            if (petType.includes(searchTerm) || location.includes(searchTerm))
              pet.style.display = "block";
            else
              pet.style.display = "none";
          });
        });
      });

    </script>
  </body>
  </html>
