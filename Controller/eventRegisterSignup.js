/*
CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: eventRegisterSignup.js
*/

let signupForm = document.getElementById("signup-form");
signupForm.addEventListener("submot", validateSignup);

// Change validator on username field
let username = document.getElementById("username");
username.addEventListener("blur", usernameHandler);

// Change validator on email address field
let email = document.getElementById("email");
email.addEventListener("blur", emailHandler);


// Change validator on phone number field
let phone = document.getElementById("phone");
phone.addEventListener("blur", phoneHandler);

// Change validator on password field
let password = document.getElementById("password");
password.addEventListener("blur", passwordHandler);

// Change validator on confirm password field
let cpassword = document.getElementById("cpassword");
cpassword.addEventListener("blur", cpasswordHandler);

// Change validator on profile photo field
let profilePhoto = document.getElementById("profilephoto");
profilePhoto.addEventListener("change", profilePhotoHandler);


/* Function Handlers for the signup.html */
function usernameHandler(event) {
  let username = event.target;
  let errorText = document.getElementById("error-text-username");

  if(username.value.trim().length < 3)
  {
    errorText.classList.remove("hidden");
    console.log("Invalid username:" + username.value);
  }
  else
  {
    errorText.classList.add("hidden");
    console.log("Valid username: " + username.value);
  }
}
