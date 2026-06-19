<?php
session_start();
include 'koneksi.php';

// pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: gedung.php");
    exit;
}

$id = $_POST['id_gedung'] ?? null;
$jenis = $_POST['jenis_ruangan'] ?? '';
$kapasitas = $_POST['kapasitas'] ?? '';
$tarif = $_POST['tarif'] ?? '';

if (!$id) {
    header("Location: gedung.php?status=id_kosong");
    exit;
}

// QUERY UPDATE (BUKAN INSERT)
$sql = "
    UPDATE gedung SET
        jenis_ruangan = '$jenis',
        kapasitas = '$kapasitas',
        tarif = '$tarif'
    WHERE id_gedung = '$id'
";

$query = mysqli_query($koneksi, $sql);

// redirect
if ($query) {
    header("Location: gedung.php?status=update_sukses");
} else {
    header("Location: gedung.php?status=update_gagal");
}
exit;
