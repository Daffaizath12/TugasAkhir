<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

// Mendapatkan data dari body permintaan (request)

// Pastikan data diterima dengan benar
$id_sopir = $_POST['id_sopir'];
$nama_lengkap = $_POST['nama_lengkap'];
$notelp = $_POST['notelp'];
$username = $_POST['username'];
$alamat = $_POST['alamat'];
$no_SIM = $_POST['no_SIM'];

// Periksa keberadaan id_sopir dalam tabel user
$check_query = "SELECT * FROM sopir WHERE id_sopir = '" . $id_sopir . "'";
$check_result = mysqli_query($db, $check_query);

if ($check_result->num_rows == 1) {
 // id_sopir valid, lakukan pembaruan data
 $update_query = "UPDATE sopir SET 
                        nama_lengkap = '" . $nama_lengkap . "',
                        notelp = '" . $notelp . "',
                        username = '" . $username . "',
                        alamat = '" . $alamat . "',
                        no_SIM = '" . $no_SIM . "'
                        WHERE id_sopir = '" . $id_sopir . "'";
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
