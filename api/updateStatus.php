<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

$sqlUpdateStatus = "UPDATE pemesanan SET status = '$status' WHERE order_id = '$order_id'";
if (!mysqli_query($db, $sqlUpdateStatus)) {
 echo json_encode(array('success' => false, 'error' => 'Failed to update status'));
 exit;
}

if ($status == 'Gagal') {
 $sqlGetPemesanan = "SELECT * FROM pemesanan WHERE order_id = '$order_id'";
 $result = mysqli_query($db, $sqlGetPemesanan);
 $row = mysqli_fetch_assoc($result);

 $qty = $row['qty'];
 $id_perjalanan = $row['id_perjalanan'];

 $sqlGetJumlahPenumpang = "SELECT jumlah_penumpang FROM daftar_perjalanan WHERE id_perjalanan = '$id_perjalanan'";
 $result = mysqli_query($db, $sqlGetJumlahPenumpang);
 $row = mysqli_fetch_assoc($result);
 $jumlah_penumpang_sekarang = $row['jumlah_penumpang'];


 $new_jumlah_penumpang = $jumlah_penumpang_sekarang + $qty;
 $sqlUpdateJumlahPenumpang = "UPDATE daftar_perjalanan SET jumlah_penumpang = '$new_jumlah_penumpang' WHERE id_perjalanan = '$id_perjalanan'";
 if (!mysqli_query($db, $sqlUpdateJumlahPenumpang)) {
  echo json_encode(array('success' => false, 'error' => 'Gagal mengupdate jumlah penumpang'));
  exit;
 }
}

echo json_encode(array('success' => true));

mysqli_close($db);
