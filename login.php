<?php
    require 'koneksi.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Use prepared statement to avoid SQL injection
        $stmt = mysqli_prepare($conn, "SELECT username, password, role FROM tb_akun WHERE username = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $db_username, $db_password, $db_role);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $db_password)) {
                    session_regenerate_id(true);
                    $_SESSION['username'] = $db_username;
                    $_SESSION['role'] = $db_role;

                    if ($db_role == 'admin') {
                        header('Location: dashboard_admin.php');
                    } else if ($db_role == 'manager') {
                        header('Location: dashboard_manager.php');
                    } else {
                        header('Location: dashboard_mekanik.php');
                    }
                    mysqli_stmt_close($stmt);
                    exit();
                } else {
                    echo "<script>alert('password salah'); window.location.href='masuk.php';</script>";
                }
            } else {
                echo "<script>alert('username tidak tersedia'); window.location.href='masuk.php';</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            // Fallback jika prepared statement gagal
            echo "<script>alert('Terjadi kesalahan server'); window.location.href='masuk.php';</script>";
        }
    }
?>