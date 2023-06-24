<?php
session_start();
require_once("class/resident.php");

// Check if the user is logged in and has admin privileges (userType = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accept"]) || isset($_POST["reject"])) {
        $userID = $_POST["userID"];
        $status = isset($_POST["accept"]) ? 1 : 2; // 1 for accepted, 2 for rejected

        $resident = new Resident();
        $result = $resident->updateUserStatus($userID, $status);

        if ($result === true) {
            // Successfully updated user status
            echo '<script>alert("User status updated successfully.");</script>';
        } else {
            // Failed to update user status
            echo "Failed to update user status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard 1</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <h1>Manage Resident for Barangay: <?php echo isset($_SESSION['user']['barangay']) ? $_SESSION['user']['barangay'] : ''; ?></h1>
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newResidents" data-bs-toggle="tab">New Residents</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validResidents" data-bs-toggle="tab">Valid Residents</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedResidents" data-bs-toggle="tab">Rejected Residents</a>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- New Residents -->
            <div class="tab-pane fade show active" id="newResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllNewResidents();

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>
                                    <form method="post" action="dashboard1.php">
                                        <input type="hidden" name="userID" value="' . $row['residentID'] . '">
                                        <button type="submit" name="accept" class="btn btn-success">Accept</button>
                                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Valid Residents -->
            <div class="tab-pane fade" id="validResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllValidResidents();

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Rejected Residents -->
            <div class="tab-pane fade" id="rejectedResidents">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resident = new Resident();
                        $users = $resident->getAllRejectedResidents();

                        while ($row = $users->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
