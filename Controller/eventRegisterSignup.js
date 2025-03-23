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
  let firstName = document.getElementById("firstname");
  firstName.addEventListener("blur", firstnameHandler);

  let lastName = document.getElementById("lastname");
  lastName.addEventListener("blur", lastnameHandler);

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
  
  let profilePhoto = document.getElementById("profile_photo");
  profilePhoto.addEventListener("blur", profilePhotoHandler);
});


/* FUNCTION HANDLERS FOR SIGN-UP PAGE */
function validateName(name) {
  // Regex for name
  const nameRegEx = /^[A-Za-z'-]+(?: [A-Za-z'-]+)*$/;
  return nameRegEx.test(name);
}

function firstnameHandler(event) {
  let firstname = event.target;
  if (!validateName(firstname.value)) {
    console.log("'" + firstname.value + "' is not a valid first name");
  } else {
    console.log("'" + firstname.value + "' is a valid first name");
  }
}

function lastnameHandler(event) {
  let lastname = event.target;
  if (!validateName(lastname.value)) {
    console.log("'" + lastname.value + "' is not a valid last name");
  } else {
    console.log("'" + lastname.value + "' is a valid last name");
  }
}

function usernameHandler(event) {
  let username = event.target;
  let usernameTakenError = document.getElementById("error-text-username-taken");

  if (!validateUsername(username.value)) {
    console.log("'" + username.value + "' is not a valid username");
  } else {
    console.log("'" + username.value + "' is a valid username");

    // check if the username already exists in the database
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        if (response.usernameTaken) {
          console.log("Username is already taken.");
          username.classList.add('error-border');
          usernameTakenError.classList.remove("hidden");
        } else {
          usernameTakenError.classList.add("hidden");
        }
      }
    };
    xhr.send("username=" + encodeURIComponent(username.value));
  }
}

function emailHandler(event) {
  let email = event.target;
  let emailTakenError = document.getElementById("error-text-email-taken"); 
  
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
      // AJAX request
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "check_phone.php", true)
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
          document.getElementById("error-text-profile_photo").classList.remove("hidden");
      } else {
          profilePhoto.classList.remove("error-border");
          document.getElementById("error-text-profile_photo").classList.add("hidden");
          console.log("'" + file.name + "' is a valid profile photo");
      }
  }
}

/* EVENT HANDLERS AND FUNCTION VALIDATORS FOR SIGNUP PAGE */

function validateSignup(event)
{
  let formIsValid = true;

  // validating first name
  let firstname = document.getElementById("firstname");
  if (!validateName(firstname.value))
  {
    firstname.classList.add('error-border');
    document.getElementById("error-text-firstname").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    firstname.classList.remove('error-border');
    document.getElementById("error-text-firstname").classList.add("hidden");
  }

  // validating last name
  let lastname = document.getElementById("lastname");
  if (!validateName(lastname.value))
  {
    lastname.classList.add('error-border');
    document.getElementById("error-text-lastname").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    lastname.classList.remove('error-border');
    document.getElementById("error-text-lastname").classList.add("hidden");
  }

  // validating username
  let username = document.getElementById("username");
  let usernameTakenError = document.getElementById("error-text-username-taken");
  if (!validateUsername(username.value))
  {
    username.classList.add('error-border');
    document.getElementById("error-text-username").classList.remove("hidden");
    usernameTakenError.classList.add("hidden");
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
    document.getElementById("error-text-profile_photo").classList.remove("hidden");
    formIsValid = false;
  }
  else
  {
    profilePhoto.classList.remove('error-border');
    document.getElementById("error-text-profile_photo").classList.add("hidden");
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