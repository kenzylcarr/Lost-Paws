<?php
header('Content-Type: application/json');

// Include the DB configuration file
require_once("../Model/db_config.php");  // Make sure the path is correct

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

mysqli_close($conn);
?>