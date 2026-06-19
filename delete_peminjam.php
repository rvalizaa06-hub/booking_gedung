<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$id_peminjam = $_GET['id_peminjam'] ?? '';

if ($id_peminjam == '') {
    header("Location: tampil_peminjam.php");
    exit;
}

// CEK APAKAH PEMINJAM MASIH DIPAKAI
$cek = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM pemesanan WHERE id_peminjam='$id_peminjam'"
);

$data = mysqli_fetch_assoc($cek);

if ($data['total'] > 0) {
     echo "<script>
            alert('Gedung ini masih ada pemesanan, tidak bisa dihapus!');
            window.location.href='tampil_gedung.php';
          </script>";
}

// AMAN DIHAPUS
mysqli_query(
    $koneksi,
    "DELETE FROM peminjam WHERE id_peminjam='$id_peminjam'"
);

// BERHASIL → LANGSUNG KEMBALI
header("Location: tampil_peminjam.php");
exit;
