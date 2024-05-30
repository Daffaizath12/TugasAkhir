<?php

// Koneksi ke database
$db = mysqli_connect('localhost', 'root', '', 'travelapps');

if (!$db) {
        die("Koneksi gagal: " . mysqli_connect_error());
}

// Terima input id_sopir dan tanggal
$id_sopir = $_GET['id_sopir'];

// Buat query SQL untuk melakukan penggabungan tabel dan menghitung jumlah total penumpang
$sql = "SELECT dp.*, COUNT(p.id_perjalanan) AS total_penumpang
        FROM daftar_perjalanan dp
        LEFT JOIN pemesanan p ON dp.id_perjalanan = p.id_perjalanan AND p.status = 'Selesai'
        WHERE dp.id_sopir = '$id_sopir'
        GROUP BY dp.id_perjalanan
        ORDER BY dp.tanggal DESC";


// Eksekusi query
$result = mysqli_query($db, $sql);

// Inisialisasi response
$response = array();

if (mysqli_num_rows($result) > 0) {
        // Jika data ditemukan, tambahkan ke response
        while ($row = mysqli_fetch_assoc($result)) {
                // Masukkan data ke dalam array response
                $response[] = array(
                        "id_perjalanan" => $row["id_perjalanan"],
                        "kota_asal" => $row["kota_asal"],
                        "kota_tujuan" => $row["kota_tujuan"],
                        "tanggal" => $row["tanggal"],
                        "waktu_keberangkatan" => $row["waktu_keberangkatan"],
                        "harga" => $row["harga"],
                        "status" => $row["status"],
                        "jumlah_penumpang" => $row["jumlah_penumpang"],
                        "total_penumpang" => $row["total_penumpang"]
                );
        }
        // Mengirimkan response dalam format JSON
        echo json_encode($response);
} else {
        // Jika tidak ada data, kirim pesan JSON
        echo json_encode(array('message' => 'Data tidak ditemukan'));
}

// Tutup koneksi database
mysqli_close($db);
