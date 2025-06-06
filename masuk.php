<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION['username'])){
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

	<title>Login Crud Perusahaan</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-fluid {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-floating {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

    <nav class="navbar navbar-light bg-light">
      <div class="d-flex align-items-center ps-3">
        <img src="img/Logo/ITP_LOGO.png" width="30" height="30" alt="Logo" class="me-2">
        <span class="navbar-brand mb-0 h1">INDO TRAKTORS PAPUA</span>
      </div>
    </nav>


        <div class="container-fluid">
            <form class="form-login" method="post" action="login.php">
                <h3 class="fw-normal text-center">Masuk Akun</h3>
                <div class="form-floating">
                    <input type="username" name="username" class="form-control mb-2" placeholder="Username" required>
                    <label>Username</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                    <label>Password</label>
                </div>
                <button class="btn btn-primary w-100 mb-2" type="submit">
                    <i class="fa fa-sign-in"></i>
                    Masuk
                </button>
                <p>Tidak Punya Username ? <a href="daftar.php">Daftar</a></p>
                <p class="text-muted text-center">&copy; 2025</p>
            </form>
        </div>
    </body>
</html>