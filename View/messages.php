<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
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
  <link rel="stylesheet" type="text/css" href="style.css">
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
  <div id="container">
    <nav class="navmenu">
      <div class="logo">
        <a href="index.php">
          <img src="images/lp-logo.png" alt="Lost Paws Logo" class="logo"/>
        </a>
      </div>
      <div class="nav-links">
        <a href="aboutpage.php">About Lost Paws</a>
        <a href="reportpetpage.php">Report a Pet</a>
        <a href="mainpage-beforelogin.php">Lost & Found</a>
        <a href="petmap.php">Pet Map</a>
      </div>
      <div class="button">
        <a href="logout.php">Logout</a>
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
