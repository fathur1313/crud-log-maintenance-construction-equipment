<?php
    require 'koneksi.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
       
        $query = "SELECT * FROM tb_akun WHERE username = '$username'";
        $sql = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($sql);
       
        if($result){
            if(password_verify($password, $result['password'])){
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $result['role'];

                if($result['role'] == 'admin'){
                    header ('Location: dashboard_admin.php');
                }else if($result['role'] == 'user'){
                    header ('Location: dashboard_user.php');
                }
                exit();
            }else{
                echo " 
                <script>
                    alert('password salah'); window.location.href='masuk.php';
                </script>";
            }
        } else {
            echo " 
                <script>
                    alert('username tidak tersedia'); window.location.href='masuk.php';
                </script>";
        }
    }
?>