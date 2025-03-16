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

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['lat']) && isset($data['lng'])) {
    $lat = $data['lat'];
    $lng = $data['lng'];

    // Insert the location into the database
    $stmt = $conn->prepare("INSERT INTO locations (latitude, longitude) VALUES (?, ?)");
    $stmt->bind_param("dd", $lat, $lng);  // 'dd' means double for latitude and longitude

    if ($stmt->execute()) {
        echo json_encode(["message" => "Location saved successfully"]);
    } else {
        echo json_encode(["error" => "Failed to save location"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid data"]);
}

$conn->close();
?>