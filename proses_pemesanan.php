<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
/*
=====================================
FILE PROSES PEMESANAN (VERSI DASAR)
=====================================
- Dipakai saat pemesanan disetujui
- Mengubah status gedung
- File ini BELUM dipanggil dari form
*/

// simulasi approve pemesanan
if (isset($_GET['id_gedung'])) {

    $id_gedung = $_GET['id_gedung'];

    // ubah status gedung jadi tidak tersedia
    mysqli_query($koneksi, "
    UPDATE gedung g
    JOIN pemesanan p ON g.id_gedung = p.id_gedung
    SET g.status = 'Tersedia'
    WHERE 
        p.status = 'Disetujui'
        AND (
            p.tanggal < CURDATE()
            OR (p.tanggal = CURDATE() AND p.jam_selesai < CURTIME())
        )
");


    echo "Status gedung berhasil diubah menjadi Tidak Tersedia";
}
?>
