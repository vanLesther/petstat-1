<?php
session_start();
require_once("class/db_connect.php");
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get the user's information from the session
$user = $_SESSION['user'];
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
        <h1>Report Bite Case Form</h1>
        <form method="POST" action="process_addBiteCase.php" id="reportCaseForm">
            <div class="mb-3">
                <label for="petName" class="form-label">Pet Name:</label>
                <select class="form-select" name="petName" id="petName" required>
                    <option value="">Select Pet</option>
                    <?php
                    // PHP code to fetch and display pet names from the database
                    global $conn;

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT pname FROM pet";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["pname"] . '">' . $row["pname"] . '</option>';
                        }
                    } else {
                        echo '<option value="">No pets found</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ownerName" class="form-label">Owner Name:</label>
                <select class="form-select" name="ownerName" id="ownerName" required>
                    <option value="">Select Owner</option>
                    <?php
                    // PHP code to fetch and display owner names from the database
                    global $conn;

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql1 = "SELECT name FROM resident";
                    $result1 = $conn->query($sql1);

                    if ($result1->num_rows > 0) {
                        while ($row = $result1->fetch_assoc()) {
                            echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
                        }
                    } else {
                        echo '<option value="">No owners found</option>';
                    }
                    ?>
                </select>
            </div>
            <!-- <div class="mb-3">
                <label for="caseType" class="form-label">Case Type:</label>
                <select class="form-select" name="caseType" id="caseType" required>
                    <option value="">Select Case Type</option>
                    <option value="0">Bite</option>
                    <option value="1">Death</option>
                </select>
            </div> -->
            <div class="mb-3">
                <label for="Victim" class="form-label">Victim Name:</label>
                <input type="text" class="form-control" name="victim" id="victim" required>
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Description:</label>
                <input type="text" class="form-control" name="description" id="description" required>
            </div>
            <input type="hidden" name="residentID" id="residentID" value="<?php echo $user['residentID']; ?>">
            <input type="hidden" name="caseType" id="caseType" value="0">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input onclick="getLocation()" type="submit" value="Add Pet" class="btn btn-primary">
        </form>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
