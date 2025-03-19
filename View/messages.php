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
        <a href="petmap.php">Pet Map</a>
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

        <!-- Lost Pets Tab Content -->
        <div id="lost-pets-tab" class="tab-content" style="display: block;">
          <div class="conversation-list">
            <!-- Conversation 1 for Lost Pets -->
            <div class="conversation-item" onclick="toggleConversation('lost-conversation1')">
              <div class="conversation-header">
                <p><strong>Sarah Lee</strong> (Lost Dog)</p>
                <p><small>Last message: "I think I found your dog near the grocery store."</small></p>
              </div>
            </div>
            <!-- Conversation 2 for Lost Pets -->
            <div class="conversation-item" onclick="toggleConversation('lost-conversation2')">
              <div class="conversation-header">
                <p><strong>Mike Johnson</strong> (Lost Dog)</p>
                <p><small>Last message: "I saw a dog running around near the park. It looks like your lost pet."</small></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Found Pets Tab Content -->
        <div id="found-pets-tab" class="tab-content" style="display: none;">
          <div class="conversation-list">
            <!-- Conversation 1 for Found Pets -->
            <div class="conversation-item" onclick="toggleConversation('found-conversation1')">
              <div class="conversation-header">
                <p><strong>Emma Green</strong> (Found Cat)</p>
                <p><small>Last message: "I found your cat!"</small></p>
              </div>
            </div>
            <!-- Conversation 2 for Found Pets -->
            <div class="conversation-item" onclick="toggleConversation('found-conversation2')">
              <div class="conversation-header">
                <p><strong>Isha Khan</strong> (Found Dog)</p>
                <p><small>Last message: "I found a dog matching the description of your missing pet!"</small></p>
              </div>
            </div>
          </div>
        </div>

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
    </main>
  </div>
  </div>

  <!--  remove footer? 
      <footer>
      <p>CS 476: Software Development Project</p>
    </footer>   -->
  
</body>
</html>
