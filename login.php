<?php
    session_start();

    $a_username = "adminmaster";
    $a_pass = password_hash("123", PASSWORD_DEFAULT);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username == $a_username){
            if(password_verify($password, $a_pass)){
                $_SESSION['username'] = $username;
                header ('Location: dashboard.php');
                exit;
            }else{
                echo " 
                <script>
                    alert('password salah'); window.location.href='masuk.php';
                </script>";
                exit;
            }
        } else {
            echo " 
                <script>
                    alert('username tidak tersedia'); window.location.href='masuk.php';
                </script>";
                exit;
        }
    }
?>