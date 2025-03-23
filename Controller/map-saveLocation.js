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
    center: initialLocation,
    restriction: {
      latLngBounds: reginaBounds,
      strictBounds: false
    }
  });

  // add a draggable marker
  marker = new google.maps.Marker({
    position: initialLocation,
    map: map,
    draggable: true
  });

  // draw a red border around Regina (rectangle)
  const reginaRectangle = new google.maps.Rectangle({
    bounds: reginaBounds,
    strokeColor: "#FF0000", // red color for the border
    strokeOpacity: 0.8,     // 80% opacity for the border
    strokeWeight: 2,        // border thickness
    fillColor: "#FF0000",   // transparent
    fillOpacity: 0,         // No fill color
    map: map
  });

  // update the hidden fields with the marker's latitude and longitude
  google.maps.event.addListener(marker, 'dragend', function() {
    const position = marker.getPosition();
    const lat = position.lat();
    const lng = position.lng();

    // check if the new position is within Regina's bounds
    if (lat >= reginaBounds.south && lat <= reginaBounds.north && lng >= reginaBounds.west && lng <= reginaBounds.east) {
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;

      // debugging - log to console
      console.log("Latitude: " + lat);
      console.log("Longitude: " + lng);
    } else {
      // if the marker is outside of Regina, reset the marker position to within the bounds
      marker.setPosition({
        lat: Math.min(Math.max(lat, reginaBounds.south), reginaBounds.north),
        lng: Math.min(Math.max(lng, reginaBounds.west), reginaBounds.east)
      });

      alert("You can only place the marker within Regina!");
    }
  });

  // allow the user to click to add a new marker on the map
  google.maps.event.addListener(map, 'click', function(event) {
  const clickedLocation = event.latLng;
  const lat = clickedLocation.lat();
  const lng = clickedLocation.lng();

    // check if the clicked location is within Regina's bounds
    if (lat >= reginaBounds.south && lat <= reginaBounds.north && lng >= reginaBounds.west && lng <= reginaBounds.east) {
      // move the marker to the clicked location
      marker.setPosition(clickedLocation);

      // update the hidden fields with the new latitude and longitude
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;

      // debugging - log to console
      console.log("Latitude: " + lat);
      console.log("Longitude: " + lng);
    } else {
      alert("You can only click within the Regina boundaries!");
    }
  });
}

// initialize map when the page loads
window.onload = function() {
  initMap();
}