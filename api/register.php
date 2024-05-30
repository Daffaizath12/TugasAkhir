<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');
$nama_lengkap = $_POST['nama_lengkap'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$email = $_POST['email'];
$notelp = $_POST['notelp'];
$alamat = $_POST['alamat'];
$nik = $_POST['nik'];

$sqlCheckEmail = "SELECT id_user FROM user WHERE email = '$email'";
$resultCheckEmail = $db->query($sqlCheckEmail);

if ($resultCheckEmail && $resultCheckEmail->num_rows > 0) {
 echo json_encode(array('success' => false, 'error' => 'Email sudah terdaftar'));
} else {
 $sqlRole = "SELECT id_role FROM role WHERE role = 'pelanggan'";
 $resultRole = $db->query($sqlRole);

 if ($resultRole && $resultRole->num_rows > 0) {
  $row = $resultRole->fetch_assoc();
  $role_id = $row['id_role'];

  $sqlInsert = "INSERT INTO user SET nama_lengkap = '$nama_lengkap', id_role = '$role_id', password = '$password', email = '$email', alamat = '$alamat', notelp = '$notelp', nik = '$nik'";
  $resultInsert = $db->query($sqlInsert);

  if ($resultInsert) {
   echo json_encode(array('success' => true));
  } else {
   echo json_encode(array('success' => false, 'error' => 'Failed to insert user'));
  }
 } else {
  echo json_encode(array('success' => false, 'error' => 'Failed to fetch role_id'));
 }
}
