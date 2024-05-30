<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');
$nama_lengkap = $_POST['nama_lengkap'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$username = $_POST['username'];
$no_SIM = $_POST['no_SIM'];
$notelp = $_POST['notelp'];
$alamat = $_POST['alamat'];
$status = "non_active";

$sqlCheckUsername = "SELECT id_sopir FROM sopir WHERE username = '$username'";
$resultCheckUsername = $db->query($sqlCheckUsername);

if ($resultCheckUsername && $resultCheckUsername->num_rows > 0) {
 echo json_encode(array('success' => false, 'error' => 'Username sudah terdaftar'));
} else {
 $sqlInsert = "INSERT INTO sopir (nama_lengkap, username, password, no_SIM, alamat, notelp, status) VALUES ('$nama_lengkap', '$username', '$password', '$no_SIM', '$alamat', '$notelp', '$status')";
 $resultInsert = $db->query($sqlInsert);

 if ($resultInsert) {
  echo json_encode(array('success' => true));
 } else {
  echo json_encode(array('success' => false, 'error' => 'Gagal menyimpan data'));
 }
}
