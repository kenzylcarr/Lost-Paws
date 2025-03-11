/*
CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventRegisterSignup.js
*/

/* VALIDATORS */

document.addEventListener("DOMContentLoaded", function()
{
  let signupForm = document.getElementById("signup-form");
  if (signupForm)
    signupForm.addEventListener("submit", validateSignup);

  // add event listeners after the DOM is loaded
  let username = document.getElementById("username");
  username.addEventListener("blur", usernameHandler);

  let email = document.getElementById("email");
  email.addEventListener("blur", emailHandler);

  let phone = document.getElementById("phone");
  phone.addEventListener("blur", phoneHandler);

  let password = document.getElementById("password");
  password.addEventListener("blur", passwordHandler);

  let cpassword = document.getElementById("cpassword");
  cpassword.addEventListener("blur", cpasswordHandler);
  
  let avatar = document.getElementById("profilephoto");
  avatar.addEventListener("blur", avatarHandler);
});


/* FUNCTION HANDLERS FOR SIGN-UP PAGE */

function usernameHandler(event) {
  let username = event.target;
  if (!validateUsername(username.value)) {
    console.log("'" + username.value + "' is not a valid username");
  } else {
    console.log("'" + username.value + "' is a valid username");
  }
}

function emailHandler(event) {
  let email = event.target;
  if (!validateEmail(email.value)) {
    console.log("'" + email.value + "' is not a valid email address");
  } else {
    console.log("'" + email.value + "' is a valid email address");
  }
}

function phoneHandler(event) {
  let phone = event.target;
  if (!validatePhone(phone.value)) {
    console.log("'" + phone.value + "' is not a valid phone number");
  } else {
    console.log("'" + phone.value + "' is a valid phone number");
  }
}

function passwordHandler(event) {
  let password = event.target;
  if (!validatePassword(password.value)) {
    console.log("'" + password.value + "' is not a valid password");
  } else {
    console.log("'" + password.value + "' is a valid password");
  }
}

function cpasswordHandler(event) {
  let password = document.getElementById("password");
  let cpassword = event.target;
  if (password.value !== cpassword.value) {
    cpassword.classList.add("error-border");
    document.getElementById("error-text-cpassword").classList.remove("hidden");
    console.log("Your passwords: " + password.value + " and " + cpassword.value + " do not match");
  } else {
    console.log("Your passwords match.");
    cpassword.classList.remove("error-border");
    document.getElementById("error-text-cpassword").classList.add("hidden");
  }
}

function avatarHandler(event) {
  let avatar = event.target;
  if(!validateAvatar(avatar.value)) {
    console.log("'" + avatar.value + "' is not a valid avatar");
  } else {
    console.log("'" + avatar.value + "' is a valid avatar");
  }
}