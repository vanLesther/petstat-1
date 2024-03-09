<?php
session_start();

require_once("class/pet.php");
require_once("class/notification.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you receive the parameters from a form submission or API request
    $residentID = $_POST['residentID'];
    $pname = $_POST['pname'];
    $petType = $_POST['petType'];
    $sex = $_POST['sex'];
    $neutering = $_POST['neutering'];
    $statusVac = $_POST['statusVac']; // corrected variable name
    $currentVac = !empty($_POST['currentVac']) ? $_POST['currentVac'] : null; // Check if it's empty
    $color = $_POST['color'];
    $vetVac = $_POST['vetVac'];
    $age = $_POST['age'];
    $regDate = $_POST['regDate'];
    $pdescription = $_POST['pdescription'];
    $status = $_POST['status'];
    $notifType = $_POST['notifType'];
    $notifMessage = $_POST['notifMessage'];
    $brgyID = $_POST['brgyID'];
    $residentID = $_POST['residentID'];

    $regDate = date('Y-m-d H:i:s');

    $pet = new Pet();

    $newPet = $pet->addPet($residentID, $petType, $pname, $sex, $neutering, $color, $vetVac, $age, $regDate, $currentVac, $statusVac, $pdescription, $status);

    if ($newPet) {
       
        $notif = new Notification();
        $notifDate = date('Y-m-d H:i:s');
        $push = $notif->addPetNotif($brgyID, $residentID, $notifType, $notifDate, $notifMessage);

        echo '<script>alert("Register Pet Successfully"); window.location.href = "./dashboard1.php?active-tab=2";</script>';
    } else {
        echo '<script>alert("Failed to register Pet"); window.location.href = "addPetBAO.php";</script>';
    }
}
?>
