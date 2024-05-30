<?php
include "koneksi.php";

// Proses aktivasi status sopir
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_sopir"])) {
 $id_sopir = $_POST["id_sopir"];

 // Query UPDATE
 $sql = "UPDATE sopir SET status = 'active' WHERE id_sopir = '$id_sopir' AND status = 'non_active'";

 // Eksekusi query
 if ($conn->query($sql) === TRUE) {
  echo "Status sopir berhasil diaktifkan.";
 } else {
  echo "Error: " . $sql . "<br>" . $conn->error;
 }
} else {
 echo "Invalid request.";
}
