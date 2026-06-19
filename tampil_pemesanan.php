<?php
session_start();

// proteksi dashboard
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// =======================
// KONFIGURASI PEMINJAM
// =======================
$NAMA_PEMINJAM_DEFAULT = "Peminjam Baru"; // contoh default jika diperlukan

// hitung total data peminjam
$qPeminjam = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM peminjam");
$totalPeminjam = mysqli_fetch_assoc($qPeminjam)['total'];

// ambil semua data peminjam (untuk ditampilkan di tabel/index)
$qDataPeminjam = mysqli_query($koneksi, "SELECT * FROM peminjam ORDER BY id_peminjam ASC");
?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ela Admin - HTML5 Admin Template</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png" />
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png" />

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css"
    />
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link
      href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css"
      rel="stylesheet"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css"
      rel="stylesheet"
    />

    <style>

body {
  background-color: #fffde8ff; /* soft pink, ganti sesuai selera */
}
      .table-wrapper {
  max-height: 450px;
  overflow-y: auto;
}

.table thead th {
  position: sticky;
  top: 0;
  background: #a39c87ff;
  z-index: 1;
}

      #weatherWidget .currentDesc {
        color: #ffffff !important;
      }
      .traffic-chart {
        min-height: 335px;
      }
      #flotPie1 {
        height: 150px;
      }
      #flotPie1 td {
        padding: 3px;
      }
      #flotPie1 table {
        top: 20px !important;
        right: -10px !important;
      }
      .chart-container {
        display: table;
        min-width: 270px;
        text-align: left;
        padding-top: 10px;
        padding-bottom: 10px;
      }
      #flotLine5 {
        height: 105px;
      }

      #flotBarChart {
        height: 150px;
      }
      #cellPaiChart {
        height: 160px;
      }

      .navbar-brand img {
  max-height: 80px;
  width: auto;
}


.card-body {
  padding: 20px 25px;
}

.content {
  padding-left: 15px;
  padding-right: 15px;
}

.card {
  margin: 0;
}

/* CARD HEADER JUDUL */
.card-header-custom {
  background: linear-gradient(135deg, #ff006aff);
  border-radius: 10px;
  padding: 22px 28px;   /* JARAK TEKS & BG */
  margin-bottom: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  color: #fff;
}

/* JUDUL */
.card-header-custom h4 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 6px;
  color: #ffffff;
}

/* SUB JUDUL */
.card-header-custom p {
  font-size: 14px;
  opacity: 0.9;
  margin-bottom: 0;
  color: #ffffffff;
}

/* BUTTON DI HEADER */
.card-header-custom .btn {
  padding: 7px 14px;
  font-size: 13px;
  border-radius: 6px;
}

/* CARD TABEL */
.card-table-custom {
  border-radius: 10px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  background: #fff;
}


/* kecilkan ukuran card */
.card-body {
  padding: 15px 18px;
}

/* hilangkan grid putih bawaan */
.animated.fadeIn > .row {
  margin: 0;
}

/* beri jarak konten ke footer */
.content {
  padding-bottom: 80px; /* atur sesuai kebutuhan */
}

/* rapikan footer */
.footer {
  margin-top: 30px;
  padding-top: 15px;
  padding-bottom: 15px;
}

/* teks footer biar tidak nempel */
.footer p,
.footer span {
  line-height: 1.6;
}


    </style>
  </head>
<body>

 <!-- Left Panel -->
 <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active">
              <a href="dashboard.php"
                ><i class="menu-icon fa fa-desktop"></i>Dashboard
              </a>
            </li>
            <!-- /.menu-title -->
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-database"></i>Data Master</a
              >
              <ul class="sub-menu children dropdown-menu">
                      <li>
                        <i class="fa fa-building"></i>
                        <a href="gedung.php">Gedung</a>
                      </li>
                      <li>
                        <i class="fa fa-user"></i>
                        <a href="peminjam.php">Peminjam</a>
                      </li>
                    </ul>
            </li>
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-exchange"></i>Transaksi</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="fa fa-calendar-check-o"></i
                  ><a href="pemesanan.php">Pemesanan</a>
                </li>
               
                </li>
              </ul>
            </li>
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-file-text-o"></i>Laporan</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="menu-icon fa fa-file-text"></i
                  ><a href="laporan_pemesanan.php">Laporan Pemesanan</a>
                </li>
               
              </ul>
            </li>
                      
            <li class="menu-title">Extras</li>
            <!-- /.menu-title -->
            <li class="menu-item-has-children dropdown">
              <a
                href="#"
                class="dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="menu-icon fa fa-glass"></i>Pages</a
              >
              <ul class="sub-menu children dropdown-menu">
                <li>
                  <i class="menu-icon fa fa-sign-in"></i
                  ><a href="page-login.html">Login</a>
                </li>
                <li>
                  <i class="menu-icon fa fa-sign-in"></i
                  ><a href="page-register.html">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
      <!-- Header-->
      <header id="header" class="header">
        <div class="top-left">
          <div class="navbar-header">
            <a class="navbar-brand"
              ><i class="fa fa-building"></i>
            
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
          </div>
        </div>
        <div class="top-right">
          <div class="header-menu">
            <div class="header-left">
              <button class="search-trigger">
                <i class="fa fa-search"></i>
              </button>
              <div class="form-inline">
                <form class="search-form">
                  <input
                    class="form-control mr-sm-2"
                    type="text"
                    placeholder="Search ..."
                    aria-label="Search"
                  />
                  <button class="search-close" type="submit">
                    <i class="fa fa-close"></i>
                  </button>
                </form>
              </div>

          
            <div class="user-area dropdown float-right">
              <a
                href="#"
                class="dropdown-toggle active"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  class="user-avatar rounded-circle"
                  src="images/gedungpink.png"
                  alt="User Avatar"
                />
              </a>

              <div class="user-menu dropdown-menu">
                <a class="nav-link" href="#"
                  >

                <a class="nav-link" href="#"
                  ><i class="fa fa -cog"></i>Settings</a
                >

                <a class="nav-link" href="#"
                  ><i class="fa fa-power -off"></i>Logout</a
                >
              </div>
            </div>
          </div>
        </div>
      </header>

    <!-- CONTENT -->
    <div class="content">
        <div class="animated fadeIn">
      


				
