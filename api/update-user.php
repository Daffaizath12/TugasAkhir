<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

// Mendapatkan data dari body permintaan (request)

// Pastikan data diterima dengan benar
$token = $_POST['token'];
$nama_lengkap = $_POST['nama_lengkap'];
$notelp = $_POST['notelp'];
$email = $_POST['email'];
$alamat = $_POST['alamat'];
$nik = $_POST['nik'];

// Periksa keberadaan token dalam tabel user
$check_query = "SELECT * FROM user WHERE token = '" . $token . "'";
$check_result = mysqli_query($db, $check_query);

if ($check_result->num_rows == 1) {
 // Token valid, lakukan pembaruan data
 $update_query = "UPDATE user SET 
                        nama_lengkap = '" . $nama_lengkap . "',
                        notelp = '" . $notelp . "',
                        email = '" . $email . "',
                        nik = '" . $nik . "',
                        alamat = '" . $alamat . "'
                        WHERE token = '" . $token . "'";
 $update_result = mysqli_query($db, $update_query);

 if ($update_result) {
  echo json_encode([
   'success' => true,
   'message' => "Data pengguna berhasil diperbarui"
  ]);
 } else {
  echo json_encode([
   'success' => false,
   'message' => "Gagal memperbarui data pengguna"
  ]);
 }
} else {
 echo json_encode([
  'success' => false,
  'message' => "Token tidak valid"
 ]);
}
