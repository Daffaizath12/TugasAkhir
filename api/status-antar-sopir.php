<?php

// Koneksi ke database
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

// Terima input id_sopir dan id_perjalanan
$id_pemesanan = $_POST['id_pemesanan'];
$status = 'non_active';

// Buat query SQL untuk mengupdate status di tabel daftar_perjalanan
$sql = "UPDATE pemesanan 
        SET status_antar = '$status' 
        WHERE id_pemesanan = '$id_pemesanan'";

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
