<?php
require_once "db_connect.php";

class Barangay {
    public function getBrgyID($barangay) {
        global $conn;

        try {
            $stmt = $conn->prepare("SELECT brgyID FROM barangay WHERE barangay = ?");
            $stmt->bind_param("s", $barangay);
            $stmt->execute();
            $stmt->bind_result($brgyID);
            $stmt->fetch();
            
            $stmt->close();
            
            return $brgyID;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

?>
