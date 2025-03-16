<?php
header('Content-Type: application/json');

// Include the DB configuration file
require_once("../Model/db_config.php");  // Make sure the path is correct
session_start();

// Check if connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the user is signed in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../View/login.php"); 
    exit();
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

mysqli_close($conn);
?>