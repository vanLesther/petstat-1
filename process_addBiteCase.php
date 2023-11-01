<?php
session_start();
// var_dump($_POST);
require_once("class/cases.php");
require_once("class/geolocation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $residentID = $_POST['residentID'];
    $petName = $_POST['petName'];
    $ownerName = $_POST['ownerName'];
    $victimName = isset($_POST['victimName']) ? $_POST['victimName'] : ''; // Check if 'victimName' is set
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
        $result = $case->addBiteCase($residentID, $petName, $ownerName, $victimName, $caseType, $description, $currentDate);
        
        if ($result === true) {
            echo '<script>alert("Report Case Successfully"); window.location.href = "viewPet.php";</script>';
        } else {
            echo '<script>alert("Failed to Report Case: ' . $result . '"); window.location.href = "addBiteCase.php";</script>';
        }
    }
}
?>
