<?php
session_start();
require_once 'class/resident.php';

$resident = new Resident();

// Check if the user is logged in
if (isset($_POST['residentID'])) {
    // Retrieve the residentID from the POST data
    $residentID = $_POST['residentID'];

    // Now, you can use $residentID as needed
    $_SESSION['residentID'] = $residentID; // Optionally store it in the session for later use
}
if (isset($_POST['userType'])) {
    // Retrieve the residentID from the POST data
    $userType = $_POST['userType'];

    // Now, you can use $residentID as needed
    $_SESSION['userType'] = $userType; // Optionally store it in the session for later use
}
if (isset($_POST['brgyID'])) {
    // Retrieve the residentID from the POST data
    $brgyID = $_POST['brgyID'];

    // Now, you can use $residentID as needed
    $_SESSION['brgyID'] = $brgyID; // Optionally store it in the session for later use
}

$user = $_SESSION['user'];

$brgyID = isset($_SESSION['user']['brgyID']) ? $_SESSION['user']['brgyID'] : '';
$residentID = isset($_SESSION['user']['residentID']) ? $_SESSION['user']['residentID'] : '';
$userType = isset($_SESSION['user']['userType']) ? $_SESSION['user']['userType'] : '';
$name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : '';
$userStatus = isset($_SESSION['user']['userStatus']) ? $_SESSION['user']['userStatus'] : '';

// Retrieve residentID from the session
$residentIDFromSession = isset($_SESSION['residentID']) ? $_SESSION['residentID'] : '';
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
<body>
<div class="container-fluid overflow-hidden">
        <div class="row vh-100 overflow-auto">
            <div class="col-12 col-sm-3 shadow-sm bg-gray col-xl-2 px-sm-2 px-0 d-flex sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">

              <div class="navbar-brand fs-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark">
                <a href="#" class="d-flex align-items-center link-dark">
                    <span class="">
                        <img class="bi me-2" width="55" height="55" role="img" src="petstaticon.svg"></img>
                        <span class="d-none d-sm-inline pt-3"><strong>PETSTAT</strong></span>
                    </span>
                </a>
                <!-- <div class="d-flex align-items-center ms-auto">
                    <a href="#" class="btn btn-link me-2" data-bs-toggle="modal" data-bs-target="#notificationModal">
                        <i class="bi bi-bell fs-4"></i>
                    </a>
                </div> -->
            </div>

                    <!-- <div class="d-flex align-items-center ms-auto">
                        <button type="button" class="btn btn-primary-outline me-2" data-bs-toggle="modal" data-bs-target="#notificationModal">Notification</button>
                    </div>
                </div> -->


                    <ul class="nav nav-underline flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="./dashboard.php?active-tab=1" class="flex-sm-fill text-sm-center nav-link text-dark" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <form method="post" action="./dashboard.php?active-tab=1">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="active-tab" value="1">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link active text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" />
                                    <!-- </svg> <span class="ms-2 d-none d-sm-inline">Pet Dashboard</span></button>
                            </form>
                        </li> -->
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Report Case</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="addBiteCaseIndiv.php">Report Bite Case</a></li>
                                <li><a class="dropdown-item" href="addDeathCaseIndiv.php">Report Death Case</a></li>
                                <li><a class="dropdown-item" href="reportRabidResident.php">Report Rabid Case</a></li>
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
                        <div class="col-md-auto">
                            <a href="./dashboard.php?active-tab=2" class="btn btn-primary rounded-circle p-2">
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>
        <h1>Pet Registration Form</h1>
        <form id="addPetForm" action="process_addPet.php" onsubmit="return confirmAdd();" method="POST">
        <div class="mb-3">
    <label for="pname" class="form-label">Pet's Name:<span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="pname" id="pname" required>
</div>
<div class="mb-3">
    <label for="petType" class="form-label">Species:<span class="text-danger">*</span></label>
    <select class="form-select" name="petType" id="petType" required>
        <option value="">Select Pet Type</option>
        <option value="0">Dog</option>
        <option value="1">Cat</option>
    </select>
</div>
<div class="mb-3">
    <label for="sex" class="form-label">Sex:<span class="text-danger">*</span></label>
    <select class="form-select" name="sex" id="sex" required>
        <option value="">Select Sex</option>
        <option value="0">Male</option>
        <option value="1">Female</option>
    </select>
</div>
<div class="mb-3">
    <label for="color" class="form-label">Color:<span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="color" id="color" required>
</div>
<div class="mb-3">
    <label for="neutering" class="form-label">Neutering Status:<span class="text-danger">*</span></label>
    <select class="form-select" name="neutering" id="neutering" required>
        <option value="">Select Status</option>
        <option value="0">Yes</option>
        <option value="1">No</option>
    </select>
</div>
<div class="mb-3">
    <label for="statusVac" class="form-label">Vaccination Status:<span class="text-danger">*</span></label>
    <select class="form-select" name="statusVac" id="statusVac" required onchange="toggleCurrentVac()">
        <option value="">Select Status</option>
        <option value="0">Yes</option>
        <option value="1">No</option>
    </select>
</div>
<div class="mb-3">
    <label for="vetVac" class="form-label">Select if pet is vet Vaccinated</label><br>
    <input type="radio" name="vetVac" id="notVetVaccinated" value="0" checked>
    <label for="notVetVaccinated">Yes</label><br>
    <input type="radio" name="vetVac" id="vetVaccinated" value="1">
    <label for="vetVaccinated">No</label>
</div>

<div class="mb-3">
    <label for="currentVac" class="form-label">Current Vaccination</label>
    <input type="date" class="form-control" name="currentVac" id="currentVac" disabled>
</div>
<div class="mb-3">
    <label for="age" class="form-label">Pet's Age:</label>
    <input type="numbers" class="form-control" name="age" id="age">
</div>
<div class="mb-3">
    <label for="pdescription" class="form-label">Description:<span class="text-danger">*</span></label>
    <textarea class="form-control" name="pdescription" id="pdescription" required></textarea>
</div>

            <div class="modal-footer">
            <input type="hidden" name="status" id="status" value="1">
            <input type="hidden" name="regDate" id="regDate" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="residentID" id="residentID" value="<?php echo $residentIDFromSession; ?>">
            <input type="hidden" name="notifType" id="notifType" value="1">
            <input type="hidden" name="notifDate" id="notifDate" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="notifMessage" id="notifMessage" value="A new pet has been registered.">
            <input type="hidden" name="userType" ided="userType" value="<?php echo $userType; ?>">
            <input type="hidden" name="brgyID" id="brgyID" value="<?php echo $brgyID; ?>">
                <input type="submit" value="Add Pet" class="btn btn-primary">
            </div>
</form>
            <!-- <form method="post" action="./dashboard.php?active-tab=1" onsubmit="switchToValidResidentsTab()">
                <input type="hidden" name="residentID" id="residentID" value="<?php echo $residentIDFromSession; ?>">
                <button type="submit" class="btn btn-primary">Back</button>
            </form> -->
</div>
</div>
</main>
</div>
<script>
    function toggleCurrentVac() {
        var statusVac = document.getElementById("statusVac");
        var currentVac = document.getElementById("currentVac");

        if (statusVac.value === "0") {
            currentVac.disabled = false;
        } else {
            currentVac.disabled = true;
            currentVac.value = ""; // Clear the input value when disabled
        }
    }
</script>
    <!-- Add Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

   
