<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

$token = $_GET['token'];

$sql = "SELECT * FROM user WHERE token = '" . $token . "'";
$result = mysqli_query($db, $sql);

if ($result->num_rows == 1) {
 $row = $result->fetch_assoc();
 unset($row['password']);
 unset($row['token']);

 echo json_encode([
  'message' => "success",
  'user' => $row
 ]);
} else {
 echo json_encode([
  'success' => false,
  'message' => "Token tidak valid"
 ]);
}
