<?php
session_start();

require_once("class/resident.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_POST["userID"];

    $resident = new Resident();
    $result = $resident->viewResidentLocation($userID);
    $markerCode = "";

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $geoID = $row['geoID'];
          $lat = $row['latitude'];
          $lng = $row['longitude'];
          $name = $row['name'];
          $barangay = $row['barangay'];
  
          $markerCode .= "var marker$geoID = L.marker([$lat, $lng]).addTo(map);\n";
          $markerCode .= "marker$geoID.bindPopup('Name: $name<br>Barangay: $barangay <br><form method=\"POST\" action=\"process_updateResidentLocation.php\"><button type=\"submit\" name=\"geoID\" value=\"$geoID\" class=\"btn btn-primary\">Update Location</button></form>').openPopup();\n";
      }
  }
  
} else {  
    // Handle other cases if needed
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  
  <script>
    function updateLocation(geoID) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'update_location.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.latitude && response.longitude) {
            var newLat = response.latitude;
            var newLng = response.longitude;
            var updatedMarker = marker[geoID];
            updatedMarker.setLatLng([newLat, newLng]);
            updatedMarker.openPopup();
            alert('Location updated successfully!');
          } else {
            alert('Failed to update location.');
          }
        }
      };
      xhr.send('geoID=' + encodeURIComponent(geoID));
    }
  </script>

  <style>
    #map {
      height: 800px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <script>
    // Initialize the map and add markers
    var map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lng; ?>], 20);

    L.tileLayer('https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=A8yOIIILOal2yE0Rvb63', {
      attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
    }).addTo(map);

    <?php echo $markerCode; ?>
  </script>
</body>
</html>
