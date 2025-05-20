<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location: masuk.php');
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Manager Perusahaan</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <style>
        body { background: #f8f9fa; }
        .navbar-custom {
            background: #343a40 !important;
            color: #fff !important;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2001; /* lebih tinggi dari sidebar */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .hamburger,
        .navbar-custom .fa-bars {
            color: #fff !important;
        }
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            background: #343a40;
            color: #fff;
            padding-top: 30px;
            transition: margin-left 0.3s, width 0.3s;
            position: fixed;
            left: 0;
            top: 56px; /* di bawah navbar */
            width: 220px;
            z-index: 1000;
        }
        .sidebar.hide {
            margin-left: -220px;
        }
        .sidebar a {
            color: #fff !important;
            display: block;
            padding: 15px 20px;
            text-decoration: none !important;
            transition: background 0.2s;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #495057;
            color: #fff !important;
            text-decoration: none !important;
        }
        .content-area {
            padding: 40px 30px;
            background: #fff;
            min-height: 100vh;
            transition: margin-left 0.3s;
            margin-left: 220px;
            margin-top: 56px; /* agar tidak tertutup navbar */
        }
        .logo-img-wrapper {
            background: #fff;
            display: inline-block;
            padding: 10px;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 10px;
        }
        .logo-img {
            width: 60px;
            display: block;
        }
        .hamburger {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #fff;
            margin-right: 15px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
                height: 100vh;
                left: 0;
                top: 56px; /* Tinggi navbar */
            }
            .sidebar.hide {
                margin-left: -220px;
            }
            .content-area {
                padding: 20px 10px;
                margin-left: 0;
                margin-top: 56px;
            }
            .navbar-custom {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 2001;
            }
            body {
                padding-top: 0;
            }
        }
        .sidebar.hide ~ .content-area {
            margin-left: 0 !important;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-custom">
    <button class="hamburger" id="toggleSidebar" aria-label="Toggle sidebar">
        <i class="fa fa-bars"></i>
    </button>
    <span class="navbar-brand mb-0 h1">Dashboard Manager</span>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="sidebar col-md-2" id="sidebar">
            <div class="text-center">
                <div class="logo-img-wrapper">
                    <img src="img/Logo/ITP_LOGO.png" class="logo-img" alt="Logo">
                </div>
                <h5 class="mt-3">INDO TRAKTORS PAPUA</h5>
            </div>
            <a href="#1" class="active" onclick="showContent('maintenance')"><i class="fa fa-cogs"></i> Data Alat</a>
            <a href="logout.php" class="mt-5 btn btn-danger w-100"><i class="fa fa-sign-out"></i> Keluar</a>
        </nav>
        <!-- Content -->
        <main class="content-area col" id="main-content">
            <h2>Selamat Datang, <?php echo $_SESSION['username']; ?></h2>
            <div id="maintenance" class="dashboard-content">
                <h3 class="mt-5">Data Maintenance Alat</h3>
                <?php
                    $_SESSION['role'] = 'manager';
                    include 'partial_tabel_maintenance.php';
                ?>
            </div>
        </main>
    </div>
</div>
<script>
function showContent(id) {
    document.querySelectorAll('.dashboard-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active'));
    document.getElementById(id).style.display = 'block';
    event.target.classList.add('active');
}

// Sidebar toggle
document.getElementById('toggleSidebar').onclick = function() {
    document.getElementById('sidebar').classList.toggle('hide');
    // Toggle margin for content-area
    if(window.innerWidth > 768){
        document.getElementById('main-content').style.marginLeft = 
            document.getElementById('sidebar').classList.contains('hide') ? '0' : '220px';
    }
};
window.addEventListener('resize', function() {
    if(window.innerWidth <= 768){
        document.getElementById('main-content').style.marginLeft = '0';
    } else if(!document.getElementById('sidebar').classList.contains('hide')){
        document.getElementById('main-content').style.marginLeft = '220px';
    }
});
window.onload = function() {
    if(window.innerWidth <= 768){
        document.getElementById('main-content').style.marginLeft = '0';
    } else {
        document.getElementById('main-content').style.marginLeft = '220px';
    }
};
</script>
</body>
</html>