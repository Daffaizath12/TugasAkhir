<?php
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
 die("Koneksi gagal: " . mysqli_connect_error());
}

$id_user = $_POST['id_user'];
$title = $_POST['title'];
$desc = $_POST['desc'];

// Prepared statement
$insert = mysqli_prepare($db, "INSERT INTO notifikasi (id_user, title, `desc`) VALUES (?, ?, ?)");

// Bind parameters
mysqli_stmt_bind_param($insert, 'iss', $id_user, $title, $desc);

// Execute statement
if (mysqli_stmt_execute($insert)) {
 echo json_encode(array('success' => true));
} else {
 echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
}

// Close statement
mysqli_stmt_close($insert);

// Close connection
mysqli_close($db);
