<?php
	include 'koneksi.php';

	$query = "SELECT * FROM tb_laporan_unit;";
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
			        <td><?php echo $result['tanggal'];?></td>
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