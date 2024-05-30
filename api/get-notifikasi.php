<?php
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$id_user = $_GET['id_user'] ?? '';

// Validasi input
if (empty($id_user)) {
 echo json_encode(array('success' => false, 'error' => 'ID User tidak valid'));
 exit;
}

// Prepared statement untuk mengambil notifikasi berdasarkan id_user
$sql = "SELECT * FROM notifikasi WHERE id_user = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id_user);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$notifications = array();

// Loop melalui hasil dan menyimpan notifikasi dalam array
while ($row = mysqli_fetch_assoc($result)) {
 $notifications[] = $row;
}

// Mengembalikan notifikasi dalam format JSON
echo json_encode($notifications);

// Tutup statement
mysqli_stmt_close($stmt);

// Tutup koneksi
mysqli_close($db);
