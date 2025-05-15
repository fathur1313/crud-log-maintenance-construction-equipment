<?php
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db	  = 'db_perusahaan';

	$conn = mysqli_connect($host, $user, $pass, $db);
	
	mysqli_select_db($conn, $db);

	if (!$conn) {
		die("Koneksi gagal: " . mysqli_connect_error());
	}
?>