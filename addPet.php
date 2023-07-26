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
        <h1>Pet Registration Form</h1>
        <form method="POST" action="process_addPet.php" id="registrationForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="petType" class="form-label">Pet Type:</label>
                <select class="form-select" name="petType" id="petType" required>
                    <option value="">Select Pet Type</option>
                    <option value="0">Dog</option>
                    <option value="1">Cat</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sex" class="form-label">Sex:</label>
                <select class="form-select" name="sex" id="sex" required>
                    <option value="">Select Sex</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="text" class="form-control" name="color" id="color" required>
            </div>
            <input type="hidden" name="residentID" id="residentID" value="<?php echo $user['residentID']; ?>">

            <input type="submit" value="Add Pet" class="btn btn-primary">
        </form>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
