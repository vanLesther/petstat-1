<?php
session_start();
// var_dump($_POST);
require_once("class/pet.php");
// Assuming you receive the parameters from a form submission or API request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$residentID = $_POST['residentID'];
$petType = $_POST['petType'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$color = $_POST['color'];

$pet = new Pet();
$newPet = $pet->addPet($residentID, $petType, $name, $sex, $color);

if ($newPet === true) {
    echo '<script>alert("Register Pet Successfully"); window.location.href = "viewPet.php";</script>';
} else {
    echo '<script>alert("Failed to register Pet: ' . $newPet . '"); window.location.href = "addPet.php";</script>';
}
}
?>
