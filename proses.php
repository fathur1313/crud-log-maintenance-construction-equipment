<?php
	include 'fungsi.php';
	session_start();

	function redirect_dashboard($pesan) {
        $role = $_SESSION['role'] ?? '';
        $hash = '#1'; // tab Data Alat
        if ($role == 'admin') {
            $_SESSION['eksekusi'] = $pesan;
            header('Location: dashboard_admin.php' . $hash);
        } elseif ($role == 'user') {
            $_SESSION['eksekusi'] = $pesan;
            header('Location: dashboard_user.php' . $hash);
        } elseif ($role == 'manager') {
            $_SESSION['eksekusi'] = $pesan;
            header('Location: dashboard_manager.php' . $hash);
        } else {
            $_SESSION['eksekusi'] = $pesan;
            header('Location: masuk.php');
        }
        exit;
    }

	if(isset($_POST['aksi'])){
		if($_POST['aksi'] == "add") {
			$berhasil = tambah_data($_POST, $_FILES);
			if($berhasil){
				redirect_dashboard("Data Berhasil Ditambahkan");
			} else {
				echo $berhasil;
			}
		} else if ($_POST['aksi'] == "edit"){
			$berhasil = ubah_data($_POST, $_FILES);
			if($berhasil){
				redirect_dashboard("Data Berhasil Diperbarui");
			} else {
				echo $berhasil;
			}
		}
	}
	if (isset($_GET['hapus'])) {
		$no = $_GET['hapus'];
		$berhasil = hapus_data($no);
		if($berhasil){
			redirect_dashboard("Data Berhasil Dihapus");
		} else {
			echo $berhasil;
		}
	}
?>