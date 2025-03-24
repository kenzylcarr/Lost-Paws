<!--
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: messages.php
-->

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
  $stmt = $conn->prepare("SELECT user_id, first_name, last_name, email_address, phone_number, profile_photo FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user_data = $result->fetch_assoc();

  if ($user_data) {
    $user_id = $user_data['user_id'];
    $first_name = $user_data['first_name'];
    $last_name = $user_data['last_name'];
  } else {
      echo "User not found.";
      exit();
  }
  try {
    // Fetch conversation where the user is either the sender or receiver
    $query = "SELECT M.*, U1.username AS sender_name, U2.username AS receiver_name
              FROM messages M
              JOIN users U1 ON M.sender_id = U1.user_id
              JOIN users U2 ON M.receiver_id = U2.user_id
              WHERE M.sender_id = ? OR M.receiver_id = ?
              ORDER BY M.timestamp DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Categorize messages by the conversation
    $conversations = [];
    while ($msg = $result->fetch_assoc()) {
      $key = min($msg['sender_id'], $msg['receiver_id']) . '-' . max($msg['sender_id'], $msg['receiver_id']);
      // if ($msg['pet_id']) {
      //   $key .= '-' . $msg['pet_id'];
      // }
      $conversations[$key][] = $msg;
    }
    
    // Query to fetch sent messages
    $sentMessagesQuery = "SELECT M.*, U1.username AS sender_name, U2.username AS receiver_name
                          FROM messages M
                          JOIN users U1 ON M.sender_id = U1.user_id
                          JOIN users U2 ON M.receiver_id = U2.user_id
                          WHERE M.sender_id = ?
                          ORDER BY M.timestamp DESC";
    $stmt = $conn->prepare($sentMessagesQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $sentMessages = $stmt->get_result();

    // Query to fetch received messages
    $receivedMessagesQuery = "SELECT M.*, U1.username AS sender_name, U2.username AS receiver_name
                           FROM messages M
                           JOIN users U1 ON M.sender_id = U1.user_id
                           JOIN users U2 ON M.receiver_id = U2.user_id
                           WHERE M.receiver_id = ?
                           ORDER BY M.timestamp DESC";
    $stmt = $conn->prepare($receivedMessagesQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $receivedMessages = $stmt->get_result();

  } catch (mysqli_sql_exception $e) {
    die ("Database error: " . $e->getMessage());
  }

  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['send_message'])) {

    // Retrieve form data
    $recipient_id = $_POST['recipient'];
    $pet_status = $_POST['pet_status'];
    $message_content = $_POST['message'];
    // Get the current timestamp
    $timestamp = date('Y-m-d H:i:s');

    // Prepare the SQL query to insert the message into the database
    try {
      $insertQuery = "INSERT INTO messages (sender_id, receiver_id, pet_status, content, timestamp) 
                      VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insertQuery);
      $stmt->bind_param("iisss", $user_id, $recipient_id, $pet_status, $message_content, $timestamp);
      $stmt->execute();

    // Redirect back to the messages page after sending the message
      header("Location: messages.php");
      exit();
      } catch (mysqli_sql_exception $e) {
      die("Database error: " . $e->getMessage());
      }
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Messages</title>
  <link rel="stylesheet" type="text/css" href="/View/CSS/style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/messages-style.css">
  <link rel="stylesheet" type="text/css" href="/View/CSS/mainpage-style.css">

  <script src="../Controller/eventHandler.js"></script>

  <!-- START SENT RECEIVED SWITCH TEST -->
        
  <script>
          function submitPet() {
            // Get values from the form
            let petStatus = document.getElementById("petStatus").value;
            let petMessage = document.getElementById("petMessage").value.trim();

            if (petMessage === "") {
                alert("Please enter a message.");
                return;
            }

            // Create a new list item
            let listItem = document.createElement("li");
            listItem.textContent = petMessage;

            // Append to the correct list
            if (petStatus === "lost") {
                document.getElementById("lostList").appendChild(listItem);
            } else {
                document.getElementById("foundList").appendChild(listItem);
            }

            // Clear the message box after submission
            document.getElementById("petMessage").value = "";
        }

           // Function to toggle between Lost & Found tabs
        function toggleTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });

           // Show the selected tab
            document.getElementById(tabId).style.display = 'block';

           // Remove 'active' class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Add 'active' class to clicked button
            document.querySelector(`[onclick="toggleTab('${tabId}')"]`).classList.add('active');
        }    
        </script>

<!-- END SENT RECEIVED SWITCH TEST -->
  
</head>

