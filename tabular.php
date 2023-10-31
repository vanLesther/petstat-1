<?php
require_once("class/pet.php");
require_once("class/barangay.php");
require_once("class/db_connect.php");
require_once("class/resident.php");

$pet = new Pet();
$barangay = new Barangay();
$resident = new Resident();

$pets = null;
$officers = null;

$sex = array(
    0 => "Male",
    1 => "Female"
);

$neutering = array(
    0 => "Not Neutered",
    1 => "Neutered"
);

$vaccinationStatus = array(
    0 => "Not Vaccinated",
    1 => "Vaccinated"
);

$petType = array(
    0 => "Dog",
    1 => "Cat"
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['selectedBarangay'])) {
        $selectedBarangay = $_POST['selectedBarangay'];
        $brgyID = $barangay->getBrgyID($selectedBarangay);
        $pets = $pet->getRegistries($brgyID);
        $cases = $resident->getOfficersByBarangay($brgyID);
    } else {
        // If no barangay is selected, fetch all pet registries
        $registries = $pet->getRegistriesForAllBrgys();
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assign Officer</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Add Bootstrap JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
    <div class="container">
        <h1>Tabular Form</h1>
        <form method="POST" action="" id="tabform" name="Tabform">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#registered" data-bs-toggle="tab">Registries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Cases" data-bs-toggle="tab">Cases</a>
                </li>
            </ul>
            <label for="barangay" class="form-label">Barangay:</label>
            <select id="barangay" class="form-select" name="selectedBarangay" required>
                <option value="">Select Barangay</option>
                <?php
                $brgys = $barangay->getBrgys();
                foreach ($brgys as $brgy) {
                    echo '<option value="' . $brgy[0] . '">' . $brgy[2] . '</option>';
                }
                ?>
            </select> 
        </form>

        <!-- Tab Content -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="registered">
                        <table class="table">
                    <thead>
                    <tr>
                                <th>Owner's Name</th>
                                <th>Date of Registry</th>
                                <th>petType</th>
                                <th>Name of Pet</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Vaccination Status</th>
                                <th>Neutering</th>
                                <th>Color</th>
                                <th>Address</th>
                            </tr>
                            <tbody id="valid-r">
                                <?php
                                if ($pets) {
                                    foreach ($pets as $pet) {
                                        echo '<tr>';
                                        echo '<td>' . $pet['name'] . '</td>';
                                        echo '<td>' . $pet['date'] . '</td>';
                                        echo '<td>' . $petType[$pet['petType']] . '</td>';
                                        echo '<td>' . $pet['pname'] . '</td>';
                                        echo '<td>' . $sex[$pet['sex']] . '</td>';
                                        echo '<td>' . $pet['age'] . '</td>';
                                        echo '<td>' . $vaccinationStatus[$pet['vaccination']] . '</td>';
                                        echo '<td>' . $neutering[$pet['neutering']] . '</td>';
                                        echo '<td>' . $pet['color'] . '</td>';
                                        echo '<td>' . $pet['address'] . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="10">No pet registries found for the selected barangay.</td></tr>';
                                }
                        ?>
                    </tbody>
                </table>
            </div>

           <!-- Officers -->
        <div class="tab-pane fade" id="Cases">
            <table class="table">
                <thead>
                <label for="cases" class="form-label"></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="cases"
                                placeholder="Search by name or email">
                            <button class="btn btn-primary" id="cases" type="button">Search</button>
                        </div>
                    <tr>
                        <th>Pet</th>
                        <th>Victim</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="valid-o">
                    <?php
                    if ($officers && $officers->num_rows > 0) { 
                        while ($row = $officers->fetch_assoc()) {
                            echo '<tr>'; 
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>
                                <form method="POST" action="process_revoke.php">
                                    <input type="hidden" name="residentID" value="' . $row['residentID'] . '">
                                    <input type="hidden" name="brgyID" value="' . $row['brgyID'] . '">
                                    <button type="submit" name="Revoke" class="btn btn-danger">Revoke</button>
                                </form>
                            </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">Select Barangay to display Officers.</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>



        <script>
            $("#registries").click(function () {
                var searchValue = $("#registries").val().toLowerCase();
                $("#valid-r tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });

         
            $("#cases").click(function () {
                var searchValue = $("#cases").val().toLowerCase();
                $("#valid-o tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });
        </script>
          <script>
            $("#barangay").on("change", function () {
                $.post('ajax/getRegistriesByBrgy.php', {brgyid: $(this).val()}).done(function (data) {
                    $("#valid-r").html(data);
                });
            });

            $("#barangay").on("change", function () {
                $.post('ajax/getOfficersByBrgy.php', {brgyid: $(this).val()}).done(function (data) {
                    $("#valid-o").html(data);
                });
            });
        </script>
    </div>
    </body>
    </html>