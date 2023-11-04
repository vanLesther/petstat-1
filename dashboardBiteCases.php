<?php
session_start();
require_once("class/cases.php");

// Check if the user is logged in and has admin privileges (userType = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["verify"]) || isset($_POST["reject"])) {
        $caseID = $_POST["caseID"];
        $caseStatus = isset($_POST["verify"]) ? 1 : 2; // 1 for verified, 2 for not verified

        $case = new Cases();
        $result = $case->updateBiteCaseStatus($caseID, $caseStatus);

        if ($result === true) {
            // Successfully updated pet status
            echo '<script>alert("Bite Case status updated successfully.");</script>';
        } else {
            // Failed to update Bite Case status
            echo "Failed to update Bite Case status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard 2</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Manage Bite Case for Barangay: <?php echo isset($_SESSION['user']['barangay']) ? $_SESSION['user']['barangay'] : ''; ?></h1>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newBiteCase" data-bs-toggle="tab">New Bite Case</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validBiteCase" data-bs-toggle="tab">Valid Bite Case</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedBiteCase" data-bs-toggle="tab">Rejected Bite Case</a>
            </li>
        </ul>
        
        <div class="tab-content">
            <!-- New Bite Case Tab -->
            <div class="tab-pane fade show active" id="newBiteCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Victims Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllNewBiteCase();

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            echo '<td>' . $row['victimsName'] . '</td>';
                            // Input date as a string
                            $input_date = $row['date'];

                            // Convert the input date to a DateTime object
                            $date_obj = new DateTime($input_date);

                            // Format the date as "Month Day, Year"
                            $formatted_date = $date_obj->format("F j, Y");

                            // Print the formatted date
                            echo '<td>' . $formatted_date. '</td>';
                            echo '<td>
                                    <form method="post" action="dashboardBiteCases.php">
                                        <input type="hidden" name="caseID" value="' . $row['caseID'] . '">
                                        <button type="submit" name="verify" class="btn btn-success">Accept</button>
                                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Valid Bite Case Tab -->
            <div class="tab-pane fade" id="validBiteCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Victims Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllValidBiteCase();

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            echo '<td>' . $row['victimsName'] . '</td>';
                            // Input date as a string
                            $input_date = $row['date'];

                            // Convert the input date to a DateTime object
                            $date_obj = new DateTime($input_date);

                            // Format the date as "Month Day, Year"
                            $formatted_date = $date_obj->format("F j, Y");

                            // Print the formatted date
                            echo '<td>' . $formatted_date. '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Rejected Bite Case Tab -->
            <div class="tab-pane fade" id="rejectedBiteCase">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pet Name</th>
                            <th>Victims Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $case = new Cases();
                        $cases = $case->getAllRejectedBiteCase();

                        while ($row = $cases->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['pname'] . '</td>';
                            echo '<td>' . $row['victimsName'] . '</td>';
                            echo '<td>' . $row['date'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="dashboard1.php" class="btn btn-primary">Manage User</a>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
