<!--
  CS 476: Lost Paws Project
  Group Members: 
            Butool Basabrain (bmb008 - 200478399), 
            Anna Chu (ace859 - 200391368), 
            Ibrahim Hassan (hassan4i - 200343818),
            Makenzy Laursen-Carr (mil979 - 200504296), 
            Kaira Molano (kvm406 - 200447526), 
            Fatima Rizwan (frf706 - 200446702)
  File name: db_config.php
-->

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env file
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // Database credentials
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];

    // Debug output
    // echo "Attempting to connect to database:<br>";
    // echo "Host: " . $host . "<br>";
    // echo "Database: " . $dbname . "<br>";
    // echo "Username: " . $username . "<br>";
    
    try {
        $conn = mysqli_connect($host, $username, $password, $dbname);
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        // echo "Database connection successful!<br>";
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
} catch (Exception $e) {
    die("Error loading environment variables: " . $e->getMessage());
}
?>