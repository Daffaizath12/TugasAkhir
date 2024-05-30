<?php

// Koneksi ke database
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
        die("Koneksi gagal: " . mysqli_connect_error());
}

// Terima input id_sopir
$id_sopir = $_GET['id_sopir'];

// Buat query SQL untuk memilih data dari hari ini hingga satu hari berikutnya menggunakan NOW() di SQL
$sql = "SELECT * FROM daftar_perjalanan 
        WHERE id_sopir = '$id_sopir' 
        AND tanggal BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)";

// Eksekusi query
$result = mysqli_query($db, $sql);

// Inisialisasi response
$response = array();

if (mysqli_num_rows($result) > 0) {
        // Jika data ditemukan, tambahkan ke response
        while ($row = mysqli_fetch_assoc($result)) {
                $response[] = $row;
        }
        echo json_encode($response);
} else {
        // Jika tidak ada data, kirim pesan JSON
        echo json_encode(array('message' => 'Data tidak ditemukan'));
}

// Tutup koneksi database
mysqli_close($db);
