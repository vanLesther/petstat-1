<?php
require_once "db_connect.php";

class Pet {
    private $conn;


    public function addPet($residentID, $petType, $name, $sex, $color) {
        global $conn;
        try {
            $stmt = $conn->prepare("INSERT INTO pet (residentID, petType, pname, sex, color)
                                         VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisss", $residentID, $petType, $name, $sex, $color);
            $stmt->execute();
    
            // Check if the insertion was successful
            if ($stmt->affected_rows > 0) {
                // Pet added successfully
                $petID = $stmt->insert_id;
                $stmt->close();
                return true;
            } else {
                // Failed to add pet
                $stmt->close();
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function getPetsByResidentID($residentID) {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM pet WHERE residentID = ?");
            $stmt->bind_param("i", $residentID);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Fetch all pets as an associative array
            $pets = $result->fetch_all(MYSQLI_ASSOC);
    
            $stmt->close();
            return $pets;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function getAllNewPets(){
        global $conn;

        $query = "SELECT * FROM resident NATURAL JOIN pet WHERE status = 0";
        $result = $conn->query($query);
        if (!$result) {
            return false; // Return false if the query fails
        }
    
        return $result;
    }

    public function getAllValidPets(){
        global $conn;

        $query = "SELECT * FROM resident NATURAL JOIN pet WHERE status = 1";
        $result = $conn->query($query);
        if (!$result) {
            return false; // Return false if the query fails
        }
    
        return $result;
    }

    public function getAllRejectedPets(){
        global $conn;

        $query = "SELECT * FROM resident NATURAL JOIN pet WHERE status = 2";
        $result = $conn->query($query);
        if (!$result) {
            return false; // Return false if the query fails
        }
    
        return $result;
    }
    public function updatePetStatus($petID, $status){
        global $conn;

        $stmt = $conn->prepare("UPDATE pet SET status = ? WHERE petID = ?");
        $stmt->bind_param("ii", $status, $petID);

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