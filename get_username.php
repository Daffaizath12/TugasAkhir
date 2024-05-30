<?php
// Memulai atau melanjutkan sesi PHP
session_start();

// Periksa apakah pengguna sudah login
if(isset($_SESSION['username'])) {
    // Ambil nama pengguna dari sesi
    $username = $_SESSION['username'];

    // Kembalikan nama pengguna sebagai respons JSON
    header('Content-Type: application/json');
    echo json_encode(['username' => $username]);
} else {
    // Jika pengguna belum login, berikan respons kosong atau sesuai kebutuhan
    header('Content-Type: application/json');
    echo json_encode(['username' => null]);
}
?>
