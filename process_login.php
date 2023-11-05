<?php
session_start();

require_once("class/resident.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // Sanitize input
    $password = $_POST["password"];

    $resident = new Resident();
    $user = $resident->loginResident($email, $password);

    if ($user !== false) {
        $_SESSION['user'] = $user; // Store the user array directly
        switch ($user['userType']) {
            case 0:
                header("Location: dashboard.php");
                exit();
            case 1:
                header("Location: dashboard1.php");
                exit();
            case 2:
                header("Location: dashboard2.php");
                exit();
            default:
                echo "Invalid userType: " . $user['userType'];
                exit();
        }
    } else {
        // Redirect with an error message
        header("Location: login.php?error=invalid");
        exit();
    }
}
?>
