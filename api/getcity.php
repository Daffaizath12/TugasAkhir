<?php
// Koneksi ke database
$db = mysqli_connect('localhost', 'root', '', 'travelapps');
if (!$db) {
 die("Connection failed: " . mysqli_connect_error());
}

// Query untuk mengambil kota asal
$queryAsal = "
    SELECT DISTINCT kota_asal 
    FROM daftar_perjalanan
";

$resultAsal = mysqli_query($db, $queryAsal);

// Query untuk mengambil kota tujuan
$queryTujuan = "
    SELECT DISTINCT kota_tujuan 
    FROM daftar_perjalanan
";

$resultTujuan = mysqli_query($db, $queryTujuan);

if ($resultAsal && $resultTujuan) {
 $citiesAsal = array();
 $citiesTujuan = array();

 while ($rowAsal = mysqli_fetch_assoc($resultAsal)) {
  $citiesAsal[] = $rowAsal['kota_asal'];
 }

 while ($rowTujuan = mysqli_fetch_assoc($resultTujuan)) {
  $citiesTujuan[] = $rowTujuan['kota_tujuan'];
 }

 // Mengembalikan hasil dalam format JSON
 echo json_encode(array('success' => true, 'kota_asal' => $citiesAsal, 'kota_tujuan' => $citiesTujuan));
} else {
 echo json_encode(array('success' => false, 'message' => 'Failed to retrieve cities'));
}

// Menutup koneksi database
mysqli_close($db);
