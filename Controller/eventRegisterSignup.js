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

// let signupForm = document.getElementById("signup-form");
// signupForm.addEventListener("submit", validateSignup);

// // Change validator on username field
// let username = document.getElementById("username");
// username.addEventListener("blur", usernameHandler);

// // Change validator on email address field
// let email = document.getElementById("email");
// email.addEventListener("blur", emailHandler);


// // Change validator on phone number field
// let phone = document.getElementById("phone");
// phone.addEventListener("blur", phoneHandler);

// // Change validator on password field
// let password = document.getElementById("password");
// password.addEventListener("blur", passwordHandler);

// // Change validator on confirm password field
// let cpassword = document.getElementById("cpassword");
// cpassword.addEventListener("blur", cpasswordHandler);

// // Change validator on profile photo field
// let profilePhoto = document.getElementById("profilephoto");
// profilePhoto.addEventListener("change", profilePhotoHandler);


// /* Function Handlers for the signup.html */
// // Username
// function usernameHandler(event) 
// {
//   let username = event.target;
  
//   if (!validateUsername(username.value))
//       console.log("'" + username.value + "' is not a valid username");
//   else
//       console.log("'" + username.value + "' is a valid username");
// }


// // Email
// function emailHandler(event)
// {
//   let email = event.target;
  
//   if(!validateEmail(email.value))
//       console.log("'" + email.value + "' is not a valid email address");
//   else
//       console.log("'" + email.value + "' is a valid email address");
// }


// // Password
// function passwordHandler(event)
// {
//   let password = event.target;

//   if (!validatePassword(password.value))
//       console.log("'" + password.value + "' is not a valid password");
//   else
//       console.log("'" + password.value + "' is a valid password");
      
// }

// // Password Confirmation
// function cpasswordHandler(event)
// {
//   let password = document.getElementById("password");
//   let cpassword = event.target;

//   if (password.value !== cpassword.value)
//   {
//       cpassword.classList.add("error-border");
//       document.getElementById("error-text-cpassword").classList.remove("hidden");
//       console.log("Your password: " + password.value + " and " + cpassword.value + " do not match");
//   }
//   else
//   {
//       console.log("Your passwords match");
//     cpassword.classList.remove("error-border");
//     document.getElementById("error-text-cpassword").classList.add('hidden');
//   }
// }


// // Profile Photo
// function profilePhotoHandler(event)
// {
//   let profilePhoto = event.target;
//   if (!validateProfilePhoto(profilePhoto.value))
//   {
//       console.log("'" + profilePhoto + "' is not a valid profile photo");
//       flag = false;
//   }
//   else
//       console.log("'" + profilePhoto.value + "' is a valid profile photo");
// }
