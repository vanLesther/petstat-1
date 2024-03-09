<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once("class/resident.php");
require_once("class/geolocation.php");

// Initialize variables to default values
$name = $barangay = $geoID2 = $longitude = $latitude = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $geoID = $_POST["geoID"];

    $residentLocation = new Geolocation();
    $result = $residentLocation->updateGeoLocation($geoID);

    // Convert the PHP array into a JSON string
    $markersJSON = json_encode($result);
    // Decode the JSON string into a PHP array
    $markersArray = json_decode($markersJSON, true);

    // Extract the longitude and latitude values
    $name = $markersArray[0]['name'];
    $barangay = $markersArray[0]['barangay'];
    $geoID2 = $markersArray[0]['geoID'];
    $longitude = $markersArray[0]['longitude'];
    $latitude = $markersArray[0]['latitude'];
    // Echo the JSON string into the JavaScript
    // echo "var markersData = " . $markersJSON . ";\n";
} else {
    // If not a POST request, initialize markersData with an empty array
    // echo "var markersData = [];\n";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            padding: 20px;
            background-color: royalblue;
        }

        #map {
            height: 75vh;
            width: 75vw;
            margin: 20px auto;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <div id="latText">Latitude: </div>
    <div id="lngText">Longitude: </div>
        <!-- Hidden form -->
      <form method="POST" action="process_confirmUpdatedResidentLocation.php" id="newLocForm">
        <input type="hidden" name="lat" id="hiddenLat">
        <input type="hidden" name="lng" id="hiddenLng">
        <input type="hidden" name="geoID" id="hiddenGeoID">
        <input type="hidden" name="active-tab" value="1">
        <button type="submit" class="btn btn-success" id="submitBtn">Change Location</button>
    </form>
    <form method="POST" action="dashboardBiteCases.php?active-tab=1" id="newLocForm">
        <button type="submit" class="btn btn-primary" id="submitBtn">Back</button>
    </form>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var name = <?php echo json_encode($name); ?>;
        var barangay = <?php echo json_encode($barangay); ?>;
        var geoID = <?php echo json_encode($geoID2); ?>;
        var longitude = <?php echo json_encode($longitude); ?>;
        var latitude = <?php echo json_encode($latitude); ?>;

        // Initialize text elements
        var latTextElement = document.getElementById('latText');
        var lngTextElement = document.getElementById('lngText');

        var map = L.map('map').setView([latitude, longitude], 18);

        L.tileLayer('https://api.maptiler.com/maps/dataviz/{z}/{x}/{y}@2x.png?key=A8yOIIILOal2yE0Rvb63', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);

        var marker = L.marker([latitude, longitude], { draggable: true }).addTo(map);
        marker.bindPopup('Name: ' + name + '<br>Barangay: ' + barangay + '<br><p id="latLng' + geoID + '">Latitude: ' + latitude + ', Longitude: ' + longitude + '</p>');

        // Update lat, lng, and text elements on marker drag
        marker.on('dragend', function(e) {
            var latLng = e.target.getLatLng();
            var lat = latLng.lat.toFixed(6);
            var lng = latLng.lng.toFixed(6);

            // Set values in hidden form fields
            document.getElementById('hiddenLat').value = lat;
            document.getElementById('hiddenLng').value = lng;
            document.getElementById('hiddenGeoID').value = geoID;

            // Update text elements
            latTextElement.innerText = 'Latitude: ' + lat;
            lngTextElement.innerText = 'Longitude: ' + lng;
        });
    });
    </script>
</body>
</html>
