<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the user's information from the session
$user = $_SESSION['user'];

// Display the dashboard content
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Pet Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add jQuery library -->

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <h1>Report case</h1>
        <form method="POST" action="addCase.php" id="reportCaseForm">
            <input type="submit" value="Report Bite Case" class="btn btn-primary">
        </form>
            <form method="POST" action="addCase.php" id="reportCaseForm">
            <input type="submit" value="Report Death Case" class="btn btn-primary">
        </form>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
