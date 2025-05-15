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

	<title>Daftar Crud Perusahaan</title>
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

    <script type="text/javascript">
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            
            if (password !== confirmPassword) {
                alert("Password dan Konfirmasi Password Tidak Sesuai !");
                return false;
            }
            return true;
        }

    </script>

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
        <form class="form-daftar" onsubmit="return validateForm()" method="post" action="regist.php">
            <h3 class="fw-normal text-center">Daftar User</h3>
            <input name= "username" type="username" class="form-control mb-2" placeholder="Username" required>
            <input name="password" id="password" type="password" class="form-control mb-2" placeholder="Password" required>
            <input name="confirm_password" id="confirm_password" type="password" class="form-control mb-2" placeholder="Konfirmasi Password" required>
            <button class="btn btn-primary w-100" type="submit">
                <i class="fa fa-pencil"></i>
                Daftar
            </button>
            <p>Sudah Punya Username ? <a href="masuk.php">Masuk</a></p>
            <p class="text-muted text-center">&copy; 2025</p>
        </form>
    </div>
</body>
</html>