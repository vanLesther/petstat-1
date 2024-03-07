<?php
session_start();

$active_tab = $_GET['active-tab'];

require_once("class/resident.php");
require_once("class/barangay.php");
require_once("class/notification.php");

// Check if the user is logged in and has admin privileges (userType = 1)
$user = $_SESSION['user'];
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}

$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';
$barangay = isset($_SESSION['user']['barangay']) ? $_SESSION['user']['barangay'] : '';
$residentID = isset($_SESSION['user']['residentID']) ? $_SESSION['user']['residentID'] : '';
$userType = isset($_SESSION['user']['userType']) ? $_SESSION['user']['userType'] : '';
$name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
$resident = new Resident();
$barangay = new Barangay();
$brgyID = isset($user['brgyID']) ? $user['brgyID'] : '';
$result = $barangay->getBrgyName($brgyID);


// Handle form submission

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accept"]) || isset($_POST["reject"])) {
        $userID = $_POST["userID"];
        $status = isset($_POST["accept"]) ? 1 : 2; // 1 for accepted, 2 for rejected

        $resident = new Resident();
        $result = $resident->updateUserStatus($userID, $status);

        if ($result === true) {
            // Successfully updated user status
            $notifType = 5;
            $notifDate = date('Y-m-d H:i:s');
            $notifMessage = $_POST["notifMessage"];
            $residentID = $_POST['residentID'];

            $notification = new Notification();
            $notificationResult = $notification->addRegNotif($brgyID, $residentID, $notifType, $notifDate, $notifMessage);

            if ($status == 2 && $notificationResult === true) {
                // Redirect back immediately for rejected status
                echo '<script>alert("Status Updated Successfully.")window.location.href = "./dashboard1.php?active-tab=1";</script>';
            } else {
                // Redirect as per your existing logic
                echo '<script>alert("Status Updated Successfully."); window.location.href = "proccess_viewResidentLocation.php?userID=' . $userID . '";</script>';
            }
        } else {
            // Failed to update user status
            echo "Failed to update user status: " . $result;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Resident</title>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="petstaticon.png">
    <style>
  body {
            background-color: white;
        }

        .container {
            /* margin-top: 50px; */
            background-color:  white;
            /* padding: 20px; */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 200%;
            margin-left: -200px; 
            margin-right: auto;
            /* align-items: start; */
        }
        .container .content {
            flex: 1; /* This will make the content area fill the remaining space */
            overflow-y: auto; /* Add scroll if content overflows */
        }
        h1 {
            color: black;
            font-weight: bold;
        }

        .left-sidebar--sticky-container {
            width: 100%;
        }

        .nav-tabs {
            margin-bottom: 1rem;
        }

        .modal-dialog {
            margin: 0 auto;
        }

        #main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }

        #map {
            width: 100%; /* Adjust width to match container */
            height: 50vh;
            border: none; /* Remove border */
        }

        #myChart,
        #pieChart {
            width: 300%; /* Adjust width to match container */
            border: black; /* Remove border */
        }

        


        @media (min-width: 576px) {
            .h-sm-100 {
                height: 100%;
            }
        }



        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: start;
        }

        @media (min-width: 768px) {
            .chart-container {
                flex-wrap: nowrap;
            }
        }

        canvas {
            max-width: 200%;
            height: auto;
        }
        .col-12,
        .col-xl-2 {
            width: 20%;
        }

        .px-sm-2,
        .px-0 {
            padding-right: 20px;
            padding-left: 20px;
        }

        .pt-2 {
            padding-top: 20px; 
        }
        .bg-gray {
             background-color: #c5c6d0; 
        }
        img{
            align-items: end;
        }
    </style>
</head>

