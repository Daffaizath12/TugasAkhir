<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $namaLengkap = $conn->real_escape_string($_POST['nama_lengkap']);
  $email = $conn->real_escape_string($_POST['email']);
  $notelp = $conn->real_escape_string($_POST['notelp']);
  $nik = $conn->real_escape_string($_POST['nik']);
  $alamat = $conn->real_escape_string($_POST['alamat']);
  $password = $conn->real_escape_string($_POST['password']);

  // Hash password sebelum disimpan ke database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO user (nama_lengkap, email, notelp, nik, alamat, password, id_role) VALUES ('$namaLengkap', '$email', '$notelp', '$nik', '$alamat', '$hashedPassword', 3)";

  if ($conn->query($query) === TRUE) {
    header("Location: pelanggan.php?success=1");
  } else {
    echo "Error: " . $query . "<br>" . $conn->error;
  }
}
?>
