/*
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: map-filterLocation.js
    This file filters and loads the map based on pet type and status (for petmap.php)
*/

let map;
let markers = [];
let currentStatus = 'all';  // Variable to track the selected status (lost, found, or all)

// initialize map
function initMap() {
  map = new google.maps.Map(document.getElementById('petmap-map'), {
    center: { lat: 50.4601, lng: -104.6639 },  // set initial center (Regina, SK)
    zoom: 12,
  });

  // function to display pets on the map
  function displayPets(pets) {
    // clear existing markers
    markers.forEach(marker => marker.setMap(null));
    markers = [];

    // add new markers
    pets.forEach(pet => {
      const marker = new google.maps.Marker({
        position: { lat: parseFloat(pet.latitude), lng: parseFloat(pet.longitude) },
        map: map,
        title: `${pet.animal_type} - ${pet.status}`,
      });

      // add a click event listener to each marker to redirect to viewpet pages based on login status
      marker.addListener('click', () => {
        if (loggedIn) {
          // Redirect to the member view page if logged in
          window.location.href = `/View/viewpet_member.php?id=${pet.pet_id}`;
        } else {
          // Redirect to the visitor view page if not logged in
          window.location.href = `/View/viewpet_visitor.php?id=${pet.pet_id}`;
        }
      });
      markers.push(marker);
    });
  }

// initial map load - display all pets
displayPets(allPets);

  // function to handle active button state
function setActiveButton(buttonId) {
  const buttons = document.querySelectorAll('#filter-section button');
  buttons.forEach(button => {
  button.classList.remove('active');  // remove active class from all buttons
  });
  document.getElementById(buttonId).classList.add('active');  // add active class to the clicked button
}

  // function to filter pets based on status and animal type
  function filterPets() {
    let filteredPets = allPets;

    if (currentStatus !== 'all') {
        filteredPets = filteredPets.filter(pet => pet.status === currentStatus);
      }

    const selectedAnimalType = document.getElementById('pet-type-filter').value;
    if (selectedAnimalType !== 'all') {
        filteredPets = filteredPets.filter(pet => pet.animal_type === selectedAnimalType);
      }

    displayPets(filteredPets);
  }

    // event listeners for filter buttons
  document.getElementById('all-button').addEventListener('click', () => {
    currentStatus = 'all';
    filterPets();
    setActiveButton('all-button');
  });

  document.getElementById('lost-button').addEventListener('click', () => {
    currentStatus = 'lost';
    filterPets();
    setActiveButton('lost-button');
  });

  document.getElementById('found-button').addEventListener('click', () => {
    currentStatus = 'found';
    filterPets();
    setActiveButton('found-button');
  });

  // event listener for pet type dropdown
  document.getElementById('pet-type-filter').addEventListener('change', () => {
    // filter pets based on selected type and current status
    filterPets();
});
}
