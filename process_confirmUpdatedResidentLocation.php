<?php
session_start();

require_once("class/resident.php");
require_once("class/geolocation.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $geoID = $_POST["geoID"];
    $name = $_POST["name"];
    $barangay = $_POST["barangay"];

    $residentLocation = new Geolocation();
    $residentData = $residentLocation->confirmUpdatedResidentLocation($geoID, $latitude, $longitude, $name, $barangay);
    
    if ($residentData !== false) {
        header("Location: dashboard1.php?");
        exit; // Make sure to add the exit statement after the header to prevent further execution 
    } else {
        // Failed to update user status
        echo "Failed to update user status.";
    }
    
    
    
}
?>