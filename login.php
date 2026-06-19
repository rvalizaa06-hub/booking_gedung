<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['username'])){
    // kalau sudah login, langsung ke dashboard
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($query) > 0){
        $_SESSION['username'] = $username; // simpan username di session
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>
            alert('Username atau Password salah');
            window.location='login.php';
        </script>";
    }
}
?>


<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login Booking Gedung</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- BOOTSTRAP -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

<style>
body, html {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #fffde8, #ffe6f0);
}

/* Container tengah layar */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Card login */
.login-card {
    background: #ff006aff;
    color: #fff;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    padding: 50px 40px;       /* diperbesar padding */
    width: 100%;
    max-width: 550px;         /* diperbesar dari 450px */
    display: flex;
    align-items: flex-start;  /* supaya logo dan form sejajar ke atas */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.login-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

/* Gambar di kiri card */
.login-card .login-image {
    flex: 0 0 100px;
    margin-right: 20px;
}

.login-card .login-image img {
    max-width: 100%;
    border-radius: 12px;
    margin-top: -10px; /* naikkan posisi logo agar sejajar judul */
}

/* Form login */
.login-card .login-form {
    flex: 1;
}

.login-card .title-main {
    font-weight: 800;
    font-size: 24px;
    margin-bottom: 5px;
}

.login-card .title-sub {
    font-weight: 700;
    font-size: 14px;
    letter-spacing: 2px;
    opacity: 0.9;
    margin-bottom: 20px;
}

.form-group {
    position: relative;
}

.form-group .fa {
    position: absolute;
    top: 12px;
    left: 15px;
    color: rgba(0,0,0,0.3);
}

.form-control {
    border-radius: 12px;
    border: none;
    padding: 12px 15px 12px 40px;
    font-size: 16px;
}

.btn-signin-pink {
    background-color: #fff;
    color: #ff006aff;
    font-weight: bold;
    border-radius: 12px;
    width: 100%;
    padding: 12px;
    font-size: 16px;
    transition: 0.3s;
}

.btn-signin-pink:hover {
    background-color: #f5dfe6ff;
    color: #ff006aff;
}

.register-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    opacity: 0.8;
}

/* Responsive */
@media (max-width: 576px) {
    .login-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .login-card .login-image {
        margin-right: 0;
        margin-bottom: 20px;
    }
    .login-card .login-image img {
        margin-top: 0; /* hapus margin-top negatif di HP */
    }
}
</style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <!-- Gambar kecil di kiri -->
        <div class="login-image">
            <img src="images/gedungpink.png" alt="Logo Gedung">
        </div>

        <!-- Form login -->
        <div class="login-form">
            <div class="title-main">Login Gedung Pertemuan</div>
            <div class="title-sub text-uppercase">Karawaci</div>

            <form method="post" action="proses_login.php">
                <div class="form-group">
                    <span class="fa fa-user"></span>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <span class="fa fa-lock"></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-signin-pink mt-3">Sign In</button>
            </form>

            <div class="register-link">
                @Gedung Pertemuan - Karawaci
            </div>
        </div>
    </div>
</div>

</body>
</html>
