<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$kota_asal = $_GET['kota_asal'];
$kota_tujuan = $_GET['kota_tujuan'];
$tanggal = $_GET['tanggal'];

// Hitung tanggal 7 hari ke depan dari tanggal yang diberikan
$tanggal_hingga = date('Y-m-d', strtotime($tanggal . ' +7 days'));

// Kueri untuk memilih perjalanan yang memiliki tanggal di antara tanggal yang diberikan dan 7 hari ke depan
$query = "SELECT * FROM daftar_perjalanan WHERE 
            kota_asal = '$kota_asal' AND 
            kota_tujuan = '$kota_tujuan' AND 
            tanggal BETWEEN '$tanggal' AND '$tanggal_hingga'";

$result = mysqli_query($db, $query);

if ($result) {
 $perjalanan = array();

 while ($row = mysqli_fetch_assoc($result)) {
  if (
   $row['tanggal'] > date('Y-m-d') ||
   ($row['tanggal'] == date('Y-m-d') && strtotime($row['waktu_keberangkatan']) > strtotime(date('H:i:s')))
  ) {
   $perjalanan[] = $row;
  }
 }

 if (!empty($perjalanan)) {
  echo json_encode(array('message' => 'success', 'data' => $perjalanan));
 } else {
  echo json_encode(array('success' => false, 'message' => 'Tidak ada jadwal perjalanan'));
 }
}

mysqli_close($db);
