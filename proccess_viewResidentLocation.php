<?php
session_start();

require_once("class/resident.php");
require_once("class/geolocation.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_POST["userID"];

    $resident = new Resident();
    $result = $resident-> viewResidentLocation($userID);
    $markerCode = "";
    // var_dump($result);
        // Successfully updated user status
        // $markerCode = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $geoID = $row['geoID'];
                $lat = $row['latitude'];
                $lng = $row['longitude'];
                $name = $row['name'];
                $barangay = $row['barangay'];
                $markerCode .= "var marker$geoID = L.marker([$lat, $lng]).addTo(map);\n";
                $markerCode .= "marker$geoID.bindPopup('Name: $name<br>Barangay: $barangay <br><form method=\"POST\" action=\"proccess_updateResidentLocation.php\"><button type=\"submit\" name=\"geoID\" value=\"$geoID\" class=\"btn btn-primary\">Update Location</button></form>').openPopup();\n";
        }
        } else {
        // Failed to update user status
        echo "Failed to update user status: " . $result;
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