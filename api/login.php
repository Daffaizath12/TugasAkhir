<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE email = '" . $email . "'";
$result = mysqli_query($db, $sql);

if ($result->num_rows == 1) {
 $row = $result->fetch_assoc();
 if (password_verify($password, $row['password'])) {
  $token = generateRandomToken();

  $updateTokenQuery = "UPDATE user SET token = '$token' WHERE email = '$email'";
  mysqli_query($db, $updateTokenQuery);

  echo json_encode([
   'success' => true,
   'message' => "Berhasil Login",
   'user' => $row,
   'token' => $token
  ]);
 } else {
  echo json_encode([
   'success' => false,
   'message' => "Password Salah"
  ]);
 }
} else {
 echo json_encode([
  'success' => false,
  'message' => "Email dan Password Salah"
 ]);
}

function generateRandomToken($length = 50)
{
 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $charactersLength = strlen($characters);
 $randomToken = '';
 for ($i = 0; $i < $length; $i++) {
  $randomToken .= $characters[rand(0, $charactersLength - 1)];
 }
 return $randomToken;
}
