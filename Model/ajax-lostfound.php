<!--  
  CS 476: Lost Paws Project
  Group Members: 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: ajax-lostfound.php
-->

<?php
session_start();
require_once("../Model/db_config.php");

header("Content-Type: application/json");

$stmt = $conn->prepare("SELECT pet_id, animal_type, status, location_ip, picture FROM pets");
$stmt->execute();
$result = $stmt->get_result();
$pets = [];

if ($result->num_rows > 0)
{
  while ($row = $result->fetch_assoc())
  {
    $pets[] = [
        "pet_id" => $row['pet_id'],
        "animal_type" => $row['animal_type'],
        "status" => $row['status'],
        "location_ip" => $row['location_ip'],
        "picture" => $row["picture"]
    ];
  }    
}

echo json_encode($pets);
?>
