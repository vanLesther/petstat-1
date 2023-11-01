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
    public function updateGeoLocation($geoID) {
    global $conn;

    $query = "SELECT resident.name, barangay.barangay, geolocation.geoID, geolocation.latitude, geolocation.longitude FROM resident 
              INNER JOIN barangay ON resident.brgyID = barangay.brgyID
              INNER JOIN geolocation ON barangay.geoID = geolocation.geoID
              WHERE resident.geoID = $geoID";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    return false;
}
public function confirmUpdatedResidentLocation($geoID, $latitude, $longitude, $conn) {
    $query = "UPDATE geolocation SET latitude = ?, longitude = ? WHERE geoID = ?";

    // Prepare the SQL statement with placeholders
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return false;
    }

    // Bind the parameters to the statement
    $stmt->bind_param("ddi", $latitude, $longitude, $geoID);

    $result = $stmt->execute();

    if ($result) {
        // The query was successful; return the updated location data
        $query = "SELECT g.geoID, g.latitude, g.longitude, r.name, b.barangay
        FROM geolocation g
        INNER JOIN resident r ON g.geoID = r.geoID
        INNER JOIN barangay b ON r.brgyID = b.brgyID
        WHERE g.geoID = ?";

        // Prepare a new statement for the SELECT query
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            return false;
        }

        // Bind the parameter for the SELECT query
        $stmt->bind_param("i", $geoID);

        // Execute the SELECT statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $stmt->close();

        if ($result && $result->num_rows > 0) {
            // Redirect to dashboard1.php with a success message
            header("Location: dashboard1.php?location_updated=true");
            exit; // Ensure no further code execution after the redirection
        }
    }

    return false; // Return false if any step fails
}
}

?>
