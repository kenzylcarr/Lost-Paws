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

document.addEventListener("DOMContentLoaded", function()
{
  let signupForm = document.getElementById("signup-form");
  if (signupForm)
    signupForm.addEventListener("submit", validateSignup);
});
