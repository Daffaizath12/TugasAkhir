<?php

$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
        die("Koneksi gagal: " . mysqli_connect_error());
}

$id_user = $_GET['id_user'];

$sql = "SELECT p.id_pemesanan, p.id_user, p.id_perjalanan, p.order_id, p.alamat_jemput, p.alamat_tujuan, p.waktu_jemput,p.qty, p.status AS pemesanan_status, p.tanggal_pesan, p.tanggal_berangkat, p.harga, dp.kota_asal, dp.kota_tujuan, dp.tanggal, dp.waktu_keberangkatan
        , p.status_penjemputan, P.status_antar
        FROM pemesanan p 
        JOIN daftar_perjalanan dp ON p.id_perjalanan = dp.id_perjalanan 
        WHERE p.id_user = '$id_user'
        ORDER BY p.id_pemesanan DESC";


$result = mysqli_query($db, $sql);

if (!$result) {
        die("Error: " . $sql . "<br>" . mysqli_error($db));
}

$pemesanan_list = array();

while ($row = mysqli_fetch_assoc($result)) {
        $pemesanan_list[] = $row;
}

echo json_encode(array('message' => 'success', 'data' => $pemesanan_list));

mysqli_close($db);
