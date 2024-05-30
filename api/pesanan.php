<?php
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$id_user = $_POST['id_user'];
$id_perjalanan = $_POST['id_perjalanan'];
$order_id = $_POST['order_id'];
$alamat_jemput = $_POST['alamat_jemput'];
$alamat_tujuan = $_POST['alamat_tujuan'];
$waktu_jemput = $_POST['waktu_jemput'];
$status = $_POST['status'];
$qty = $_POST['qty'];
$tanggal_pesan = date("Y-m-d");
$tanggal_berangkat = $_POST['tanggal_berangkat'];
$status_penjemputan = 'active';
$harga = $_POST['harga'];
// $lat_jemput = $_POST['lat_jemput'];
// $lng_jemput = $_POST['lng_jemput'];
$lat_tujuan = $_POST['lat_tujuan'];
$lng_tujuan = $_POST['lng_tujuan'];

$sqlGetJumlahPenumpang = "SELECT jumlah_penumpang FROM daftar_perjalanan WHERE id_perjalanan = '$id_perjalanan'";
$result = mysqli_query($db, $sqlGetJumlahPenumpang);
$row = mysqli_fetch_assoc($result);
$jumlah_penumpang_sekarang = $row['jumlah_penumpang'];

if ($qty > $jumlah_penumpang_sekarang) {
 echo json_encode(array('success' => false, 'error' => 'Jumlah penumpang melebihi yang tersedia'));
 exit;
}

$new_jumlah_penumpang = $jumlah_penumpang_sekarang - $qty;
$sqlUpdateJumlahPenumpang = "UPDATE daftar_perjalanan SET jumlah_penumpang = '$new_jumlah_penumpang' WHERE id_perjalanan = '$id_perjalanan'";
if (!mysqli_query($db, $sqlUpdateJumlahPenumpang)) {
 echo json_encode(array('success' => false, 'error' => 'Gagal mengupdate jumlah penumpang'));
 exit;
}

// Insert lat-long jemput
// $sqlInsertLatLngJemput = "INSERT INTO lokasi (lat, lng) VALUES ('$lat_jemput', '$lng_jemput')";
// if (!mysqli_query($db, $sqlInsertLatLngJemput)) {
//  echo json_encode(array('success' => false, 'error' => 'Gagal menginsert lokasi jemput'));
//  exit;
// }
// $id_lokasi_jemput = mysqli_insert_id($db);

// Insert lat-long tujuan
$sqlInsertLatLngTujuan = "INSERT INTO lokasi (lat, lng) VALUES ('$lat_tujuan', '$lng_tujuan')";
if (!mysqli_query($db, $sqlInsertLatLngTujuan)) {
 echo json_encode(array('success' => false, 'error' => 'Gagal menginsert lokasi tujuan'));
 exit;
}
$id_lokasi_tujuan = mysqli_insert_id($db);

// Insert pemesanan dengan latlong_jemput dan latlong_tujuan
$sqlInsert = "INSERT INTO pemesanan (id_user, id_perjalanan, order_id, qty, alamat_jemput, alamat_tujuan, waktu_jemput, status, tanggal_pesan, tanggal_berangkat, harga, status_penjemputan, latlong_tujuan) 
              VALUES ('$id_user', '$id_perjalanan', '$order_id', '$qty', '$alamat_jemput', '$alamat_tujuan', '$waktu_jemput', '$status', '$tanggal_pesan', '$tanggal_berangkat', '$harga', '$status_penjemputan', '$id_lokasi_tujuan')";
if (mysqli_query($db, $sqlInsert)) {
 echo json_encode(array('success' => true));
} else {
 echo json_encode(array('success' => false, 'error' => 'Failed to insert pemesanan'));
}

mysqli_close($db);
