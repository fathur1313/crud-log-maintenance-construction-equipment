<?php
include 'koneksi.php';

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    mysqli_query($conn, "DELETE FROM tb_akun WHERE id_user='$id_user'");
    echo "<script>
        alert('Petugas berhasil dihapus!');
        window.location.href='dashboard_admin.php#2';
    </script>";
    exit;
}
header("Location: dashboard_admin.php#2");
exit;
?>