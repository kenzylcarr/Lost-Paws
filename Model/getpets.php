
<!-- CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: getpets.php
-->

<?php 
// Include the db_config.php file to connect to database
require_once '../Model/db_config.php';
session_start();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// SQL query to retrieve pet data from pet table
$sql = "SELECT pet_id, animal_type, status, location_ip, picture, latitude, longitude FROM pets";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    echo json_encode(["error" => "Failed to retrieve pet data: ". mysqli_error($conn)]);
    exit();
}

// Fetch all data
$pets = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pets[] = $row;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($pets);

// Close connection
mysqli_close($conn);
?>