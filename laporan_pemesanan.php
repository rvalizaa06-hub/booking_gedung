<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Filter tanggal
$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : date('Y-m-d');

// Ambil data pemesanan
$data = mysqli_query($koneksi, "
    SELECT
        pm.id_pemesanan,
        pj.nama_lengkap,
        pm.jenis_ruangan,
        pm.lama_sewa,
        pm.total_biaya,
        pm.created_at,
        pm.tanggal_mulai,
        pm.tanggal_selesai
    FROM pemesanan pm
    JOIN peminjam pj 
        ON pm.id_peminjam = pj.id_peminjam
    WHERE DATE(pm.created_at) = '$tgl'
    ORDER BY pm.id_pemesanan DESC
");

// Total pemasukan untuk tanggal terpilih
$qTotal = mysqli_query($koneksi, "
    SELECT SUM(total_biaya) AS total_semua
    FROM pemesanan
    WHERE DATE(created_at) = '$tgl'
");
$totalSemua = mysqli_fetch_assoc($qTotal)['total_semua'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pemesanan Gedung Pertemuan Karawaci</title>

<style>
/* === CSS LAYAR (NORMAL) === */
body {
    font-family: 'Poppins', sans-serif;
     background: linear-gradient(135deg, #fffde8, #ffe6f0);
    padding: 20px;
}


/* CARD */
.card {
    background: #ffffffff;
    max-width: 1100px;
    margin: auto;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    padding: 25px;
}

/* HEADER LAPORAN */
.laporan-header {
    text-align: center;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.laporan-header img {
    width: 80px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
thead {
    background: #ff006aff;
    color: #ffffffff;
}
th, td {
    padding: 12px;
    text-align: center;
}
tbody tr {
    border-bottom: 1px solid #ddd;
}
tfoot {
    background: #e2e8f0;
    font-weight: bold;
}

/* FILTER & CETAK */
.print, .filter {
    text-align: right;
    margin-bottom: 10px;
}

/* FOOTER / TTD */
.ttd {
    display: none; /* disembunyikan di layar */
}

/* STATUS BADGE */
.status-badge {
    padding: 5px 12px;
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
}
.status-booked { background-color: #3b82f6; }     /* biru */
.status-berlangsung { background-color: #10b981; } /* hijau */
.status-selesai { background-color: #6b7280; }   /* abu gelap */

/* === CSS CETAK === */
@media print {
    body {
        font-size: 12px; /* ukuran standar cetak */
        background: #fff;
        color: #000;
    }

    h3, h4, p {
        font-size: 12px; /* header/paragraf cetak normal */
        margin: 0;
    }

    table {
        font-size: 12px;
        border-collapse: collapse;
    }

    th, td {
        padding: 6px; /* jarak sel lebih pas */
        border: 1px solid #000;
        text-align: center;
    }

    thead {
        background: #ccc;
        color: #000;
    }

    tfoot {
        background: #eee;
        font-weight: bold;
    }

    /* tombol/filter disembunyikan saat print */
    .print, .filter {
        display: none;
    }

    /* TTD tampil saat cetak */
    .ttd {
        display: block;
        margin-top: 50px;
        text-align: right;
        font-size: 12px;
    }
    .ttd p { margin: 0; }

    /* STATUS BADGE tetap tampil dan rapi saat print */
    .status-badge {
        display: inline-block;
        font-size: 12px;
        padding: 3px 8px;
    }
    .status-booked { background-color: #3b82f6; color: #fff; }
    .status-berlangsung { background-color: #10b981; color: #fff; }
    .status-selesai { background-color: #6b7280; color: #fff; }
}

@media print {
    /* Badge tetap tampil tapi tanpa warna dan padding */
    .status-badge {
        background: none !important;
        color: #000 !important;
        padding: 0 !important;
        border-radius: 0 !important;
        font-weight: normal !important;
        font-size: 12px !important;
    }

    /* Semua teks cetak ukuran standar */
    body {
        font-size: 12px;
        color: #000;
        background: #fff;
    }

    h3, h4, p {
        font-size: 12px;
        margin: 0;
    }

    table {
        font-size: 12px;
        border-collapse: collapse;
    }

    th, td {
        padding: 6px;
        border: 1px solid #000;
        text-align: center;
    }

    thead {
        background: #ccc;
        color: #000;
    }

    tfoot {
        background: #eee;
        font-weight: bold;
    }

    .print, .filter {
        display: none;
    }

    .ttd {
        display: block;
        margin-top: 50px;
        text-align: right;
        font-size: 12px;
    }
    .ttd p {
        margin: 0;
    }
}

</style>

</head>

<body>

<div class="card">

    <!-- HEADER -->
    <div class="laporan-header">
    <img src="images/gedungpink.png" alt="Logo Gedung">
    <h3>GEDUNG PERTEMUAN – KARAWACI</h3>
    <p>Jl. Boulevard Diponegoro, Lippo Karawaci, Tangerang, Banten 15810</p>
    <p>Sistem Informasi Pemesanan Gedung</p>
</div>

    <h4 style="text-align:center;">Laporan Pemesanan Gedung</h4>

    <!-- FILTER TANGGAL -->
    <div class="filter">
        <form method="GET">
            Pilih Tanggal: 
            <input type="date" name="tgl" value="<?= $tgl ?>">
            <button type="submit">Tampilkan</button>
        </form>
    </div>

    <!-- CETAK -->
    <div class="print">
        <a href="#" onclick="window.print();return false;">
            Cetak Laporan
        </a>
    </div>

    <!-- TABEL LAPORAN -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pemesanan</th>
                <th>Jenis Ruangan</th>
                <th>Lama Sewa</th>
                <th>Total Biaya</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($data)) {
            // Tentukan status berdasarkan tanggal
            $today = date('Y-m-d');
            if ($today < $row['tanggal_mulai']) {
                $status = "Booked";
            } elseif ($today >= $row['tanggal_mulai'] && $today <= $row['tanggal_selesai']) {
                $status = "Berlangsung";
            } else {
                $status = "Selesai";
            }
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?= date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                <td><?= htmlspecialchars($row['jenis_ruangan']); ?></td>
                <td><?= $row['lama_sewa']; ?> Jam</td>
                <td>Rp <?= number_format($row['total_biaya'], 0, ',', '.'); ?></td>
                <td>
    <?php 
        if ($status == "Booked") {
            echo '<span class="status-badge status-booked">Booked</span>';
        } elseif ($status == "Berlangsung") {
            echo '<span class="status-badge status-berlangsung">Berlangsung</span>';
        } else {
            echo '<span class="status-badge status-selesai">Selesai</span>';
        }
    ?>
</td>

            </tr>
        <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">
                    TOTAL PEMASUKAN
                </td>
                <td>
                    Rp <?= number_format($totalSemua, 0, ',', '.'); ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER / TTD hanya untuk cetak -->
    <div class="ttd">
        <p>Tangerang, Karawaci, <?= date('d F Y'); ?></p>
        <p>Pemilik</p>
        <br><br><br>
        <p><strong>( Revaliza Maheppy )</strong></p>
    </div>

</div>

</body>
</html>
