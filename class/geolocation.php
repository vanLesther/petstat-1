<?php
require_once "db_connect.php";

class Geolocation {
    public function saveGeolocation($latitude, $longitude) {
        global $conn;

        try {
            $stmt = $conn->prepare("INSERT INTO geolocation (latitude, longitude) VALUES (?, ?)");
            $stmt->bind_param("ss", $latitude, $longitude);
            $stmt->execute();

            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                // Geolocation stored successfully
                $geoID = $stmt->insert_id;
                return $geoID;
            } else {
                // Failed to store geolocation
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

        $stmt->close();
    }
}

?>
