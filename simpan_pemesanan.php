<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Ambil data dari form
$id_peminjam     = $_POST['id_peminjam'];
$jenis_ruangan   = $_POST['jenis_ruangan'];
$tanggal_mulai   = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$jam_mulai       = $_POST['jam_mulai'];
$jam_selesai     = $_POST['jam_selesai'];
$jenis_acara     = $_POST['jenis_acara'];

/* ================= HITUNG LAMA SEWA ================= */

// hitung jumlah hari
$startDate = new DateTime($tanggal_mulai);
$endDate   = new DateTime($tanggal_selesai);

$jumlah_hari = $startDate->diff($endDate)->days;
if ($jumlah_hari < 1) {
    $jumlah_hari = 1; // minimal 1 hari
}

// hitung jam per hari
$startTime = strtotime($jam_mulai);
$endTime   = strtotime($jam_selesai);

if ($endTime <= $startTime) {
    die("Jam selesai harus lebih besar dari jam mulai");
}

$jam_per_hari = ceil(($endTime - $startTime) / 3600);

// total jam
$lama_sewa = $jam_per_hari * $jumlah_hari;

/* =================================================== */

// Ambil data gedung berdasarkan jenis ruangan
$qGedung = mysqli_query($koneksi, "
    SELECT id_gedung, tarif 
    FROM gedung 
    WHERE jenis_ruangan = '$jenis_ruangan'
");

$dataGedung = mysqli_fetch_assoc($qGedung);

if (!$dataGedung) {
    die("Jenis ruangan tidak ditemukan!");
}

$id_gedung = $dataGedung['id_gedung'];
$tarif     = $dataGedung['tarif'];

// Hitung total biaya (tarif x lama sewa)
$total_biaya = $tarif * $lama_sewa;

// Simpan pemesanan ke database
$query = "INSERT INTO pemesanan 
(id_peminjam, id_gedung, jenis_ruangan, tanggal_mulai, tanggal_selesai, jam_mulai, jam_selesai, lama_sewa, jenis_acara, total_biaya)
VALUES 
('$id_peminjam', '$id_gedung', '$jenis_ruangan', '$tanggal_mulai', '$tanggal_selesai', '$jam_mulai', '$jam_selesai', '$lama_sewa', '$jenis_acara', '$total_biaya')";


if (mysqli_query($koneksi, $query)) {
    header("Location: tampil_pemesanan.php");
    exit;
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
