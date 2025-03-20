/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: map-loadLocation.js
    This file loads the pinned locations of pets saved in the database
*/

let map;
let marker;

function initMap() {
if (petLat !== 0 && petLng !== 0) {
  // Initialize the map centered around the pet's location
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: petLat, lng: petLng },
    zoom: 15,
  });

  // Place a marker at the pet's location
  marker = new google.maps.Marker({
    position: { lat: petLat, lng: petLng },
    map: map,
    title: "Pet Location",
  });
} else {
  // If latitude and longitude are not set, you can center the map elsewhere
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 0, lng: 0 },
    zoom: 2, // Zoom out to show the whole world if no coordinates
  });
}
}

// initialize map when the page loads
window.onload = function() {
    initMap();
};