<body>
  <div class="messages-page">
  <div id="container">
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

    <main id="mainpage-right-afterlogin">
        <div class="user-photo">
          <img src="../View/uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="user photo" />
        </div>
    
        <div class="user-name">
          <p><?php echo htmlspecialchars($first_name ?? '', ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($last_name ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
          <p><?php echo htmlspecialchars($username); ?></p>
        </div>
    
        <div class="user-options">
            <p><a href="/View/myposts.php">View My Posts</a></p>	
            <!-- <p><a href="/View/accountpage.php">Account Settings</a></p>	 -->
            <p><a href="/View/messages.php">Messages</a></p>
        </div>
      </main>
    </div>

    <main id="messages-main">
      <div class="messages-container">
        <h1>Your Messages</h1>

        <!-- Tabs for Lost Pets and Found Pets -->
        <div class="tabs">
          <button onclick="toggleTab('sent-messages-tab')" class="tab-button">Sent Messages</button>
          <button onclick="toggleTab('received-messages-tab')" class="tab-button">Received Messages</button>
        </div>

        <div class="create-message">
          <h3>Send a Message</h3>
          <form action="messages.php" method="POST">
            <label for="recipient">Recipient:</label>
            <select name="recipient" id="recipient" required>
              
              <!-- Dynamically add users to the list -->
              <?php
                $userQuery = "SELECT user_id, username FROM users WHERE user_id != ?";
                $stmt = $conn->prepare($userQuery);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $users = $stmt->get_result();

                while ($user = $users->fetch_assoc()) {
                  echo "<option value='" . $user['user_id'] . "'>" . htmlspecialchars($user['username']) . "</option>";
                }
              ?>

              </select><br><br>
              <label for="pet_status">Pet Status:</label>
              <select name="pet_status" id="pet_status" required>
                <option value="lost">Lost</option>
                <option value="found">Found</option>
              </select><br><br>

              <label for="message">Message:</label><br>
              <textarea name="message" id="message" rows="4" placeholder="Enter your message here..." required></textarea><br><br>
              
              <button type="submit" name="send_message">Send</button>
          </form>
        </div>
        
        <!-- Sent Messages Tab Content -->
        <div id="sent-messages-tab" class="tab-content" style="display: block;">
          <div class="conversation-list">
          <?php while ($message = $sentMessages->fetch_assoc()): ?>
              <div class="conversation-item" onclick="toggleConversation('conv-<?php echo $message['message_id']; ?>')">
                <div class="conversation-header">
                  <p><strong><?php echo htmlspecialchars($message['receiver_name']); ?></strong></p>
                  <p><small>Last message: <?php echo isset($message['content']) ? htmlspecialchars($message['content']) : 'No messages yet'; ?></small></p>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>

          <!-- Received Messages Tab Content -->
          <div id="received-messages-tab" class="tab-content" style="display: block;">
          <div class="conversation-list">

          <?php while ($message = $receivedMessages->fetch_assoc()): ?>
              <div class="conversation-item" onclick="toggleConversation('conv-<?php echo $message['message_id']; ?>')">
                <div class="conversation-header">
                  <p><strong><?php echo htmlspecialchars($message['sender_name']); ?></strong></p>
                  <p><small>Last message: <?php echo isset($message['content']) ? htmlspecialchars($message['content']) : 'No messages yet'; ?></small></p>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>

      <!-- Message Thread for Sent Messages (Conversation 1) -->     
      <div class="message-thread" id="sent-conversation1" style="display: none;">
        <?php
        // Assuming you have a valid connection to the database
        $messagesQuery = "SELECT * FROM messages WHERE conversation_id = ?";
        $stmt = $conn->prepare($messagesQuery);
        $stmt->bind_param("i", $conversation_id); // Set conversation_id for the thread
        $stmt->execute();
        $messages = $stmt->get_result();

        while ($message = $messages->fetch_assoc()) {
            $sender = isset($message['sender_name']) ? htmlspecialchars($message['sender_name']) : 'Unknown';
            $content = isset($message['content']) ? htmlspecialchars($message['content']) : 'No content available';
            $direction = ($conversation['sender_id'] == $user_id) ? 'sent' : 'received';

          // Display the message content
            echo "<div class='message-item $direction'>
                      <p><strong>$sender:</strong> $content</p>
                  </div>";
        }
        ?>
        <!-- Input Box to Send Message -->
        <textarea id="reply-message-found1" placeholder="Type a message..." rows="4"></textarea>
        <button class="send-reply">Send</button>
      </div>

    <!-- Input Box to Send Message -->
    <textarea id="reply-message-lost1" placeholder="Type a message..." rows="4"></textarea>
    <button class="send-reply">Send</button>
<!-- </div> -->

  <!-- Message Thread for Received Messages (Conversation 1) -->
  <div class="message-thread" id="received-conversation1" style="display: none;">
      <?php 
        // Assuming you have a valid connection to the database
        $messagesQuery = "SELECT * FROM messages WHERE conversation_id = ? AND recipient_id = ?";
        $stmt = $conn->prepare($messagesQuery);
        $stmt->bind_param("i", $conversation_id, $user_id); // Set conversation_id for the thread
        $stmt->execute();
        $messages = $stmt->get_result();

        while ($message = $messages->fetch_assoc()) {
          $sender = isset($message['sender_name']) ? htmlspecialchars($message['sender_name']) : 'Unknown';
          $content = isset($message['content']) ? htmlspecialchars($message['content']) : 'No content available';

          // Display the message content
          echo "<div class='message-item $direction'>
                    <p><strong>$sender:</strong> $content</p>
                </div>";
        }
      ?>  
  </div>
  </main>
</div>  
</body>
</html>
