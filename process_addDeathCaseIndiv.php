<?php
// session_start();
// // var_dump($_POST);
require_once("class/cases.php");
require_once("class/geolocation.php");
require_once("class/pet.php");
require_once("class/notification.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $residentID = $_POST['residentID'];
    $petID = $_POST['petID'];
    $brgyID = $_POST['brgyID'];
    $cdate = $_POST['date'];
    $description = $_POST['description'];
    $CRabies = $_POST['confirmedRabies'];
    $caseType = $_POST['caseType'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $notifType = $_POST['notifType'];
    $notifMessage = $_POST['notifMessage'];

    $geolocation = new Geolocation();
    $geoID = $geolocation->saveGeolocation($latitude, $longitude);

    if ($geoID !== false) {
        $case = new Cases();
        $notif = new Notification();
        $notifDate = date('Y-m-d H:i:s');
        $result = $case->addDeathCaseRes($residentID, $brgyID, $petID, $geoID, $caseType, $description, $cdate, $CRabies);
        $push = $notif->addDeathNotif($brgyID, $residentID, $notifType, $notifDate, $notifMessage);
        if ($result === true) {
            echo '<script>alert("Report Death Case Successfully"); window.location.href = "./dashboard.php?active-tab=3";</script>';
        } else {
            echo '<script>alert("Failed to Report Case: ' . $result . '"); window.location.href = "addDeathCaseIndiv.php";</script>';
        }
    }
}
?>
