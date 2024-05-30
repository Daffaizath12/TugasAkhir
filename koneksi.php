<?php
// Koneksi ke database MySQL
$servername = "Localhost";
$username = "root";
$password = "";
$database = "travelapps";

$conn = new mysqli($servername, $username, $password, $database);
//Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}

return $conn;
