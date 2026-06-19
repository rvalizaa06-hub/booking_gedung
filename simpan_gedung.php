<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id_gedung    = $_POST['id_gedung'] ?? '';
$nama_gedung  = $_POST['nama_gedung'];
$jenis_ruangan = $_POST['jenis_ruangan'];
$kapasitas    = $_POST['kapasitas'];
$tarif_input = preg_replace('/\D/', '', $_POST['tarif']);

$tarif = (int) $tarif_input;


$fasilitas = $_POST['fasilitas'];

if ($id_gedung != '') {
    // =========================
    // UPDATE DATA (EDIT)
    // =========================
    $query = "UPDATE gedung SET 
                nama_gedung='$nama_gedung',
                jenis_ruangan='$jenis_ruangan',
                kapasitas='$kapasitas',
                tarif='$tarif',
                fasilitas='$fasilitas'
              WHERE id_gedung='$id_gedung'";
} else {
    // =========================
    // INSERT DATA (TAMBAH)
    // =========================
    $query = "INSERT INTO gedung 
              (nama_gedung, jenis_ruangan, kapasitas, tarif, fasilitas)
              VALUES 
              ('$nama_gedung', '$jenis_ruangan', '$kapasitas', '$tarif', '$fasilitas')";
}

mysqli_query($koneksi, $query);

header("Location: tampil_gedung.php");
exit;
