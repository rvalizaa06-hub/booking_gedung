<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_pemesan = $_POST['nama_pemesan'];
    $id_gedung = $_POST['id_gedung'];
    $tanggal = $_POST['tanggal_booking'];
    $waktu = $_POST['waktu_mulai'];
    $keperluan = $_POST['keperluan'];

    mysqli_query($koneksi, "
        INSERT INTO booking 
        (nama_pemesan, id_gedung, tanggal_booking, waktu_mulai, keperluan)
        VALUES
        ('$nama_pemesan','$id_gedung','$tanggal','$waktu','$keperluan')
    ");

    echo "<script>
        alert('Booking berhasil disimpan');
        window.location='dashboard.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Gedung</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-4">
<div class="card">
<div class="card-header bg-primary text-white">
    Form Booking Gedung
</div>

<div class="card-body">
<form method="post">

<div class="form-group">
    <label>Nama Pemesan</label>
    <input type="text" name="nama_pemesan" class="form-control" required>
</div>

<div class="form-group">
    <label>Jenis Ruangan</label>
    <select name="id_gedung" class="form-control" required>
        <option value="">-- Pilih Ruangan --</option>
        <?php
        $g = mysqli_query($koneksi, "SELECT * FROM gedung");
        while ($row = mysqli_fetch_assoc($g)) {
            echo "<option value='$row[id_gedung]'>$row[nama_gedung]</option>";
        }
        ?>
    </select>
</div>

<div class="form-group">
    <label>Tanggal Booking</label>
    <input type="date" name="tanggal_booking" class="form-control" required>
</div>

<div class="form-group">
    <label>Waktu Mulai</label>
    <input type="time" name="waktu_mulai" class="form-control" required>
</div>

<div class="form-group">
    <label>Keperluan</label>
    <textarea name="keperluan" class="form-control" required></textarea>
</div>

<button type="submit" name="simpan" class="btn btn-success">
    Simpan
</button>
<a href="dashboard.php" class="btn btn-secondary">
    Kembali
</a>

</form>
</div>
</div>
</div>
</body>
</html>
