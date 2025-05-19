<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: masuk.php');
        exit;
    };

    // Koneksi ke database
    include 'koneksi.php';

    // Query untuk menghitung jumlah data di tabel maintenance
    $query_maintenance = "SELECT COUNT(*) AS total_maintenance FROM tb_laporan_unit";
    $result_maintenance = mysqli_query($conn, $query_maintenance);
    $data_maintenance = mysqli_fetch_assoc($result_maintenance);
    $total_maintenance = $data_maintenance['total_maintenance'];

    // Query untuk menghitung jumlah pengguna (role = 'user')
    $query_user = "SELECT COUNT(*) AS total_user FROM tb_akun WHERE role = 'user'";
    $result_user = mysqli_query($conn, $query_user);
    $data_user = mysqli_fetch_assoc($result_user);
    $total_user = $data_user['total_user'];

    // Query untuk menghitung jumlah admin (role = 'admin')
    $query_admin = "SELECT COUNT(*) AS total_admin FROM tb_akun WHERE role = 'admin'";
    $result_admin = mysqli_query($conn, $query_admin);
    $data_admin = mysqli_fetch_assoc($result_admin);
    $total_admin = $data_admin['total_admin'];

    // Query untuk menghitung jumlah manager (role = 'manager')
    $query_manager = "SELECT COUNT(*) AS total_manager FROM tb_akun WHERE role = 'manager'";
    $result_manager = mysqli_query($conn, $query_manager);
    $data_manager = mysqli_fetch_assoc($result_manager);
    $total_manager = $data_manager['total_manager'];
?>
<html lang="en">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

    <title>Dashboard Crud Perusahaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; 
        }

        h1.text-center {
            margin-top: 20px;
            margin-bottom: 40px;
            color: #343a40;
        }

        .container-fluid {
            padding: 20px;
        }

        .col-md-4 {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center px-4 py-5">
            <img class="d-block mx-auto mb-2" src="img/Logo/ITP_LOGO.png" width="95" height="95" alt="Logo">
            <span class="">Selamat Datang
                <?php
                    echo  $_SESSION['username'];
                ?>
            </span>
            <h1 class="text-center">Dashboard Admin Perusahaan</h1>
            <div class="row">
                <div class="col-md-3">
                    <h2 class="mb-4">Data Maintenance Alat</h2>
                    <p class="text-muted">Jumlah Data: <?php echo $total_maintenance; ?></p>
                    <a href="tabel_maintenance.php" class="btn btn-success">Tabel Data</a>
                </div>
                <div class="col-md-3">
                    <h2 class="mb-4">Data Pengguna</h2>
                    <p class="text-muted">Jumlah Pengguna: <?php echo $total_user; ?></p>
                    <a href="tabel_user.php" class="btn btn-warning">Tabel Pengguna</a>
                </div>
                <div class="col-md-3">
                    <h2 class="mb-4">Data Admin</h2>
                    <p class="text-muted">Jumlah Admin: <?php echo $total_admin; ?></p>
                    <a href="tabel_admin.php" class="btn btn-danger">Tabel Admin</a>
                </div>
                <div class="col-md-3">
                    <h2 class="mb-4">Data Manager</h2>
                    <p class="text-muted">Jumlah Manager: <?php echo $total_manager; ?></p>
                    <a href="tabel_manager.php" class="btn btn-primary">Tabel Manager</a>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger mt-3">
                <i class="fa fa-sign-out"></i>
                Keluar
            </a>
        </div>
    </div>
</body>
</html>