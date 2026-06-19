<?php
session_start();
include 'koneksi.php'; // koneksi database
// Cek apakah form login dikirim
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Ambil data input dan bersihkan
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk mengecek user
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) > 0) {
        // Login sukses → buat session
        $_SESSION['username'] = $username;

        // Redirect ke dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Login gagal → kembali ke login dengan alert
        echo "<script>
            alert('Username atau Password salah!');
            window.location='login.php';
        </script>";
        exit;
    }
} else {
    // Jika akses langsung proses_login.php tanpa form
    header("Location: login.php");
    exit;
}
?>