<body>
    <div class="container-fluid overflow-hidden">
        <div class="row vh-100 overflow-auto">
            <div class="col-12 col-sm-3 shadow-sm bg-gray col-xl-2 px-sm-2 px-0 d-flex sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <!-- <div class="row " style="width: 100%;">
                        <div class="container-fluid">
                            <div class="col-md-3 shadow-sm p-3 mb-5 bg-white rounded .col-sm-1 .col-lg-2 d-flex flex-column flex-shrink-0 p-3 bg-light " style="width: 280px;">
                                <div class="left-sidebar--sticky-container js-sticky-leftnav">
                                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none"> -->
                                    <div class="navbar-brand fs-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark">
                                    <a href="#" class="d-flex align-items-center link-dark">
                                        <span class="">
                                            <img class="bi me-2" width="55" height="55" role="img" src="petstaticon.svg"></img>
                                            <span class="d-none d-sm-inline pt-3"><strong>PETSTAT</strong></span>
                                        </span>
                                    </a>
                                    <div class="d-flex align-items-center ms-auto">
                                        <button class="btn btn-link me-2" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                            <i class="bi bi-bell fs-4"></i>
                                        </button>
                                    </div>
                                </div>
                    <ul class="nav nav-underline flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="dashboardBAO.php" class="flex-sm-fill text-sm-center nav-link text-dark" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./BAOpetdashboard.php?active-tab=1">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="active-tab" value="1">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" />
                                    </svg> <span class="ms-2 d-none d-sm-inline">Pet Dashboard</span></button>
                            </form>
                        </li>
                        <li class="dropdown">
                            <a href="dashboardBAO.php" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Report Case</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="addBiteCase.php">Report Bite Case</a></li>
                                <li><a class="dropdown-item" href="addDeathCase.php">Report Death Case</a></li>
                                <li><a class="dropdown-item" href="reportRabidBao.php">Report Rabid Case</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link active dropdown-toggle text-decoration-none text-dark px-sm-0 px-1 " id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Manage</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg " aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="./dashboard1.php?active-tab=1">Manage Resident</a></li>
                                <li><a class="dropdown-item" href="./dashboard1pet.php?active-tab=1">Manage Pet</a></li>
                                <li><a class="dropdown-item" href="./dashboardBiteCases.php?active-tab=1">Manage Bite Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardRabidCases.php?active-tab=1">Manage Suspected Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardDeathCases.php?active-tab=1">Manage Death Cases</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item">
                            <form method="POST" action="reportCase.php" id="reportBiteCaseForm" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button class="nav-link text-dark" type="submit" class="btn">Report Case</button>
                            </form>
                        </li> -->
                        <li class="nav-item">
                            <form method="post" action="./tabularBAO.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                                    </svg><span class="ms-2 d-none d-sm-inline"> Reports</span></button>
                            </form>
                        </li>

                        <!-- <li class="nav-item"><a href="viewHeatmaps.php" class="nav-link text-dark">View Heatmaps</a></li> -->
                        <!-- <li class="nav-item">
                            <form method="post" action="./dashboard1.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Resident</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./dashboard1pet.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Pet</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./dashboardBiteCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Bite Cases</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" action="./dashboardRabidCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Suspected Cases</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" action="./dashboardDeathCases.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark">Manage Death Cases</button>
                            </form>
                        </li> -->

                        <li class="nav-item">
                            <form method="post" action="createAccForResident.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                    </svg><span class="ms-2 d-none d-sm-inline">Account for Resident</span></button>
                                </a>
                            </form>
                        </li>
                        <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="rounded-circle me-2 outline" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <strong><span class="d-none d-sm-inline mx-1"> <?php echo isset($user['name']) ? $user['name'] : ''; ?> </span>
                                </strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="col d-flex flex-column h-sm-100">
                <main class="row overflow-auto">
                    <div class="col-md-8 p-1 mt-2 my-auto mx-auto">

                        <?php
                        // Default value for active tab (1 for "New Residents")
                        // $active_tab = 1;
                        ?>

                        <div class="container mt-4">
                            <h1 class="text-center">Manage Resident for Barangay: <?php echo $result ?></h1>
                            <ul>
                                <!-- Navigation Tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link<?= ($active_tab == 1) ? ' active' : '' ?>" href="./dashboard1.php?active-tab=1&page_new=1#newResidents" data-bs-toggle="tab">New Residents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link<?= ($active_tab == 2) ? ' active' : '' ?>" href="./dashboard1.php?active-tab=2&page_valid=1#validResidents" data-bs-toggle="tab">Valid Residents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link<?= ($active_tab == 3) ? ' active' : '' ?>" href="./dashboard1.php?active-tab=3&page_rej=1#rejectedResidents" data-bs-toggle="tab">Rejected Residents</a>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- New Residents -->
                                    <?php
                                    // Assuming $resident is your data array, $active_tab is set elsewhere
                                    $items_per_page_new = 8; // You can adjust this value as needed

                                    // Retrieve the search query from the form submission
                                    $search_new = isset($_POST['newSearch']) ? $_POST['newSearch'] : '';

                                    // Construct the SQL query to filter data based on the search terms
                                    // Modify this query according to your database structure and requirements
                                    $newResidentsQuery = "SELECT * FROM resident WHERE name LIKE ? AND brgyID = ? AND userStatus = 0 ORDER BY created_at DESC";

                                    // Prepare and execute the SQL query
                                    $stmt_new = mysqli_prepare($conn, $newResidentsQuery);
                                    $search_term = "%$search_new%"; // Adding wildcards for LIKE search
                                    mysqli_stmt_bind_param($stmt_new, "si", $search_term, $brgyID); // Assuming $residentID is available
                                    mysqli_stmt_execute($stmt_new);
                                    $newResidentsResult = mysqli_stmt_get_result($stmt_new);

                                    // Initialize an array to store the filtered data
                                    $newResidents = [];

                                    // Initialize total pages with default value
                                    $total_pages_new = 1;

                                    // Check if search results are found
                                    if ($newResidentsResult && mysqli_num_rows($newResidentsResult) > 0) {
                                        // Fetch all search results
                                        $allNewResidents = mysqli_fetch_all($newResidentsResult, MYSQLI_ASSOC);

                                        // Calculate pagination parameters for search results
                                        $total_items_new = count($allNewResidents);
                                        $total_pages_new = ceil($total_items_new / $items_per_page_new);
                                        $page_new = isset($_GET['page_new']) ? $_GET['page_new'] : 1;
                                        $start_index_new = ($page_new - 1) * $items_per_page_new;

                                        // Slice the search results to display the current page
                                        $newResidents = array_slice($allNewResidents, $start_index_new, $items_per_page_new);
                                    }
                                    ?>
                                    <div class="tab-pane <?= ($active_tab == 1) ? ' active show' : '' ?>" id="newResidents">
                                        <div class="table">
                                            <div class="card-body">
                                                <form method="POST" action="dashboard1.php?active-tab=1">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="newSearch" name="newSearch" placeholder="Search..." value="<?php echo $search_new; ?>">
                                                        <button class="btn btn-primary" id="newSearchBtn" type="submit">Search</button>
                                                    </div>
                                                </form>
                                                <div class=table-responsive>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="valid-n">
                                                            <?php if (empty($newResidents)) {
                                                                echo '<tr><td colspan="3">No data found.</td></tr>';
                                                            } else {
                                                                foreach ($newResidents as $row) { ?>
                                                                    <tr class="text-center">
                                                                        <td><?php echo $row['name']; ?></td>
                                                                        <td><?php echo $row['email']; ?></td>
                                                                        <td>
                                                                            <form method="post" action="./dashboard1.php?active-tab=1">
                                                                                <input type="hidden" name="userID" value="<?php echo $row['residentID']; ?>">
                                                                                <input type="hidden" name="residentID" value="<?php echo $row['residentID']; ?>">
                                                                                <input type="hidden" name="notifType" id="notifType" value="5">
                                                                                <input type="hidden" name="notifDate" id="notifDate" value="<?php echo date('Y-m-d H:i:s'); ?>">
                                                                                <input type="hidden" name="notifMessage" id="notifMessage" value="">
                                                                                <button type="submit" name="accept" class="btn btn-success" onclick="document.getElementById('notifMessage').value='Your account has been accepted.'">Accept</button>
                                                                                <button type="submit" name="reject" class="btn btn-danger" onclick="document.getElementById('notifMessage').value='Your account has been rejected.'">Reject</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <ul class="pagination">
                                                        <?php for ($n = 1; $n <= $total_pages_new; $n++) { ?>
                                                            <li class="page-item <?= ($n == $page_new) ? 'active' : '' ?>">
                                                                <a class="page-link" href="./dashboard1.php?active-tab=1&page_new=<?= $n ?>&newSearch=<?php echo urlencode($search_new); ?>"><?= $n ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <?php
                                    $items_per_page_valid = 8; // You can adjust this value as needed

                                    // Retrieve the search query from the form submission
                                    $search_valid = isset($_POST['validSearch']) ? $_POST['validSearch'] : '';

                                    // Construct the SQL query to filter data based on the search terms
                                    // Modify this query according to your database structure and requirements
                                    $validResidentsQuery = "SELECT * FROM resident WHERE name LIKE ? AND brgyID = ? AND userStatus = 1";

                                    // Prepare and execute the SQL query
                                    $stmt_valid = mysqli_prepare($conn, $validResidentsQuery);
                                    $search_term_valid = "%$search_valid%"; // Adding wildcards for LIKE search
                                    mysqli_stmt_bind_param($stmt_valid, "si", $search_term_valid, $brgyID); // Assuming $residentID is available
                                    mysqli_stmt_execute($stmt_valid);
                                    $validResidentsResult = mysqli_stmt_get_result($stmt_valid);

                                    // Initialize an array to store the filtered data
                                    $validResidents = [];

                                    // Initialize total pages with default value
                                    $total_pages_valid = 1;

                                    // Check if search results are found
                                    if ($validResidentsResult && mysqli_num_rows($validResidentsResult) > 0) {
                                        // Fetch all search results
                                        $allValidResidents = mysqli_fetch_all($validResidentsResult, MYSQLI_ASSOC);

                                        // Calculate pagination parameters for search results
                                        $total_items_valid = count($allValidResidents);
                                        $total_pages_valid = ceil($total_items_valid / $items_per_page_valid);
                                        $page_valid = isset($_GET['page_valid']) ? $_GET['page_valid'] : 1;
                                        $start_index_valid = ($page_valid - 1) * $items_per_page_valid;

                                        // Slice the search results to display the current page
                                        $validResidents = array_slice($allValidResidents, $start_index_valid, $items_per_page_valid);
                                    }
                                    ?>
                                    <div class="tab-pane <?= ($active_tab == 2) ? ' active show' : '' ?>" id="validResidents">
                                        <div class="table">
                                            <div class="card-body">
                                                <form method="POST" action="dashboard1.php?active-tab=2">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="validSearch" name="validSearch" placeholder="Search..." value="<?php echo $search_valid; ?>">
                                                        <button class="btn btn-primary" id="validBtn" type="submit">Search</button>
                                                    </div>
                                                </form>
                                                <div class=table-responsive>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>View Location</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="valid-v">
                                                            <?php if (empty($validResidents)) {
                                                                echo '<tr><td colspan="4">No data found.</td></tr>';
                                                            } else {
                                                                foreach ($validResidents as $row) { ?>
                                                                    <tr class="text-center">
                                                                        <td><?php echo $row['name']; ?></td>
                                                                        <td><?php echo $row['email']; ?></td>
                                                                        <td>
                                                                            <form method="post" action="proccess_viewResidentLocation.php">
                                                                                <input type="hidden" name="userID" value="<?php echo $row['residentID']; ?>">
                                                                                <button type="submit" name="accept" class="btn btn-success">View Location</button>
                                                                            </form>
                                                                        </td>
                                                                        <td>
                                                                            <form method="post" action="addPetByBao.php">
                                                                                <input type="hidden" name="residentID" value="<?php echo $row['residentID']; ?>">
                                                                                <input type="hidden" name="userType" value="<?php echo $row['userType']; ?>">
                                                                                <input type="hidden" name="brgyID" value="<?php echo $row['brgyID']; ?>">
                                                                                <button type="submit" class="btn btn-primary">Add Pet</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <ul class="pagination">
                                                        <?php for ($v = 1; $v <= $total_pages_valid; $v++) { ?>
                                                            <li class="page-item <?= ($v == $page_valid) ? 'active' : '' ?>">
                                                                <a class="page-link" href="./dashboard1.php?active-tab=2&page_valid=<?= $v ?>&validSearch=<?php echo urlencode($search_valid); ?>"><?= $v ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <?php
                                    // Retrieve the search query from the form submission
                                    $search_rejected = isset($_POST['rejSearch']) ? $_POST['rejSearch'] : '';

                                    // Construct the SQL query to filter data based on the search terms
                                    // Modify this query according to your database structure and requirements
                                    $rejectedResidentsQuery = "SELECT * FROM resident WHERE name LIKE ? AND brgyID = ? AND userStatus = 2";

                                    // Prepare and execute the SQL query
                                    $stmt_rejected = mysqli_prepare($conn, $rejectedResidentsQuery);
                                    $search_term_rejected = "%$search_rejected%"; // Adding wildcards for LIKE search
                                    mysqli_stmt_bind_param($stmt_rejected, "si", $search_term_rejected, $brgyID); // Assuming $brgyID is available
                                    mysqli_stmt_execute($stmt_rejected);
                                    $rejectedResidentsResult = mysqli_stmt_get_result($stmt_rejected);

                                    // Initialize an array to store the filtered data
                                    $rejectedResidents = [];

                                    // Initialize total pages with default value
                                    $total_pages_rejected = 1;

                                    // Check if search results are found
                                    if ($rejectedResidentsResult && mysqli_num_rows($rejectedResidentsResult) > 0) {
                                        // Fetch all search results
                                        $allRejectedResidents = mysqli_fetch_all($rejectedResidentsResult, MYSQLI_ASSOC);

                                        // Calculate pagination parameters for search results
                                        $items_per_page_rejected = 8;
                                        $total_items_rejected = count($allRejectedResidents);
                                        $total_pages_rejected = ceil($total_items_rejected / $items_per_page_rejected);
                                        $page_rejected = isset($_GET['rejected-page']) ? $_GET['rejected-page'] : 1;
                                        $start_index_rejected = ($page_rejected - 1) * $items_per_page_rejected;

                                        // Slice the search results to display the current page
                                        $rejectedResidents = array_slice($allRejectedResidents, $start_index_rejected, $items_per_page_rejected);
                                    }
                                    ?>
                                    <div class="tab-pane <?= ($active_tab == 3) ? ' active show' : '' ?>" id="rejectedResidents">
                                        <div class="table">
                                            <div class="card-body">
                                                <form method="POST" action="dashboard1.php?active-tab=3">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="rejSearch" name="rejSearch" placeholder="Search..." value="<?php echo htmlspecialchars($search_rejected); ?>">
                                                        <button class="btn btn-primary" id="rejBtn" type="submit">Search</button>
                                                    </div>
                                                </form>

                                                <div class=table-responsive>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="valid-r">
                                                            <?php if (empty($rejectedResidents)) {
                                                                echo '<tr><td colspan="4">No data found.</td></tr>';
                                                            } else {
                                                                foreach ($rejectedResidents as $row) { ?>
                                                                    <tr class="text-center">
                                                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex justify-content-center mt-4">
                                                    <ul class="pagination">
                                                        <?php for ($r = 1; $r <= $total_pages_rejected; $r++) { ?>
                                                            <li class="page-item <?= ($r == $page_rejected) ? 'active' : '' ?>">
                                                                <a class="page-link" href="./dashboard1.php?active-tab=3&rejected-page=<?= $r ?>&rejSearch=<?php echo urlencode($search_rejected); ?>"><?= $r ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    $(document).ready(function() {
        $("#newBtn").click(function() {
            var searchValue = $("#newSrch").val().toLowerCase();
            $("#valid-n tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });

        $("#validBtn").click(function() {
            var searchValue = $("#validSrch").val().toLowerCase();
            $("#valid-v tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });

        $("#rejBtn").click(function() {
            var searchValue = $("#rejSrch").val().toLowerCase();
            $("#valid-r tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });
    });
</script>

</html>
<script>
    function switchToValidResidentsTab() {
        // Trigger a click event on the tab link associated with "validResidents"
        document.getElementById("validResidents").click();
        return false; // To prevent the form from submitting immediately
    }
</script>