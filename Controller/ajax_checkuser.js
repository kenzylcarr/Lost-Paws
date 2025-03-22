/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: ajax-checkuser.js
*/

document.addEventListener('DOMContentLoaded', function()
{
    function fetchUserInfo() {
        var xhr = new XMLHttpRequest();

        // Handle response when request is completed
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    updateUserInfo(response);
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            }
        };
        xhr.open("GET", "ajax-checkuser.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.send();
    }
    // Function to update user info on the page
    function updateUserInfo(user) {
        // Update DOM with user info
        var userInfoDiv = document.querySelector("#user-info");

        userInfoDiv.innerHTML = `
            <p>Name: ${user.name}</p>
            <p>Email: ${user.email}</p>
            <img src="${user.profile_picture}" alt="Profile Picture">
            `;
    }
    fetchUserInfo();
});