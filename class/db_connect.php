<?php
$servername = "petstat-server.mysql.database.azure.com";
$username = "pgwsyvsiti";
$password = "455SGCBRI15EHBWB$";
$dbname = "petstat-server";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
