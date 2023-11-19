<?php
session_start();
require_once("class/pet.php");

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the user's information from the session
$user = $_SESSION['user'];

// Get all pets belonging to the user
$pet = new Pet();
$pets = $pet->getPetsByResidentID($user['residentID']);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Pet Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Pet Dashboard</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Sex</th>
                    <th>Color</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet) { ?>
                    <tr>
                        <td><?php echo $pet['pname']; ?></td>
                        <td><?php echo ($pet['petType'] == 0) ? 'Dog' : 'Cat'; ?></td>
                        <td><?php echo ($pet['sex'] == 0) ? 'Male' : 'Female'; ?></td>
                        <td><?php echo $pet['color']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
