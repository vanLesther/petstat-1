<?php
session_start();

require_once("class/resident.php");
require_once("class/geolocation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $geoID = $_POST["geoID"];

    $residentLocation = new Geolocation();
    $result = $residentLocation->updateGeoLocation($geoID);
    $markerCode = "";

    if ($result) {
        foreach ($result as $row) {
            $geoID = $geoID;
            $lat = $row['latitude'];
            $lng = $row['longitude'];
            $name = $row['name'];
            $barangay = $row['barangay'];

            $markerCode .= "var marker$geoID = L.marker([$lat, $lng], { draggable: true }).addTo(map);\n";
            $markerCode .= "marker$geoID.bindPopup('Name: $name<br>Barangay: $barangay <br><form method=\"POST\" action=\"process_confirmUpdatedResidentLocation.php\">";
            $markerCode .= "<input type=\"hidden\" name=\"latitude\" value=\"$lat\">";
            $markerCode .= "<input type=\"hidden\" name=\"longitude\" value=\"$lng\">";
            $markerCode .= "<input type=\"hidden\" name=\"geoID\" value=\"$geoID\">";
            $markerCode .= "<input type=\"hidden\" name=\"name\" value=\"$name\">";
            $markerCode .= "<input type=\"hidden\" name=\"barangay\" value=\"$barangay\">";
            $markerCode .= "<button type=\"submit\" class=\"btn btn-primary\">Confirm New Location</button></form>').openPopup();\n";

            // Add an event listener to capture marker location when dragged
            $markerCode .= "marker$geoID.on('dragend', function(event) {";
            $markerCode .= "var markerLocation = marker$geoID.getLatLng();";
            $markerCode .= "document.getElementById('latitude$geoID').value = markerLocation.lat;";
            $markerCode .= "document.getElementById('longitude$geoID').value = markerLocation.lng;";
            $markerCode .= "});\n";
        }
    } else {
        // Failed to update user status
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
      height: 800px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <form method="POST" action="process_confirmUpdatedResidentLocation.php">
    <input type="hidden" name="geoID" value="<?php echo $geoID; ?>">
    <input type="hidden" name="latitude" id="latitude<?php echo $geoID; ?>" value="<?php echo $lat; ?>">
    <input type="hidden" name="longitude" id="longitude<?php echo $geoID; ?>" value="<?php echo $lng; ?>">
    <button type="submit" class="btn btn-primary">Confirm New Location</button>
  </form>
  <script>
    var map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lng; ?>], 20);

    L.tileLayer('https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=A8yOIIILOal2yE0Rvb63', {
      attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
    }).addTo(map);

    <?php echo $markerCode; ?>
  </script>
</body>
</html>
