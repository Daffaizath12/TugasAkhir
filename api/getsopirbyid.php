<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

$id = $_GET['id'];

$sql = "SELECT * FROM sopir WHERE id_sopir = '" . $id . "'";
$result = mysqli_query($db, $sql);

if ($result->num_rows == 1) {
 $row = $result->fetch_assoc();
 unset($row['password']);
 unset($row['token']);

 echo json_encode([
  'message' => "success",
  'sopir' => $row
 ]);
} else {
 echo json_encode([
  'success' => false,
  'message' => "Token tidak valid"
 ]);
}
