<?php
include 'koneksi.php';

$jenis = $_POST['jenis_ruangan'];
$kap   = $_POST['kapasitas'];
$tarif = $_POST['tarif'];

mysqli_query($koneksi, "
    UPDATE gedung SET
        jenis_ruangan='$jenis',
        kapasitas='$kap',
        tarif='$tarif'
    WHERE id_gedung=1
");

header("Location: gedung.php?update=success");
