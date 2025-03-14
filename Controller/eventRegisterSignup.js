/*
CS 476: Lost Paws Project
  Group Members: 
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
  
  let profilePhoto = document.getElementById("profilephoto");
  profilePhoto.addEventListener("blur", profilePhotoHandler);
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
  if (!validatePhoneNumber(phone.value)) {
    phone.classList.add("error-border");
    document.getElementById("error-text-phone");
    formIsValid = false;
  } else {
      phone.classList.remove("error-border");
      document.getElementById("error-text-phone");
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

function profilePhotoHandler(event) {
  let profilePhoto = event.target;
  if (profilePhoto.files.length === 0) {
      // No file selected
      console.log("No file selected.");
      profilePhoto.classList.add("error-border");
      document.getElementById("error-text-profile_photo").classList.remove("hidden");
  } else {
      // Validate the file type
      let file = profilePhoto.files[0];
      if (!validateProfilePhoto(file.name)) {
          console.log("'" + file.name + "' is not a valid profile photo");
          profilePhoto.classList.add("error-border");
          document.getElementById("error-text-profilephoto").classList.remove("hidden");
      } else {
          profilePhoto.classList.remove("error-border");
          document.getElementById("error-text-profilephoto").classList.add("hidden");
          console.log("'" + file.name + "' is a valid profile photo");
      }
  }
}

/* EVENT HANDLERS AND FUNCTION VALIDATORS FOR SIGNUP PAGE */

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

  // validating phone number
  let phone = document.getElementById("phone");
  if (!validatePhoneNumber(phone.value))
  {
    phone.classList.add("error-border");
    document.getElementById("error-text-phone").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    phone.classList.remove("error-border");
    document.getElementById("error-text-phone").classList.add("hidden");
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
  let profilePhoto = document.getElementById("profile_photo");
  if (profilePhoto.files.length === 0 || !validateProfilePhoto(profilePhoto.files[0].name))
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
  if (formIsValid)
  {
    console.log("Validation was successful, now sending data over to the server.");
  }
  else
  {
    event.preventDefault();
  }
}