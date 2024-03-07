<?php
require_once('class/resident.php');

$errorMessage = "";

if (isset($_POST['Revoke'])) {
    if (isset($_POST['residentID']) && isset($_POST['brgyID'])) {
        $resident = new Resident();
        $residentID = $_POST['residentID'];
        $brgyID = $_POST['brgyID'];
        $page = $_POST['page'];


        // Call the function to revoke the officer
        $result = $resident->revokeOfficer($residentID, $brgyID);

        if ($result) {
            echo '<script>alert("Officer has been revoked."); window.location.href = "assign_officer.php?barangay_officer=' . $brgyID . '&page=' . $page .'#Officers";</script>';
            exit();
        } else {
            $errorMessage = "Failed to revoke officer";
        }
    } else {
        $errorMessage = "Missing POST data for revoking the officer.";
    }
}
// Handle any other code or error messages if needed
?>