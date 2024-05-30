<?php

// Koneksi ke database
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

// Terima input id_sopir dan id_perjalanan
$id_sopir = $_POST['id_sopir'];
$id_perjalanan = $_POST['id_perjalanan'];
$status = $_POST['status']; // Status baru yang akan diupdate

// Buat query SQL untuk mengupdate status di tabel daftar_perjalanan
$sql = "UPDATE daftar_perjalanan 
        SET status = '$status' 
        WHERE id_sopir = '$id_sopir' AND id_perjalanan = '$id_perjalanan'";

// Eksekusi query
if (mysqli_query($db, $sql)) {
 // Jika update berhasil, kirimkan response sukses
 echo json_encode(array('message' => 'Status berhasil diupdate'));
} else {
 // Jika update gagal, kirimkan response error
 echo json_encode(array('message' => 'Gagal mengupdate status'));
}

// Tutup koneksi database
mysqli_close($db);
