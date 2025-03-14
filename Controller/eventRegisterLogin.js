/*
CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventRegisterLogin.js
*/

document.addEventListener("DOMContentLoaded", function()
{
  let loginForm = document.getElementById("login-form");
  let loginButton = document.querySelector(".login-button");

  if (loginForm) {
    loginForm.addEventListener("submit", function(event) {
      if (!validateLogin(event)) {
        event.preventDefault();
      } else {
        if (loginButton) {
          loginButton.disabled = true;
        }
        console.log("Validation successful. Sending data over to server.");
      }
    });

    // add event listeners after the DOM is loaded
    let username = document.getElementById("username");
    username.addEventListener("blur", usernameHandler);

    let pwd = document.getElementById("password");
    pwd.addEventListener("blur", pwdHandler);
  }
});


/* FUNCTION HANDLERS FOR LOGIN PAGE */

function usernameHandler(event) {
  let username = event.target;
  let error_text = document.getElementById("error-text-username");

  if (validateUsername(username.value)) {
      username.classList.remove("error-border");
      error_text.classList.add("hidden");
  } else {
      console.log("Username not valid.");
      username.classList.add("error-border");
      error_text.classList.remove("hidden");
  }
}

function pwdHandler(event) {
  let pwd = event.target;
  let error_text = document.getElementById("error-text-password");

  if (validatePassword(pwd.value)) {
      console.log("Password is valid.")
      pwd.classList.remove("error-border");
      error_text.classList.add("hidden");
  } else {
      console.log("Password must have 1 upper letter, 1 lower letter, 1 digit, 1 special char, min 6 chars.")
      pwd.classList.add("error-border");
      error_text.classList.remove("hidden");
  }
}

function validateLogin(event) {
  // accessing the login form's input elements
  let username = document.getElementById("username");
  let password = document.getElementById("password");
  let formIsValid = true;

  // if loop to check the username isn't valid by calling the validator function
  if (!validateUsername(username.value)) {
    console.log("'" + username.value + "' is not a valid username");
    username.classList.add("error-border");
    document.getElementById("error-text-username").classList.remove("hidden");
    formIsValid = false;
  } else {
      username.classList.remove("error-border");
      document.getElementById("error-text-username").classList.add("hidden");
    }

  // checking if the password isn't valid by calling the validator function
  if (!validatePassword(password.value)) {
    console.log("'" + password.value + "' is not a valid password");
    password.classList.add("error-border");
    document.getElementById("error-text-password").classList.remove("hidden");
    formIsValid = false;
  } else {
    password.classList.remove("error-border");
    document.getElementById("error-text-password").classList.add("hidden");
  }
  // in case the form isn't valid
  if (formIsValid == false) {
    event.preventDefault();
  } else {
    console.log("validation was successful, sending data over to the server");
  }
}

function validateUsername(username)
{
  let usernameRegEx = /^[a-zA-Z0-9_]+$/;

  if (usernameRegEx.test(username))
      return true;
  else
      return false;
}

function validatePassword(password)
{
  let passwordRegEx = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
  // 1 upper letter, 1 lower letter, 1 digit, 1 special char, min 6 chars
  
  if (passwordRegEx.test(password))
      return true;
  else
      return false;
}