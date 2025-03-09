/*
CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventRegisterLogin.js
*/

let loginForm = document.getElementById("login-form");
loginForm.addEventListener("submit", validateLogin);

let username = document.getElementById("username");
username.addEventListener("blur", usernameHandler);

let pwd = document.getElementById("password");
pwd.addEventListener("blur", pwdHandler); 
