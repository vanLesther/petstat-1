<?php
session_start();

require_once("class/resident.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $resident = new Resident();
    $user = $resident->loginResident($email, $password);

    if ($user !== false) {
        // Successful login, store user information in session
        $_SESSION['user'] = $user; // Store the user array directly
        // var_dump($user);
        // header("Location: dashboard1.php");
        // exit();

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
        // Invalid credentials, redirect back to login page
        // header("Location: login.php?error=invalid");
        // var_dump($user);
        echo '<script>alert("Incorrect email or password!"); window.location.href = "login.php?error=invalid";</script>';
        exit();
    }
}
?>
