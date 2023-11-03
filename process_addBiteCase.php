<?php
session_start();
// var_dump($_POST);
require_once("class/cases.php");
require_once("class/geolocation.php");
require_once("class/pet.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $residentID = $_POST['residentID'];
    $petName = $_POST['petName'];
    $brgyID = $_POST['brgyID'];
    // $ownerName = $_POST['ownerName'];
    $victimsName = isset($_POST['victimsName']) ? $_POST['victimsName'] : ''; // Check if 'victimName' is set
    $caseType = $_POST['caseType'];
    $description = $_POST['description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $geolocation = new Geolocation();
    $geoID = $geolocation->saveGeolocation($latitude, $longitude);

    if ($geoID !== false) {
        $case = new Cases();

        // Replace 'date' with the current date and time using the date function
        $currentDate = date('Y-m-d H:i:s');
        var_dump($currentDate); // Add this line to check the value
        $result = $case->addBiteCase($residentID, $brgyID, $petName, $geoID, $victimsName, $caseType, $description, $currentDate);
        
        if ($result === true) {
            echo '<script>alert("Report Case Successfully"); window.location.href = "viewPet.php";</script>';
        } else {
            echo '<script>alert("Failed to Report Case: ' . $result . '"); window.location.href = "addBiteCase.php";</script>';
        }
    }
}
?>
