<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
        die("Koneksi gagal: " . mysqli_connect_error());
}

$id_sopir = $_POST['id_sopir'];
$id_perjalanan = $_POST['id_perjalanan'];

$sql = "SELECT p.*, u.*, dp.*, 
               
               lt.lat AS lat_tujuan, lt.lng AS lng_tujuan,
               m.nama_mobil, m.plat
        FROM pemesanan p
        JOIN user u ON p.id_user = u.id_user
        JOIN daftar_perjalanan dp ON p.id_perjalanan = dp.id_perjalanan
        JOIN lokasi lt ON p.latlong_tujuan = lt.id 
        JOIN mobil m ON dp.mobil_id = m.id_mobil
        WHERE p.status = 'Selesai' 
          AND dp.id_sopir = '$id_sopir' 
          AND dp.id_perjalanan = '$id_perjalanan'  
          AND p.status_antar = 'active'";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
                $response[] = $row;
        }
        echo json_encode($response);
} else {
        echo json_encode(array('message' => 'Data tidak ditemukan'));
}

mysqli_close($db);
