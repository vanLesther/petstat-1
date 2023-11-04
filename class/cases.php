<?php
require_once "db_connect.php";

class Cases {
    public function addBiteCase($residentID, $brgyID, $petName, $geoID, $victimsName, $caseType, $description, $currentDate) {
        global $conn;
        try {
            $petID = $this->getPetIDByName($petName);
    
            if (!$petID ==true) {
                return "Pet or owner not found in the database.";
            }
    
            $stmt = $conn->prepare("INSERT INTO `case` (residentID, barangayID, petID, caseGeoID, victimsName, caseType, description, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiissss", $residentID, $brgyID, $petID, $geoID, $victimsName, $caseType, $description, $currentDate);
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

    public function getAllNewBiteCase() {
        global $conn;
        
        $query = "SELECT * FROM `case` NATURAL JOIN pet WHERE caseStatus = 0 AND caseType = 0";
        $result = $conn->query($query);
    
        if (!$result) {
            return false; // Return false if the query fails
        }
    
        return $result;
    }
    
public function getAllValidBiteCase() {
    global $conn;
    
    $query = "SELECT * FROM `case` NATURAL JOIN pet WHERE caseStatus = 1 AND caseType = 0";
    $result = $conn->query($query);
    
    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}

public function getAllRejectedBiteCase() {
    global $conn;
    
    $query = "SELECT * FROM `case` NATURAL JOIN pet WHERE caseStatus = 2 AND caseType = 0";
    $result = $conn->query($query);
    
    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}

public function updateBiteCaseStatus($caseID, $caseStatus){
    global $conn;

    $stmt = $conn->prepare("UPDATE `case` SET caseStatus = ? WHERE caseID = ?");
    $stmt->bind_param("ii", $caseStatus, $caseID);

    try {
        if ($stmt->execute()) {
            // Update successful
            return true;
        } else {
            // Failed to update user status
            return "Failed to update user status: " . $stmt->error;
        }
    } catch (Exception $e) {
        // Handle the exception
        return "Failed to update user status: " . $e->getMessage();
    } finally {
        $stmt->close();
    }
}

}
?>
