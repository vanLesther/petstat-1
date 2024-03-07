<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Residents in Barangay</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v1.1.1/maptiler-sdk.umd.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v1.1.1/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v1.0.0/leaflet-maptilersdk.js"></script>
    <script src="https://unpkg.com/heatmap.js"></script>
    <script src="https://unpkg.com/leaflet.heat"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="petstaticon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
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
                    <!-- <div class="row " style="width: 100%;">
                        <div class="container-fluid">
                            <div class="col-md-3 shadow-sm p-3 mb-5 bg-white rounded .col-sm-1 .col-lg-2 d-flex flex-column flex-shrink-0 p-3 bg-light " style="width: 280px;">
                                <div class="left-sidebar--sticky-container js-sticky-leftnav">
                                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none"> -->
                                    <div class="navbar-brand fs-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark">
                                    <a href="dashboardMao.php" class="d-flex align-items-center link-dark">
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
                            <a href="dashboardMAO.php" class="flex-sm-fill text-sm-center nav-link active" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="./assign_officer.php?active-tab=1">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="active-tab" value="1">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2">
                                    <strong><i class="bi bi-person-plus" style="font-size: 1.2rem;"></i></strong> <!-- Bootstrap person plus icon -->
                                    <span class="ms-2 d-none d-sm-inline">Assign Officer</span>
                                </button>
                            </form>
                        </li>

                        <!-- <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Report Case</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-lg" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="addBiteCase.php">Report Bite Case</a></li>
                                <li><a class="dropdown-item" href="addDeathCase.php">Report Death Case</a></li>
                                <li><a class="dropdown-item" href="reportRabidBao.php">Report Rabid Case</a></li>
                            </ul>
                        </li> --> 
                        <!-- <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-decoration-none text-dark px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M448 160H320V128H448v32zM48 64C21.5 64 0 85.5 0 112v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zM448 352v32H192V352H448zM48 288c-26.5 0-48 21.5-48 48v64c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48H48z" />
                                </svg><span class="ms-2 d-none d-sm-inline">Manage</span>
                            </a> -->
                            <!-- <ul class="dropdown-menu dropdown-menu-dark text-lg " aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="./dashboard1.php?active-tab=1">Manage Resident</a></li>
                                <li><a class="dropdown-item" href="./dashboard1pet.php?active-tab=1">Manage Pet</a></li>
                                <li><a class="dropdown-item" href="./dashboardBiteCases.php?active-tab=1">Manage Bite Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardRabidCases.php?active-tab=1">Manage Suspected Cases</a></li>
                                <li><a class="dropdown-item" href="./dashboardDeathCases.php?active-tab=1">Manage Death Cases</a></li>
                            </ul>
                        </li> -->
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
                            <form method="post" action="./tabular.php?active-tab=1" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                                    </svg><span class="ms-2 d-none d-sm-inline"> Reports</span></button>
                            </form>
                        </li>

                        <li class="nav-item">
                            <form method="post" action="logout.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="userType" value="<?php echo $userType; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <button type="submit" class="nav-link text-dark px-sm-0 px-2">
                                    <i class="bi bi-arrow-left"></i> 
                                    <span class="ms-2 d-none d-sm-inline"> Log-out</span>
                                </button>
                            </form>
                        </li>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">


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

                        <!-- <li class="nav-item">
                            <form method="post" action="createAccForResident.php" style="display: inline;">
                                <input type="hidden" name="brgyID" value="<?php echo $brgyID; ?>">
                                <input type="hidden" name="residentID" value="<?php echo $residentID; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>"> -->
                                <!-- <button type="submit" data-bs-toggle="collapse" class="nav-link text-dark px-sm-0 px-2"> <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <!-- <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                    </svg><span class="ms-2 d-none d-sm-inline">Account for Resident</span></button>
                                </a>
                            </form>
                        </li> -->
                        <!-- <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" class="rounded-circle me-2 outline" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <!-- <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                </svg>
                                <strong><span class="d-none d-sm-inline mx-1"> <?php echo isset($user['name']) ? $user['name'] : ''; ?> </span>
                                </strong>
                            </a> -->
                            <!-- <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div> -->
                    </ul>
                </div>
            </div>
            <div class="col d-flex flex-column h-sm-200">
                <main class="row overflow-auto">
                    <div class="col-md-8 p-1 mt-2 my-auto mx-auto">
                        <div class="container mt-2 p-4">
                  <!-- <div class="container mt-5"> -->
                    <!-- <a href="dashboardMAO.php">Back</a> -->
                    <h2>Assign Officer</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="resident-tab" data-toggle="tab" href="#resident" role="tab" aria-controls="resident" aria-selected="true">Residents</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="officer-tab" data-toggle="tab" href="#officer" role="tab" aria-controls="officer" aria-selected="false">Officers</a>
                      </li>
                    </ul>
                    <!-- Residents Tab Content -->
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane active show" id="resident">
                        <form action="" method="GET" id="residentForm">
                          <div class="form-group">
                            <label for="barangaySelect">Select Barangay:</label>
                            <select class="form-control" id="barangaySelect" name="barangay" onchange="submitForm_resident('residentForm')">
                              <option value="0">Select Barangay</option>
                              <?php
                              // Database connection
                              $servername = "localhost"; // Change this accordingly
                              $username = "root"; // Change this accordingly
                              $password = ""; // Change this accordingly
                              $dbname = "petstatvan"; // Change this accordingly

                              $conn = new mysqli($servername, $username, $password, $dbname);

                              // Check connection
                              if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                              }

                              // Query to fetch barangays
                              $sql = "SELECT * FROM barangay";
                              $result = $conn->query($sql);

                              if ($result->num_rows > 0) {
                                  // Output data of each row
                                  while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["brgyID"] . "'>" . $row["barangay"] . "</option>";
                                }
                              } else {
                                  echo "<option>No barangays found</option>";
                              }
                              $conn->close();
                              ?>
                            </select>
                          </div>
                        </form>

                <!-- Display Residents in Selected Barangay -->
                <div id="residentResults">
                    <?php
                    // Fetch residents if barangay is selected
                    if(isset($_GET['barangay'])) {
                        $selected_barangay = $_GET['barangay'];

                        // Database connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Pagination setup
                        $items_per_page = 8;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start_index = ($page - 1) * $items_per_page;
                        
                        // Query to count total residents in selected barangay
                        $count_query = "SELECT COUNT(*) as total FROM resident WHERE brgyID = $selected_barangay";
                        $count_result = $conn->query($count_query);
                        $count_row = $count_result->fetch_assoc();
                        $total_residents = $count_row['total'];
                        
                        // Calculate total pages
                        $total_pages = ceil($total_residents / $items_per_page);
                        
                        // Query to fetch residents in selected barangay with pagination
                        $sql = "SELECT * FROM resident WHERE brgyID = $selected_barangay LIMIT $start_index, $items_per_page";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["name"] . "</td>
                                        <td>" . $row["email"] . "</td>";
                        
                                if ($row['userType'] == 1) {
                                    echo '<td><button type="button" class="btn btn-success" disabled>Assigned</button></td>';
                                } else {
                                    echo '<td>
                                            <form method="POST" action="process_assign.php" class="assign-form" data-brgyid="' . $selected_barangay . '" onsubmit="return confirmAssign(this);">
                                                <input type="hidden" name="residentID" value="' . $row['residentID'] . '">
                                                <input type="hidden" name="notifDate" value="' . date('Y:m:d H:i:s') . '">
                                                <input type="hidden" name="notifType" value="10">
                                                <input type="hidden" name="page" value="' . $page . '">
                                                <input type="hidden" name="barangay" value="' . $row['brgyID'] . '">
                                                <input type="hidden" name="notifMessage" value="Your account has been assigned as Barangay Officer.">
                                                <input type="hidden" name="brgyID" value="' . $selected_barangay . '">
                                                <button type="submit" name="Assign" class="btn btn-success">Assign</button>
                                            </form>
                                        </td>';
                                }
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        
                            // Pagination links
                            echo '<div class="d-flex justify-content-center mt-4">
                                    <ul class="pagination">';
                            for ($b = 1; $b <= $total_pages; $b++) {
                                echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                        <a class="page-link" href="assign_officer.php?barangay=' . $selected_barangay . '&page=' . $b . '">' . $b . '</a>
                                      </li>';
                            }
                            echo '</ul></div>';
                        } else {
                            echo "<p>No residents found in selected barangay</p>";
                        }
                        $conn->close();
                        } else {
                            echo "<p>No barangay selected</p>";
                        }
                        ?>
                        </div>
                        </div>
                        

                      <!-- Officers Tab Content -->
                      <div class="tab-pane" id="officer">
                        <form action="" method="GET" id="officerForm">
                          <div class="form-group">
                            <label for="barangaySelectOfficer">Select Barangay:</label>
                            <select class="form-control" id="barangaySelectOfficer" name="barangay_officer" onchange="submitForm('officerForm')">
                              <option value="0">Select Barangay</option>
                              <?php
                              // Database connection
                              $conn = new mysqli($servername, $username, $password, $dbname);

                              // Check connection
                              if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                              }

                              // Query to fetch barangays
                              $sql = "SELECT * FROM barangay";
                              $result = $conn->query($sql);

                              if ($result->num_rows > 0) {
                                  // Output data of each row
                                  while($row = $result->fetch_assoc()) {
                                    $selected = (isset($_GET['barangay_officer']) && $_GET['barangay_officer'] == $row["brgyID"]) ? "selected" : "";
                                    echo "<option value='" . $row["brgyID"] . "' $selected>" . $row["barangay"] . "</option>";
                                }
                              } else {
                                  echo "<option value>No barangays found</option>";
                              }
                              $conn->close();
                              ?>
                            </select>
                          </div>
                        </form>

                        <!-- Display Officers in Selected Barangay -->
                        <div id="officerResults">
                            <?php
                            // Fetch officers if barangay is selected
                            if (isset($_GET['barangay_officer'])) {
                                $selected_barangay_officer = $_GET['barangay_officer'];

                                // Database connection
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Pagination setup
                                $items_per_page = 8;
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start_index = ($page - 1) * $items_per_page;

                                // Query to count total officers in selected barangay
                                $count_query = "SELECT COUNT(*) as total FROM resident WHERE brgyID = $selected_barangay_officer AND userType = 1";
                                $count_result = $conn->query($count_query);
                                $count_row = $count_result->fetch_assoc();
                                $total_officers = $count_row['total'];

                                // Calculate total pages
                                $total_pages = ceil($total_officers / $items_per_page);

                                // Query to fetch officers in selected barangay with userType = 1 with pagination
                                $sql = "SELECT * FROM resident WHERE brgyID = $selected_barangay_officer AND userType = 1 LIMIT $start_index, $items_per_page";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo "<table class='table'>";
                                    echo "<thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>";
                                    echo "<tbody>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>" . $row["name"] . "</td>
                                                <td>" . $row["email"] . "</td>
                                                <td>
                                                    <form method='post' action='process_revoke.php' onsubmit='return confirmRevoke();'>
                                                        <input type='hidden' name='residentID' value='" . $row['residentID'] . "'>
                                                        <input type='hidden' name='notifDate' value='" . date('Y-m-d H:i:s') . "'>
                                                        <input type='hidden' name='notifType' value='11'>
                                                        <input type='hidden' name='barangay' value='" . $row['brgyID'] . "'>
                                                        <input type='hidden' name='page' value='" . $page . "'>
                                                        <input type='hidden' name='total' value='" . $total_pages . "'>
                                                        <input type='hidden' name='notifMessage' value='Your account has been revoked as Barangay Officer.'>    
                                                        <input type='hidden' name='brgyID' value='" . $selected_barangay_officer . "'>
                                                        <button type='submit' name='Revoke' class='btn btn-danger'>Revoke</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                    }
                                    echo "</tbody></table>";

                                    // Pagination links
                                    echo '<div class="d-flex justify-content-center mt-4">
                                            <ul class="pagination">';
                                    for ($b = 1; $b <= $total_pages; $b++) {
                                        echo '<li class="page-item ' . (($b == $page) ? 'active' : '') . '">
                                                <a class="page-link" href="assign_officer.php?barangay_officer=' . $selected_barangay_officer . '&page=' . $b . '">' . $b . '</a>
                                            </li>';
                                    }
                                    echo '</ul></div>';
                                } else {
                                    echo "<p>No officers found in selected barangay</p>";
                                }
                                $conn->close();
                            } else {
                                echo "<p>No barangay selected</p>";
                            }
                            ?>
                        </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </main>
            </div>
  <!-- Bootstrap JS and jQuery (optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function submitForm_resident(formId) {
      document.getElementById(formId).submit();
    }

    // JavaScript to redirect to officers tab and selected barangay after form submission
    window.onload = function() {
      // Check if there is a selected barangay for officers
      <?php if(isset($_GET['barangay'])) { ?>
        // Redirect to the officers tab and selected barangay
        document.getElementById('resident-tab').click();
      <?php } ?>
    }
  </script>

  <script>
    function submitForm(formId) {
      document.getElementById(formId).submit();
    }

    // JavaScript to redirect to officers tab and selected barangay after form submission
    window.onload = function() {
      // Check if there is a selected barangay for officers
      <?php if(isset($_GET['barangay_officer'])) { ?>
        // Redirect to the officers tab and selected barangay
        document.getElementById('officer-tab').click();
      <?php } ?>
    }
  </script>
  <script>
    function confirmAssign(form) {
        return confirm('Are you sure you want to assign this resident?');
    }

    function confirmRevoke() {
        return confirm('Are you sure you want to revoke this officer?');
    }
</script>

</script>
</body>
</html>
