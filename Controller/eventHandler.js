/*
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventHandlers.js
*/

/* Common validator functions begin */
function validateName(name)
{
  let nameRegEx = /^[a-zA-Z\s]+$/;    // allow spaces for names

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



/* Event handlers for signup.html page begins */
function validateSignup(event)
{
  let formIsValid = true;

  // validating username
  let username = document.getElementById("username");
  if (!validateUsername(username.value))
  {
    username.classList.add('error-border');
    document.getElementById("error-text-username").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    username.classList.remove('error-border');
    document.getElementById("error-text-username").classList.add("hidden");
  }

  // validating email
  let email = document.getElementById("email");
  if (!validateEmail(email.value))
  {
    email.classList.add('error-border');
    document.getElementById("error-text-email").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    email.classList.remove('error-border');
    document.getElementById("error-text-email").classList.add("hidden");
  }

  // validating password
  let password = document.getElementById("password");
  if (!validatePassword(password.value))
  {
    password.classList.add('error-border');
    document.getElementById("error-text-password").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    password.classList.remove('error-border');
    document.getElementById("error-text-password").classList.add("hidden");
  }

  // validating password confirmation
  let cpassword = document.getElementById("cpassword");
  if (password.value !== cpassword.value)
  {
    cpassword.classList.add("error-border");
    document.getElementById("error-text-cpassword").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    cpassword.classList.remove("error-border");
    document.getElementById("error-text-cpassword").classList.add("hidden");
  }

  // validating profile photo
  let profilePhoto = document.getElementById("profilephoto");
  if (!validateProfilePhoto(profilePhoto.value))
  {
    profilePhoto.classList.add('error-border');
    document.getElementById("error-text-profilephoto").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    profilePhoto.classList.remove('error-border');
    document.getElementById("error-text-profilephoto").classList.add("hidden");
  }

  // if form is not valid
  if (!formIsValid)
  {
    event.preventDefault();
  }
  else
  {
    console.log("Validation was successful, now sending data over to the server.");
  }

  
}
/* End of event handlers for signup.html page */
