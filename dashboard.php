<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: masuk.php');
        exit;
    };
?>
<html lang="en">
    	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js" ></script>
	
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
    </Style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center px-4 py-5">
            <img class="d-block mx-auto mb-2" src="img/Logo/ITP.png" width="95" height="95" alt="Logo">
            <span class="">Selamat Datang
                <?php
                    echo  $_SESSION['username'];
                ?>
            </span>
            <h1 class="text-center">Dashboard Admin Perusahaan</h1>
            <div class="row">
                <div class="col-md-4">
                    <h2 class="mb-4">Data Maintenance Alat</h2>
                    <p class="text-muted">Jumlah Data: ~</p>
                    <a href="tabel_maintenance.php" class="btn btn-success">Tabel Data</a>
                </div>
                <div class="col-md-4">
                    <h2 class="mb-4">Data Pengguna</h2>
                    <p class="text-muted">Jumlah Pengguna: 5</p>
                    <a href="tambah_pengguna.html" class="btn btn-warning">Tabel Pengguna</a>
                </div>
                <div class="col-md-4">
                    <h2 class="mb-4">Data Admin</h2>
                    <p class="text-muted">Jumlah Admin: 2</p>
                    <a href="tambah_admin.html" class="btn btn-danger">Tabel Admin</a>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger mt-3">
                <i class="fa fa-sign-out"></i>
                Keluar
            </a>
            </button>
        </div>
    </div>
</body>
</html>