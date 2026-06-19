<?php
session_start();
// Perbaiki proteksi session (konsisten dengan dashboard.php)
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// ambil data dari form
$id_peminjam    = $_POST['id_peminjam'] ?? '';
$nama_lengkap   = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
$email          = mysqli_real_escape_string($koneksi, $_POST['email']);
$no_telepon     = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
$alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$tanggal_pinjam = $_POST['tanggal_pinjam'];

if ($id_peminjam != '') {
    // =========================
    // UPDATE DATA PEMINJAM
    // =========================
    $query = "UPDATE peminjam SET 
                nama_lengkap='$nama_lengkap',
                email='$email',
                no_telepon='$no_telepon',
                alamat='$alamat',
                tanggal_pinjam='$tanggal_pinjam'
              WHERE id_peminjam='$id_peminjam'";
} else {
    // =========================
    // INSERT DATA PEMINJAM
    // =========================

    // Cek email duplikat hanya untuk INSERT baru
    $cek = mysqli_query($koneksi, "SELECT id_peminjam FROM peminjam WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Email sudah terdaftar, silakan gunakan email lain');
            window.history.back();
        </script>";
        exit;
    }

    $query = "INSERT INTO peminjam 
              (nama_lengkap, email, no_telepon, alamat, tanggal_pinjam)
              VALUES 
              ('$nama_lengkap', '$email', '$no_telepon', '$alamat', '$tanggal_pinjam')";
}

if(mysqli_query($koneksi, $query)) {
    // redirect ke halaman tampil peminjam
    header("Location: tampil_peminjam.php");
    exit;
} else {
    echo "Error: " . mysqli_error($koneksi);
}