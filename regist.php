<?php
    require('koneksi.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate passwords match
        if ($password !== $confirm_password) {
            echo "<script>alert('Password dan konfirmasi tidak cocok'); window.location.href='regist.php';</script>";
            exit;
        }

        // Check if username already exists using prepared statement
        $stmt = mysqli_prepare($conn, "SELECT 1 FROM tb_akun WHERE username = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                echo "<script>alert('Username sudah terdaftar'); window.location.href='regist.php';</script>";
                exit;
            }
            mysqli_stmt_close($stmt);
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $insert = mysqli_prepare($conn, "INSERT INTO tb_akun (username, password) VALUES (?, ?)");
        if ($insert) {
            mysqli_stmt_bind_param($insert, 'ss', $username, $hashed);
            if (mysqli_stmt_execute($insert)) {
                mysqli_stmt_close($insert);
                echo "<script>alert('Akun berhasil didaftarkan, Silahkan Masuk'); window.location.href='masuk.php';</script>";
            } else {
                mysqli_stmt_close($insert);
                echo "<script>alert('Akun gagal dibuat'); window.location.href='regist.php';</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan server'); window.location.href='regist.php';</script>";
        }

        mysqli_close($conn);
    }
?>