<?php
$sql = "
  SELECT 
    pm.id_pemesanan,
    pj.nama_lengkap,
    pj.no_telepon,
    pm.jenis_ruangan,
    pm.tanggal_mulai,
    pm.tanggal_selesai,
    pm.jam_mulai,
    pm.jam_selesai,
    pm.lama_sewa,     
    pm.jenis_acara,
    pm.total_biaya
  FROM pemesanan pm
  JOIN peminjam pj ON pm.id_peminjam = pj.id_peminjam
  ORDER BY pm.id_pemesanan DESC
";

$result = $koneksi->query($sql);

?>

  <div class="content">
  <div class="animated fadeIn">

    <!-- CARD JUDUL (TERPISAH) -->
   <div class="card-header-custom">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h4 class="mb-1">
        <i class="fa fa-calendar-check-o mr-2"></i> Daftar Pemesanan
<p class="mb-0">Berikut ini adalah daftar pemesanan gedung</p>
    </div>
    <a href="pemesanan.php" class="btn btn-light btn-sm">
      <i class="fa fa-plus"></i> Tambah Peminjam
    </a>
  </div>
</div>

   <!-- CARD TABEL -->
<div class="card card-table-custom">
  <div class="table-responsive table-wrapper">
    <table class="table table-bordered table-striped table-hover text-center">

  <thead class="bg-custom-pink text-white">
  <tr>
    <th>No</th>
    <th>Nama Peminjam</th>
    <th>No. Telepon</th>
    <th>Jenis Ruangan</th>
    <th>Tanggal Pinjam</th>
    <th>Jam</th>
    <th>Lama Sewa</th>
    <th>Jenis Acara</th>
    <th>Total Biaya</th>
    <th>Aksi</th>
  </tr>
</thead>


      <tbody>
<?php
$no = 1;
while ($row = $result->fetch_assoc()) {
?>
<tr>
  <td><?= $no++; ?></td>
  <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
  <td><?= htmlspecialchars($row['no_telepon']); ?></td>
  <td><?= htmlspecialchars($row['jenis_ruangan']); ?></td>
  <td><?= htmlspecialchars($row['tanggal_mulai']); ?> s/d <?= htmlspecialchars($row['tanggal_selesai']); ?></td>
  <td>
  <?= date('H:i', strtotime($row['jam_mulai'])) ?>
  -
  <?= date('H:i', strtotime($row['jam_selesai'])) ?>
</td>
  <td><?= htmlspecialchars($row['lama_sewa']); ?> Jam</td>
  <td><?= htmlspecialchars($row['jenis_acara']); ?></td>
  <?php
// ambil tarif gedung dari database berdasarkan jenis_ruangan
$qTarif = mysqli_query($koneksi, "SELECT tarif FROM gedung WHERE jenis_ruangan='{$row['jenis_ruangan']}' LIMIT 1");
$tarif = mysqli_fetch_assoc($qTarif)['tarif'] ?? 0;

// hitung total biaya
$total_biaya = $row['lama_sewa'] * $tarif;
?>
<td>Rp <?= number_format($total_biaya, 0, ',', '.'); ?></td>

  <td class="text-nowrap">
    <a href="delete_pemesanan.php?id=<?= $row['id_pemesanan']; ?>"
       onclick="return confirm('Yakin ingin menghapus data ini?')"
       class="btn btn-danger btn-sm"
       title="Delete">
       <i class="fa fa-trash"></i>
    </a>
</td>

</tr>
<?php } ?>
</tbody>

</table>
							</code></pre>

					</div>
				</div>
				
			<?php
			include 'footer.php';
			?>

<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>

<!-- Popper & Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

<!-- WAJIB UNTUK Ela Admin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>

<!-- Ela Admin Core -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>


      </body>
</html>