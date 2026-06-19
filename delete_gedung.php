<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id_gedung = $_GET['id_gedung'];

// ===== CEK APAKAH GEDUNG MASIH ADA PEMESANAN =====
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pemesanan WHERE id_gedung='$id_gedung'");
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    // Gedung masih ada pemesanan, jangan hapus
    echo "<script>
            alert('Gedung ini masih ada pemesanan, tidak bisa dihapus!');
            window.location.href='tampil_gedung.php';
          </script>";
} else {
    // Gedung aman dihapus
    mysqli_query($koneksi, "DELETE FROM gedung WHERE id_gedung='$id_gedung'");
    header("Location: tampil_gedung.php");
}
?>
