/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventHandlers.js
*/

/* Waiting for DOM to load before executing script for both Signup and Login */
document.addEventListener("DOMContentLoaded", function()
{
  // Attaching event listeners when the page is being loaded
  let signupForm = document.getElementById("signup-form");
  if (signupForm)
    signupForm.addEventListener("submit", validateSignup);

  let loginForm = document.getElementById("login-form");
  if (loginForm)
    loginForm.addEventListener("submit", validateLogin);
});

/* Common validator functions begin */
function validateName(name)
{
  let nameRegEx = /^[A-Za-z'-]+(?: [A-Za-z'-]+)*$/;

  if (nameRegEx.test(name))
      return true;
  else
      return false
}

function validateUsername(username)
{
  let usernameRegEx = /^[a-zA-Z0-9_]+$/;

  if (usernameRegEx.test(username))
      return true;
  else
      return false;
}

function validateEmail(email)
{
  let emailRegEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

  if (emailRegEx.test(email))
      return true;
  else
      return false;
}

function validatePhoneNumber(phone)
{
  let phoneRegEx = /^\d{10}$/;        // exactly 10 digits for the form (###) ### - ####
  return phoneRegEx.test(phone);
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

function validateProfilePhoto(profilePhoto)
{
  let profilePhotoRegEx = /\.(jpg|jpeg|png|gif)$/i;    // allow JPG, JPEG, PNG, GIF formats

  if (profilePhotoRegEx.test(profilePhoto))
      return true;
  else
      return false;
}

/* End of common validator functions */