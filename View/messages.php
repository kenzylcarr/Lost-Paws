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
$user_id = $user_data['user_id'];

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
    if ($msg['pet_id']) {
      $key .= '-' . $msg['pet_id'];
    }
    $conversations[$key][] = $msg;
  }

  // For lost pets
  $lostPetsQuery = "SELECT M.*, U1.username AS sender_name, U2.username AS receiver_name
                    FROM messages M
                    JOIN users U1 ON M.sender_id = U1.user_id
                    JOIN users U2 ON M.receiver_id = U2.user_id
                    WHERE M.pet_status = 'lost' AND (M.sender_id = ? OR M.receiver_id = ?)
                    ORDER BY M.timestamp DESC";
  $stmt = $conn->prepare($lostPetsQuery);
  $stmt->bind_param("ii", $user_id, $user_id);
  $stmt->execute();
  $lostMessages = $stmt->get_result();


  // For found pets
  $foundPetsQuery = "SELECT M.*, U1.username AS sender_name, U2.username AS receiver_name
                     FROM messages M
                     JOIN users U1 ON M.sender_id = U1.user_id
                     JOIN users U2 ON M.receiver_id = U2.user_id
                     WHERE M.pet_status = 'found' AND (M.sender_id = ? OR M.receiver_id = ?)
                     ORDER BY M.timestamp DESC";
  $stmt = $conn->prepare($foundPetsQuery);
  $stmt->bind_param("ii", $user_id, $user_id);
  $stmt->execute();
  $foundMessages = $stmt->get_result();


} catch (mysqli_sql_exception $e) {
  die ("Database error: " . $e->getMessage());
}

// Check if the form is submitted
if (isset($_POST['send_message'])) {

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
  <script src="../Controller/eventHandler.js"></script>
  <script>
    // JavaScript function to toggle between tabs (Lost Pets and Found Pets)
    function toggleTab(tabId) {
      const tabs = document.querySelectorAll('.tab-content');
      tabs.forEach(tab => {
        if (tab.id === tabId) {
          tab.style.display = 'block';
        } else {
          tab.style.display = 'none';
        }
      });
    }

    // JavaScript function to toggle conversation threads
    function toggleConversation(conversationId) {
      const threads = document.querySelectorAll('.message-thread');
      threads.forEach(thread => {
        if (thread.id === conversationId) {
          thread.style.display = thread.style.display === 'none' ? 'block' : 'none';
        } else {
          thread.style.display = 'none';
        }
      });
    }
  </script>
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

    <main id="messages-main">
      <div class="messages-container">
        <h1>Your Messages</h1>

        <!-- Tabs for Lost Pets and Found Pets -->
        <div class="tabs">
          <button onclick="toggleTab('lost-pets-tab')" class="tab-button">Lost Pets</button>
          <button onclick="toggleTab('found-pets-tab')" class="tab-button">Found Pets</button>
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
        
        <!-- Lost Pets Tab Content -->
        <div id="lost-pets-tab" class="tab-content" style="display: block;">
          <div class="conversation-list">
            <!-- Dynamically populate conversations -->
            <?php while($message = $lostMessages->fetch_assoc()): ?>
              <div class="conversation-item" onclick="toggleConversation('<?php echo $message['message_id']; ?>')">
                <div class="conversation-header">
                  <p><strong><?php echo htmlspecialchars($message['sender_name']); ?></strong></p>
                  <p><small>Last message: <?php echo htmlspecialchars($message['content']); ?></small></p>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>

        <!-- Found Pets Tab Content -->
      <div id="found-pets-tab" class="tab-content" style="display: none;">
        <div class="conversation-list">
          <!-- Dynamically populate conversations -->
          <?php while($message = $foundMessages->fetch_assoc()): ?>
            <div class="conversation-item" onclick="toggleConversation('<?php echo $message['message_id']; ?>')">
              <div class="conversation-header">
                <p><strong><?php echo htmlspecialchars($message['sender_name']); ?></strong></p>
                <p><small>Last message: <?php echo htmlspecialchars($message['content']); ?></small></p>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

 <!-- Message Thread for Lost Pets (Conversation 1) -->     
  <div class="message-thread" id="lost-conversation1" style="display: none;">
    <?php
    // Assuming you have a valid connection to the database
    $messagesQuery = "SELECT * FROM messages WHERE conversation_id = ?";
    $stmt = $conn->prepare($messagesQuery);
    $stmt->bind_param("i", $conversation_id); // Set conversation_id for the thread
    $stmt->execute();
    $messages = $stmt->get_result();

    while ($message = $messages->fetch_assoc()) {
        $sender = htmlspecialchars($message['sender_name']);
        $content = htmlspecialchars($message['content']);
        
        
<!-- TEST COMMENTED OUT 
        <!-- Message Thread for Lost Pets (Conversation 1) -->
        <div class="message-thread" id="lost-conversation1" style="display: none;">
          <div class="thread-header">
            <h3>Conversation with Sarah Lee</h3>
          </div>
          <div class="message-item received">
            <p><strong>Sarah Lee:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>
          <div class="message-item received">
            <p><strong>Sarah Lee:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>

          <!-- Input Box to Send Message -->
          <textarea id="reply-message-lost1" placeholder="Type a message..." rows="4"></textarea>
          <button class="send-reply">Send</button>
        </div>

        <!-- Message Thread for Lost Pets (Conversation 2) -->
        <div class="message-thread" id="lost-conversation2" style="display: none;">
          <div class="thread-header">
            <h3>Conversation with Mike Johnson</h3>
          </div>
          <div class="message-item received">
            <p><strong>Mike Johnson:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>
          <div class="message-item received">
            <p><strong>Mike Johnson:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>

          <!-- Input Box to Send Message -->
          <textarea id="reply-message-lost2" placeholder="Type a message..." rows="4"></textarea>
          <button class="send-reply">Send</button>
        </div>

        <!-- Message Thread for Found Pets (Conversation 1) -->
        <div class="message-thread" id="found-conversation1" style="display: none;">
          <div class="thread-header">
            <h3>Conversation with Emma Green</h3>
          </div>
          <div class="message-item received">
            <p><strong>Emma Green:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>
          <div class="message-item received">
            <p><strong>Emma Green:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>

          <!-- Input Box to Send Message -->
          <textarea id="reply-message-found1" placeholder="Type a message..." rows="4"></textarea>
          <button class="send-reply">Send</button>
        </div>

        <!-- Message Thread for Found Pets (Conversation 2) -->
        <div class="message-thread" id="found-conversation2" style="display: none;">
          <div class="thread-header">
            <h3>Conversation with Isha Khan</h3>
          </div>
          <div class="message-item received">
            <p><strong>Isha Khan:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>
          <div class="message-item received">
            <p><strong>Isha Khan:</strong> "sample text"</p>
          </div>
          <div class="message-item sent">
            <p><strong>You:</strong> "sample text"</p>
          </div>

          <!-- Input Box to Send Message -->
          <textarea id="reply-message-found2" placeholder="Type a message..." rows="4"></textarea>
          <button class="send-reply">Send</button>
        </div>

      </div>
      END TEST COMMENT -->

    </main>
  </div>
  </div>
</body>
</html>
