<?php
session_start();

require_once("class/resident.php");
require_once("class/geolocation.php");

// Check if the database connection is established.
// Replace the database connection details with your own.
global $conn;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lat = $lng = null; // Initialize variables

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $geoID = $_POST["geoID"];

    $residentLocation = new Geolocation();
    $residentData = $residentLocation->confirmUpdatedResidentLocation($geoID, $_POST["latitude"], $_POST["longitude"], $conn);

    if ($residentData !== false) {
        $updatedGeoID = $residentData['geoID'];
        $lat = $residentData['latitude'];
        $lng = $residentData['longitude'];
        $name = $residentData['name'];
        $barangay = $residentData['barangay'];

        $markerCode = "";
        $markerCode .= "var marker$updatedGeoID = L.marker([$lat, $lng]).addTo(map);\n";
        $markerCode .= "marker$updatedGeoID.bindPopup('Name: $name<br>Barangay: $barangay').openPopup();\n";
    } else {
        echo "Failed to update user status.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <style>
     #map {
      height: 600px;
      border: 2px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      padding: 10px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <script>
  var map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lng; ?>], 20);

    L.tileLayer('https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=A8yOIIILOal2yE0Rvb63', {
      attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
    }).addTo(map);

    <?php echo $markerCode; ?>
  </script>
</body>
</html>
