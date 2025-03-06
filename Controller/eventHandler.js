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
  let nameRegEx = /^[a-zA-Z]+$/;

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
  let passwordRegEx = /^(?=.*\W).{6,}$/;

  if (passwordRegEx.test(password))
      return true;
  else
      return false;
}

fuction validateProfilePhoto(profilePhoto)
{
  let profilePhotoRegEx = /^[^\n]+\.[a-zA-Z]{3,4}$/

  if (profilePhotoRegEx.test(profilePhoto))
      return true;
  else
      return false;
}

/* End of common validator functions */
