<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$token = $_POST['token'];

$sql = "SELECT * FROM user WHERE token = '$token'";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
 // Data ditemukan
 $row = mysqli_fetch_assoc($result);
 $latitude = $row['latitude'];
 $longitude = $row['longitude'];

 echo json_encode(array('success' => true, 'latitude' => $latitude, 'longitude' => $longitude));
} else {
 // Data tidak ditemukan
 echo json_encode(array('success' => false, 'error' => 'Data not found'));
}

mysqli_close($db);
