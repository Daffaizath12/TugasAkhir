 <?php

 $db = mysqli_connect('localhost', 'root', '', 'travelapps');

 if (!$db) {
  die("Koneksi gagal: " . mysqli_connect_error());
 }

 $token = $_POST['token'];
 $latitude = $_POST['latitude'];
 $longitude = $_POST['longitude'];

 $sql = "UPDATE user SET latitude = '$latitude', longitude = '$longitude' WHERE token = '$token'";
 if (mysqli_query($db, $sql)) {
  echo json_encode(array('success' => true));
 } else {
  echo json_encode(array('success' => false, 'error' => 'Failed to insert latLng'));
 }
 mysqli_close($db);
 ?>