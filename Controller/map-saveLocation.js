/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: map-saveLocation.js
    This file allows users to pin a specific location on the map (for reportpetpage.php)
*/

// initialize Google Map
let map, marker;

// define the bounds of Regina (approximately)
const reginaBounds = {
  north: 50.5356,   // northernmost latitude of Regina
  south: 50.3806,   // southernmost latitude of Regina
  east: -104.3890,  // easternmost longitude of Regina
  west: -104.7531   // westernmost longitude of Regina
};

function initMap() {
  const initialLocation = { lat: 50.4601, lng: -104.6186 }; // Regina, Saskatchewan

  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: initialLocation
  });

  // add a draggable marker
  marker = new google.maps.Marker({
    position: initialLocation,
    map: map,
    draggable: true
  });

  // update the hidden fields with the marker's latitude and longitude
  google.maps.event.addListener(marker, 'dragend', function() {
    const position = marker.getPosition();
    document.getElementById('latitude').value = position.lat();
    document.getElementById('longitude').value = position.lng();

    // debugging - log to console
    console.log("Latitude: " + position.lat());
    console.log("Longitude: " + position.lng());
  });

  // allow the user to click to add a new marker on the map
  google.maps.event.addListener(map, 'click', function(event) {
  const clickedLocation = event.latLng;

  // move the marker to the clicked location
  marker.setPosition(clickedLocation);

  // update the hidden fields with the new latitude and longitude
  document.getElementById('latitude').value = clickedLocation.lat();
  document.getElementById('longitude').value = clickedLocation.lng();

  // debugging - log to console
  console.log("Latitude: " + clickedLocation.lat());
  console.log("Longitude: " + clickedLocation.lng());
});
}

// initialize map when the page loads
window.onload = function() {
  initMap();
}