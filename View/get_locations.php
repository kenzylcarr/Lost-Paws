<?php
header('Content-Type: application/json');

// Include the DB configuration file
require_once("../Model/db_config.php");  // Make sure the path is correct

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pwd, $db_db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all locations from the database
$sql = "SELECT latitude, longitude FROM locations";
$result = $conn->query($sql);

$locations = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
} else {
    echo json_encode(["error" => "No locations found"]);
    exit;
}

echo json_encode($locations);

$conn->close();
?>