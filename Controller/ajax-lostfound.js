/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: ajax-lostfound.js
*/

document.addEventListener('DOMContentLoaded', function()
{
  function fetchPets()
  {
    var xhr = new XMLHttpRequest();
    
    xhr.open = new XMLHttpRequest();
    xhr.open("GET", "ajax-lostfound.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");   // ** JSON STUFF ** 
    xhr.onreadystatechange = function()
    {
      if (xhr.readyState === 4 && xhr.status === 200)
      {
        try
        {
          var response = JSON.parse(xhr.responseText);
          updatePets(response);
        }
        catch (e)
        {
          console.error("ERROR parsing JSON:", e);
        }

      }
    };
    xhr.send();
  }

  function updatePets()
  {
    
  }
});
