<?php
require_once "db_connect.php";

class Cases {
    public function addBiteCase($residentID, $petName, $geoID, $ownerName, $caseType, $description, $caseDate) {
        global $conn;
        try {
            $petID = $this->getPetIDByName($petName);
            $ownerID = $this->getOwnerIDByName($ownerName);
    
            if (!$petID || !$ownerID) {
                return "Pet or owner not found in the database.";
            }
    
            $stmt = $conn->prepare("INSERT INTO `case` (residentID, petID, geoID, ownerID, caseType, description, date)
                VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("iiisss", $residentID, $petID, $geoID, $ownerID, $caseType, $description);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true; // Case added successfully
            } else {
                $stmt->close();
                return "Failed to add the case to the database.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    // Helper function to get petID by pet name
    private function getPetIDByName($petName) {
        global $conn;
        $stmt = $conn->prepare("SELECT petID FROM pet WHERE pname = ?");
        $stmt->bind_param("s", $petName);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($petID);
            $stmt->fetch();
            return $petID;
        }
    
        return false;
    }
    
    // Helper function to get ownerID by owner name
    private function getOwnerIDByName($ownerName) {
        global $conn;
        $stmt = $conn->prepare("SELECT residentID FROM resident WHERE name = ?");
        $stmt->bind_param("s", $ownerName);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($ownerID);
            $stmt->fetch();
            return $ownerID;
        }
    
        return false;
    }
}
?>
