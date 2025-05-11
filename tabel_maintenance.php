<?php
	include 'koneksi.php';

	session_start();

	// Query dasar
	$query = "SELECT * FROM tb_laporan_unit WHERE tanggal IS NOT NULL";

	// Tambahkan filter bulan dan tahun jika ada
	if (isset($_GET['filter_bulan_tahun']) && $_GET['filter_bulan_tahun'] != '') {
		$filter_bulan_tahun = $_GET['filter_bulan_tahun'];
		if (preg_match('/^\d{4}-\d{2}$/', $filter_bulan_tahun)) { // Validasi format YYYY-MM
			$filter_bulan = date('m', strtotime($filter_bulan_tahun));
			$filter_tahun = date('Y', strtotime($filter_bulan_tahun));
			$query .= " AND MONTH(tanggal) = '$filter_bulan' AND YEAR(tanggal) = '$filter_tahun'";
		} else {
			echo "<div class='alert alert-danger'>Format bulan dan tahun tidak valid!</div>";
		}
	}

	// Tambahkan filter alat berat jika ada
	if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
		$filter_alat_berat = $_GET['filter_alat_berat'];
		$alat_berat_query = "SELECT DISTINCT alat_berat FROM tb_laporan_unit WHERE alat_berat = '$filter_alat_berat'";
		$alat_berat_result = mysqli_query($conn, $alat_berat_query);
		if (mysqli_num_rows($alat_berat_result) > 0) {
			$query .= " AND alat_berat = '$filter_alat_berat'";
		} else {
			echo "<div class='alert alert-danger'>Alat berat tidak valid!</div>";
		}
	}

	// Eksekusi query
	$sql = mysqli_query($conn, $query);
	$no = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js" ></script>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

	<title>crud_perusahaan</title>
</head>
<body>
	<nav class="navbar navbar-light bg-light">
	  <div class="container-fluid">
		<a class="navbar-brand" href="#">  
		  CRUD PERUSAHAAN
		</a>
	  </div>
	</nav>

<!-- Judul -->
<div class="container">
	<h1 class="mt-4">Log Perawatan Alat Berat</h1>
	<figure>
	  <blockquote class="blockquote">
		<p>Berisi Data yang Telah disimpan pada Database.</p>
			</blockquote>
			<figcaption class="blockquote-footer">
		Someone famous in <cite title="Source Title">Source Title</cite>
	  </figcaption>
	</figure>
	<a href="kelola.php" type="button" class="btn btn-primary">
		<i class="fa fa-plus"></i>
		Tambah Data</a>

	<?php
		if (isset($_SESSION['eksekusi'])) {
	?>
		<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
				<?php
					echo $_SESSION['eksekusi'];
					unset($_SESSION['eksekusi']); // Hapus hanya elemen 'eksekusi' dari sesi
				?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php
		}
	?>

	<!-- Filter -->
	<div class="mt-4">
		<form method="GET" action="">
			<div class="row">

				<!-- Filter Alat Berat -->
				<div class="col-md-4">
					<label for="filter_alat_berat" class="form-label">Filter Alat Berat</label>
					<select class="form-select" id="filter_alat_berat" name="filter_alat_berat">
						<option value="">Semua Alat Berat</option>
						<?php
							// Ambil daftar alat berat dari database
							$alat_berat_query = "SELECT DISTINCT alat_berat FROM tb_laporan_unit";
							$alat_berat_result = mysqli_query($conn, $alat_berat_query);
							while ($row = mysqli_fetch_assoc($alat_berat_result)) {
								$selected = (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] == $row['alat_berat']) ? 'selected' : '';
								echo "<option value='{$row['alat_berat']}' $selected>{$row['alat_berat']}</option>";
							}
						?>
					</select>
				</div>

				<!-- Filter Bulan dan Tahun -->
				<div class="col-md-4">
					<label for="filter_bulan_tahun" class="form-label">Filter Bulan dan Tahun</label>
					<input type="month" class="form-control" id="filter_bulan_tahun" name="filter_bulan_tahun" value="<?php echo isset($_GET['filter_bulan_tahun']) ? $_GET['filter_bulan_tahun'] : ''; ?>">
				</div>

				<!-- Tombol Filter, Reset, dan Download -->
				<div class="col-md-4 d-flex align-items-end mt-3">
					<button type="submit" class="btn btn-success me-2">Filter</button>
					<a href="tabel_maintenance.php" class="btn btn-warning me-2">Reset</a>
					<a href="print.php?<?php 
					    echo http_build_query([
					        'filter_bulan_tahun' => isset($_GET['filter_bulan_tahun']) ? $_GET['filter_bulan_tahun'] : null,
					        'filter_alat_berat' => isset($_GET['filter_alat_berat']) ? $_GET['filter_alat_berat'] : null
					    ]); ?>" 
					    class="btn btn-danger" target="_blank">Download</a>
				</div>

			</div>
		</form>
	</div>

	<div class="table-responsive mt-3">
		<table class="table align-middle table-bordered table-hover">
			<thead>
			  <tr>
				<th><center>No.</center></th>
				<th>Tanggal</th>
				<th>Alat Berat</th>
				<th>Part Name</th>
				<th>Part Number</th>
				<th>Qty</th>
				<th>Harga Satuan</th>
				<th>Harga Total</th>
				<th>Keterangan</th>
				<th>Foto Dokumentasi</th>
				<th>Aksi</th>
			  </tr>
			</thead>

			<tbody>
			<?php
				while ($result = mysqli_fetch_assoc($sql)){
			?>	
					<tr>
					<td><center><?php echo ++$no;?></center></td>
					<td><?php echo date('d F Y', strtotime($result['tanggal'])); ?></td>
					<td><?php echo $result['alat_berat'];?></td>
					<td><?php echo $result['part_name'];?></td>
					<td><?php echo $result['part_number'];?></td>
					<td><?php echo $result['qty'];?></td>
					<td><?php echo $result['harga_satuan'];?></td>
					<td><?php echo $result['harga_total'];?></td>
					<td><?php echo $result['keterangan'];?></td>
					<td>
						<img src="img/<?php echo $result['foto_dokumentasi'];?>" style="width: 125px">
					</td>
					<td>
						<a href="kelola.php?ubah=<?php echo $result['no'];?>" type="button" class="btn btn-success btn-sm">
							<i class="fa fa-pencil"></i>
						</a>
						<a href="proses.php?hapus=<?php echo $result['no'];?>" type="button" class="btn btn-danger btn-sm" onClick="return confirm ('Apakah Anda Yakin Ingin Menghapus Data Tersebut???')">
							<i class="fa fa-trash"></i>
						</a>
					</td>
				</tr>
			  <?php
					}	
			  ?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>
