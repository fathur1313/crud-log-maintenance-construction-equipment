<?php
    require('koneksi.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $confirm_password = password_hash($_POST['confirm_password'],PASSWORD_DEFAULT);

        $query = "INSERT INTO tb_akun(username, password) VALUES ('$username', '$password')";

        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Akun berhasil didaftarkan, Silahkan Masuk'); window.location.href='masuk.php';</script>";
        } else {
            echo "<script>alert('Akun gagal dibuat'); window.location.href='regist.php';</script>";
        }
        $conn->close();
    }
?>