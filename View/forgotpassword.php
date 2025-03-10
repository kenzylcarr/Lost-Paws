<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: forgotpassword.php
-->

<!DOCTYPE html>
<html>
  <head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="/View/style.css">
    <script src="../Controler/eventRegisterFPass.js"></script>
  </head>
  
  <body>
    <div id="container">
      <header id="header">
        <h1>Forgot Password</h1>
      </header>

      <!-- Lost Paws Logo -->
      <div class="logo">
          <a href="mainpage.php" class="logo">L·ᴥ·st Paws</a> 
      </div>

      <!-- Email -->
      <div class="input-field">
        <label for="email">E-mail Address</label>
        <input type="text" name="email" id="email"/>
      </div>

      <!-- New Password -->
      <div class="input-field">
        <label for="npassword">New Password</label>
        <input type="password" name="npassword" id="npassword" />
      </div>

      <!-- Confirm Password -->
      <div class="input-field">
        <label for="cpassword">Confirm Password</label>
        <input type="password" name"cpassword" id="cpassword">
      </div>

      <!-- Confirmation PIN -->

      <!-- Rsend Comfirmation PIN -->
      
      <!-- Button to Reset -->

      <!-- Return to Login Page -->
      <p class="input-field">
        <input type="submit" class="form-submit" value="" action="login.php"/>
      </p>

  </body>
</html>
