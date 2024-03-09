<?php
session_start();
$active_tab = $_GET['active-tab'];
require_once("class/pet.php");
require_once("class/barangay.php");

// Check if the user is logged in and has admin privileges (userType = 1)
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] != 1) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['petID'])) {
    // Retrieve the brgyID
    $petID = $_POST['petID'];

    // Now, you can use $brgyID as needed
}
if (isset($_POST['name'])) {
    // Retrieve the brgyID
    $name = $_POST['name'];

    // Now, you can use $brgyID as needed
}
$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';
$residentID = isset($_SESSION['user']['residentID']) ? $_SESSION['user']['residentID'] : '';
$userType = isset($_SESSION['user']['userType']) ? $_SESSION['user']['userType'] : '';
$petID = isset($_SESSION['user']['petID']) ? $_SESSION['user']['petID'] : '';
$user = $_SESSION['user'];
$name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';

$barangay = new Barangay();
$result1 = $barangay->getBrgyName($brgyID);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["verify"]) || isset($_POST["reject"])) {
        $petID = $_POST["petID"];
        $status = isset($_POST["verify"]) ? 1 : 2; // 1 for verified, 2 for not verified

        $pet = new Pet();
        $result = $pet->updatePetStatus($petID, $status);

        if ($result === true) {
            // Successfully updated pet status
            echo '<script>alert("Pet status updated successfully.");</script>';
        } else {
            // Failed to update pet status
            echo "Failed to update pet status: " . $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<<<<<<< HEAD
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
                                    <a href="dashboardBAO.php" class="d-flex align-items-center link-dark">
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
                                </div>s
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
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <form method="post" action="createAccForResident.php">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24h652v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
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
                        <div class="container mt-4">
                            <h1 class="text-center">Manage Pets for Barangay: <?php echo $result1 ?></h1>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link<?= ($active_tab == 1) ? ' active' : '' ?>" href="./dashboard1pet.php?active-tab=1&page_new=1#newPets" data-bs-toggle="tab">New Pets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link<?= ($active_tab == 2) ? ' active' : '' ?>" href="./dashboard1pet.php?active-tab=2&page_valid=1#validPets" data-bs-toggle="tab">Valid Pets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link<?= ($active_tab == 3) ? ' active' : '' ?>" href="./dashboard1pet.php?active-tab=3&page_rej=1#rejectedPets" data-bs-toggle="tab">Rejected Pets</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- New Pets -->
                                <div class="tab-pane <?= ($active_tab == 1) ? ' active show' : '' ?>" id="newPets">
                                    <div class="table">
                                        <div class="card-body">
                                            <label for="newPetSrch" class="form-label"></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="newSrch" placeholder="Search...">
                                                <button class="btn btn-primary" id="newBtn" type="button">Search</button>
                                            </div>
                                            <div class=table-responsive>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Resident Name</th>
                                                            <th>Pet Name</th>
                                                            <th>Type</th>
                                                            <th>Sex</th>
                                                            <th>Color</th>
                                                            <th>Latest Vaccination</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="valid-n">
                                                        <?php
                                                        $pet = new Pet();
                                                        $items_per_page_newPets = 8; // Number of items per page

                                                        // Get total number of new pets
                                                        $total_items_newPets = count($pet->getAllNewPets($brgyID));
                                                        $total_pages_newPets = ceil($total_items_newPets / $items_per_page_newPets);

                                                        // Initialize $page_newPets and set it based on your requirements
                                                        $page_newPets = isset($_GET['page_new']) ? $_GET['page_new'] : 1;

                                                        // Calculate the starting index for the current page
                                                        $start_index_newPets = ($page_newPets - 1) * $items_per_page_newPets;

                                                        // Get the data for the current page
                                                        $newPet = array_slice($pet->getAllNewPets($brgyID), $start_index_newPets, $items_per_page_newPets);
                                                        if (empty($newPet)) {
                                                            echo '<tr><td colspan="3">No data found.</td></tr>';
                                                        } else {
                                                            foreach ($newPet as $row) {
                                                                echo '<tr class="text-center">';
                                                                echo '<td>' . $row['name'] . '</td>';
                                                                echo '<td><button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#petModal_' . $row['petID'] . '">' . $row['pname'] . '</button></td>';
                                                                echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                                                echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                                                echo '<td>' . $row['color'] . '</td>';
                                                                // modal of the pname or pet name
                                                                echo '<div class="modal fade" id="petModal_' . $row['petID'] . '" tabindex="-1" aria-labelledby="petModalLabel_' . $row['petID'] . '" aria-hidden="true">';
                                                                echo '  <div class="modal-dialog">';
                                                                echo '    <div class="modal-content">';
                                                                echo '      <div class="modal-header">';
                                                                echo '        <h3 class="modal-title" id="petModalLabel_' . $row['petID'] . '"><Strong>Pet Details:</Strong></h3>';
                                                                echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                                                echo '      </div>';
                                                                echo '      <div class="modal-body">';
                                                                echo '        <h6><Strong>Name:</Strong> ' . ($row['pname']) . '</h6>';
                                                                echo '        <h6><Strong>Age:</Strong>  ' . ($row['age']) . '</h6>';
                                                                echo '        <h6><Strong>Description:</Strong>  ' . $row['pdescription'] . '</h6>';
                                                                echo '        <h6><Strong>Neutering Status:</Strong>  ' . ($row['Neutering'] == 0 ? 'Not Neutered' : 'Neutered') . '</h6>';
                                                                echo '      </div>';
                                                                echo '    </div>';
                                                                echo '  </div>';
                                                                echo '</div>';

                                                                // formatted date of the current vaccination if available
                                                                echo '<td>';
                                                                if (!empty($row['currentVac'])) {
                                                                    $input_date = $row['currentVac'];
                                                                    $date_obj = new DateTime($input_date);
                                                                    $formatted_date = $date_obj->format("F j, Y");
                                                                    echo $formatted_date;
                                                                }
                                                                echo '</td>';

                                                                echo '<td>' . ($row['statusVac'] == 0 ? 'Vaccinated' : 'Unvaccinated') . '</td>';
                                                                echo '<td>
                                                    <form method="post" action="./dashboard1pet.php?active-tab=1">
                                                        <input type="hidden" name="petID" value="' . $row['petID'] . '">
                                                        <button type="submit" name="verify" class="btn btn-success">Accept</button>
                                                        <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                                    </form>
                                                </td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php for ($n = 1; $n <= $total_pages_newPets; $n++) { ?>
                                                        <li class="page-item <?= ($n == $page_newPets) ? 'active' : '' ?>">
                                                            <a class="page-link" href="./dashboard1pet.php?active-tab=1&page_new=<?= $n ?>"><?= $n ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Valid Pets -->
                                <div class="tab-pane <?= ($active_tab == 2) ? ' active show' : '' ?>" id="validPets">
                                    <div class="table">
                                        <div class="card-body">
                                            <label for="ValidSrch" class="form-label"></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="validSrch" placeholder="Search...">
                                                <button class="btn btn-primary" id="validBtn" type="button">Search</button>
                                            </div>
                                            <div class=table-responsive>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Resident Name</th>
                                                            <th>Pet Name</th>
                                                            <th>Type</th>
                                                            <th>Sex</th>
                                                            <th>Color</th>
                                                            <th>Current Vaccination</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="valid-v">
                                                        <?php
                                                        $pet = new Pet();
                                                        $items_per_page_validPets = 8; // Number of items per page

                                                        // Get total number of valid pets
                                                        $total_items_validPets = count($pet->getAllValidPets($brgyID));
                                                        $total_pages_validPets = ceil($total_items_validPets / $items_per_page_validPets);

                                                        // Initialize $page_validPets and set it based on your requirements
                                                        $page_validPets = isset($_GET['page_valid']) ? $_GET['page_valid'] : 1;

                                                        // Calculate the starting index for the current page
                                                        $start_index_validPets = ($page_validPets - 1) * $items_per_page_validPets;

                                                        // Get the data for the current page
                                                        $validPet = array_slice($pet->getAllValidPets($brgyID), $start_index_validPets, $items_per_page_validPets);
                                                        if (empty($validPet)) {
                                                            echo '<tr><td colspan="3">No data found.</td></tr>';
                                                        } else {
                                                            foreach ($validPet as $row) {
                                                                echo '<tr class="text-center">';
                                                                echo '<td>' . $row['name'] . '</td>';
                                                                echo '<td><button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#petModal_' . $row['petID'] . '">' . $row['pname'] . '</button></td>';
                                                                echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                                                echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                                                echo '<td>' . $row['color'] . '</td>';

                                                                // modal of the pname or pet name
                                                                echo '<div class="modal fade " id="petModal_' . $row['petID'] . '" tabindex="-1" aria-labelledby="petModalLabel_' . $row['petID'] . '" aria-hidden="true">';
                                                                echo '  <div class="modal-dialog modal-lg">';
                                                                echo '    <div class="modal-content">';
                                                                echo '      <div class="modal-header">';
                                                                echo '        <h3 class="modal-title" id="petModalLabel_' . $row['petID'] . '">Pet Name: ' . $row['pname'] . '</h3>';
                                                                echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                                                echo '      </div>';
                                                                echo '      <div class="modal-body">';
                                                                echo '        <h6><Strong> Pet Details:</Strong></h6>';
                                                                echo '        <h6><Strong> Age:</Strong> ' . ($row['age']) . '</h6>';
                                                                echo '        <h6><Strong> Registration Date:</Strong> ' . ($row['regDate']) . '</h6>';
                                                                echo '        <h6><Strong> Description: </Strong>' . $row['pdescription'] . '</h6>';
                                                                echo '        <h6><Strong> Neutering Status: </Strong>' . ($row['Neutering'] == 0 ? 'Not Neutered' : 'Neutered') . '</h6>';

                                                                $petID = $row['petID'];
                                                                $allVaccinationsQuery = "SELECT lastVaccination FROM vaccination WHERE petID = $petID ORDER BY lastVaccination DESC";
                                                                $allVaccinationsResult = mysqli_query($conn, $allVaccinationsQuery);

                                                                if ($allVaccinationsResult && mysqli_num_rows($allVaccinationsResult) > 0) {
                                                                    echo '        <h6>Recent Vaccinations:</h6>';
                                                                    echo '        <ul>';
                                                                    while ($vaccinationRow = mysqli_fetch_assoc($allVaccinationsResult)) {
                                                                        $formattedDate = ($vaccinationRow['lastVaccination'] ? date('F j, Y', strtotime($vaccinationRow['lastVaccination'])) : 'Not Available');
                                                                        echo '          <li>' . $formattedDate . '</li>';
                                                                    }
                                                                    echo '        </ul>';
                                                                } else {
                                                                    echo '        <h6><Strong>Recent Vaccination Date:</Strong> Not available</h6>';
                                                                }

                                                                // Update Vaccination Form
                                                                echo '<form method="post" action="process_updateVacManage.php">';
                                                                echo '    <input type="hidden" name="petID" value="' . $row['petID'] . '">';
                                                                echo '    <input type="hidden" name="statusVac" value="1">';
                                                                echo '    <label for="updateDate">Add New Vaccination Date:</label>';
                                                                if ($row['vetVac'] == 0) {
                                                                    echo '    <input type="date" name="currentVac" id="currentVac" required style="filter: grayscale(100%);">';
                                                                } else {
                                                                    echo '    <input type="date" name="currentVac" id="currentVac" required>';
                                                                }
                                                                echo '    <div class="mb-3">';
                                                                echo '        <label for="BAOremarks">Remarks:</label>';
                                                                echo '        <input type="BAOremarks" class="form-control" name="BAOremarks" id="BAOremarks" required>';
                                                                echo '    </div>';
                                                                echo '    <button type="submit" name="update" class="btn btn-success">Submit</button>';
                                                                echo '</form>';
                                                                
                                                                

                                                                echo '      </div>';
                                                                echo '    </div>';
                                                                echo '  </div>';
                                                                echo '</div>';

                                                                // formatted date of the current vaccination
                                                                $input_date = $row['currentVac'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j, Y");
                                                                echo '<td>' . $formatted_date . '</td>';

                                                                echo '<td>' . ($row['statusVac'] == 0 ? 'Vaccinated' : 'Unvaccinated') . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php for ($v = 1; $v <= $total_pages_validPets; $v++) { ?>
                                                        <li class="page-item <?= ($v == $page_validPets) ? 'active' : '' ?>">
                                                            <a class="page-link" href="dashboard1pet.php?active-tab=2&page_valid=<?= $v ?>"><?= $v ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Rejected Pets -->
                                <div class="tab-pane <?= ($active_tab == 3) ? ' active show' : '' ?>" id="rejectedPets">
                                    <div class="table">
                                        <div class="card-body">
                                            <label for="rejPetSrch" class="form-label"></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="rejSrch" placeholder="Search...">
                                                <button class="btn btn-primary" id="rejBtn" type="button">Search</button>
                                            </div>
                                            <div class=table-responsive>
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Resident Name</th>
                                                            <th>Pet Name</th>
                                                            <th>Type</th>
                                                            <th>Sex</th>
                                                            <th>Color</th>
                                                            <th>Vaccination Date</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="valid-r">
                                                        <?php
                                                        $pet = new Pet();
                                                        $items_per_page_rejectedPets = 8; // Number of items per page

                                                        // Get total number of rejected pets
                                                        $total_items_rejectedPets = count($pet->getAllRejectedPets($brgyID));
                                                        $total_pages_rejectedPets = ceil($total_items_rejectedPets / $items_per_page_rejectedPets);

                                                        // Initialize $page_rejectedPets and set it based on your requirements
                                                        $page_rejectedPets = isset($_GET['page_rej']) ? $_GET['page_rej'] : 1;

                                                        // Calculate the starting index for the current page
                                                        $start_index_rejectedPets = ($page_rejectedPets - 1) * $items_per_page_rejectedPets;

                                                        // Get the data for the current page
                                                        $rejectedPets = array_slice($pet->getAllRejectedPets($brgyID), $start_index_rejectedPets, $items_per_page_rejectedPets);
                                                        if (empty($rejectedPets)) {
                                                            echo '<tr><td colspan="3">No data found.</td></tr>';
                                                        } else {
                                                            foreach ($rejectedPets as $row) {
                                                                echo '<tr class="text-center">';
                                                                echo '<td>' . $row['name'] . '</td>';
                                                                echo '<td><button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#petModal_' . $row['petID'] . '">' . $row['pname'] . '</button></td>';
                                                                echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                                                echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                                                echo '<td>' . $row['color'] . '</td>';

                                                                // modal of the pname or pet name
                                                                echo '<div class="modal fade" id="petModal_' . $row['petID'] . '" tabindex="-1" aria-labelledby="petModalLabel_' . $row['petID'] . '" aria-hidden="true">';
                                                                echo '  <div class="modal-dialog">';
                                                                echo '    <div class="modal-content">';
                                                                echo '      <div class="modal-header">';
                                                                echo '        <h3 class="modal-title" id="petModalLabel_' . $row['petID'] . '">Pet Details: ' . $row['pname'] . '</h3>';
                                                                echo '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                                                                echo '      </div>';
                                                                echo '      <div class="modal-body">';
                                                                echo '        <h6>Age: ' . ($row['age']) . '</h6>';
                                                                echo '        <h6>Registration Date: ' . ($row['regDate']) . '</h6>';
                                                                echo '        <h6>Description: ' . $row['pdescription'] . '</h6>';
                                                                echo '      </div>';
                                                                echo '    </div>';
                                                                echo '  </div>';
                                                                echo '</div>';

                                                                //formatted date of the current vaccination
                                                                $input_date = $row['currentVac'];
                                                                $date_obj = new DateTime($input_date);
                                                                $formatted_date = $date_obj->format("F j, Y");
                                                                echo '<td>' . $formatted_date . '</td>';
                                                                echo '<td>' . ($row['statusVac'] == 0 ? 'Vaccinated' : 'Unvaccinated') . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-center mt-4">
                                                <ul class="pagination">
                                                    <?php for ($r = 1; $r <= $total_pages_rejectedPets; $r++) { ?>
                                                        <li class="page-item <?= ($r == $page_rejectedPets) ? 'active' : '' ?>">
                                                            <a class="page-link" href="./dashboard1pet.php?active-tab=3&page_rej=<?= $r ?>"><?= $r ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- <form method="POST" action="<?php echo ($userType == 1) ? './dashboard1.php?active-tab=1' : 'dashboard.php'; ?>" id="reportDeathCaseForm">
                <input type="hidden" name="residentID" value="<?php echo $brgyID; ?>">
                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                <input type="hidden" name="userType" id="userType" value="<?php echo $userType; ?>">
                <button type="submit" class="btn btn-primary mt-3">Back</button>
            </form>
            <a href="logout.php" class="btn btn-primary mt-3">Logout</a> -->
                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                            </div>
                        </div>
                    </div>
                </main>
=======
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            margin-top: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .nav-link {
            color: #007bff;
        }

        .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
        }

        .tab-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-accept {
            background-color: #28a745;
            color: #ffffff;
        }

        .btn-reject {
            background-color: #dc3545;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Manage Pets for Barangay: <?php echo $result ?></h1>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#newPets" data-bs-toggle="tab">New Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#validPets" data-bs-toggle="tab">Valid Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#rejectedPets" data-bs-toggle="tab">Rejected Pets</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- New Pets -->
            <div class="tab-pane fade show active" id="newPets">
                <div class="card">
                    <div class="card-header">
                        New Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllNewPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '<td>
                                            <form method="post" action="dashboard1pet.php">
                                                <input type="hidden" name="petID" value="' . $row['petID'] . '">
                                                <button type="submit" name="verify" class="btn btn-accept">Accept</button>
                                                <button type="submit" name="reject" class="btn btn-reject">Reject</button>
                                            </form>
                                        </td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Valid Pets -->
            <div class="tab-pane fade" id="validPets">
                <div class="card">
                    <div class="card-header">
                        Valid Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllValidPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Rejected Pets -->
            <div class="tab-pane fade" id="rejectedPets">
                <div class="card">
                    <div class="card-header">
                        Rejected Pets
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Pet Name</th>
                                    <th>Type</th>
                                    <th>Sex</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pet = new Pet();
                                $pets = $pet->getAllRejectedPets($brgyID);

                                while ($row = $pets->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>' . $row['pname'] . '</td>';
                                    echo '<td>' . ($row['petType'] == 0 ? 'Dog' : 'Cat') . '</td>';
                                    echo '<td>' . ($row['sex'] == 0 ? 'Male' : 'Female') . '</td>';
                                    echo '<td>' . $row['color'] . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
>>>>>>> 38bffb789855535e6bf20eccf3ecc7df94f3eed5
            </div>
        </div>

        <a href="dashboard1.php" class="btn btn-primary mt-3">Manage User</a>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 38bffb789855535e6bf20eccf3ecc7df94f3eed5
