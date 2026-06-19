<?php
session_start();
// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
include 'koneksi.php';


// Cek parameter id
if (!isset($_GET['id'])) {
    // Kalau id tidak ada, balik ke halaman tampil pemesanan
    header("Location: tampil_pemesanan.php");
    exit;
}

$id_pemesanan = intval($_GET['id']); // pastikan id numerik

// Hapus data pemesanan
$query = "DELETE FROM pemesanan WHERE id_pemesanan = $id_pemesanan";

if (mysqli_query($koneksi, $query)) {
    // Jika berhasil hapus, tetap di halaman tampil_pemesanan
    header("Location: tampil_pemesanan.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
}
?>
