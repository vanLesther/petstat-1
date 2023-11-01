<?php
require_once "db_connect.php";

class Resident {

    public function checkEmailExists($email) {
        global $conn;

        $stmt = $conn->prepare("SELECT email FROM resident WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

   function registerResident($name, $geoID, $brgyID, $contactNo, $email, $password) {
    global $conn;

    // Create a new instance of the Resident class
    $resident = new Resident();

    // Check if email already exists
    $emailExists = $resident->checkEmailExists($email);

    if ($emailExists) {
        return "Email already registered";
    }

    $stmt = $conn->prepare("INSERT INTO resident (name, geoID, brgyID, contactNo, email, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $geoID, $brgyID, $contactNo, $email, $password);

    try {
        if ($stmt->execute()) {
            // Registration successful
            return true;
        } else {
            // Failed to register resident
            return "Registration failed: " . $stmt->error;
        }
    } catch (Exception $e) {
        // Handle the exception
        return "Registration failed: " . $e->getMessage();
    } finally {
        $stmt->close();
    }
}

    
    

function loginResident($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT resident.*, barangay.barangay FROM resident INNER JOIN barangay ON resident.brgyID = barangay.brgyID WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user) {
        unset($user['password']);
        return $user;
    } else {
        return false;
    }
}


function updateUserStatus($residentID, $status) {
    global $conn;

    $stmt = $conn->prepare("UPDATE resident SET userStatus = ? WHERE residentID = ?");
    $stmt->bind_param("ii", $status, $residentID);

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
public function getAllNewResidents() {
    global $conn;
    
    $query = "SELECT * FROM resident WHERE userStatus = 0";
    $result = $conn->query($query);

    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}
public function getAllValidResidents() {
    global $conn;
    
    $query = "SELECT * FROM resident WHERE userStatus = 1";
    $result = $conn->query($query);

    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}
public function getAllRejectedResidents() {
    global $conn;
    
    $query = "SELECT * FROM resident WHERE userStatus = 2";
    $result = $conn->query($query);

    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}
public function viewResidentLocation($userID) {
    global $conn;

    $query = "SELECT R.geoID, G.latitude, G.longitude, R.name, B.barangay
        FROM resident R
        INNER JOIN geolocation G ON R.geoID = G.geoID
        INNER JOIN barangay B ON R.brgyID = B.brgyID
        WHERE R.residentID = $userID";

    $result = $conn->query($query);

    if (!$result) {
        return false; // Return false if the query fails
    }

    return $result;
}
}  
?>
