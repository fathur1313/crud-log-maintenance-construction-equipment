<?php
// filepath: c:\xampp\htdocs\crud_perusahaan\partial_tabel_maintenance.php
$where = "WHERE tanggal IS NOT NULL";
if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
    $alat = mysqli_real_escape_string($conn, $_GET['filter_alat_berat']);
    $where .= " AND alat_berat = '$alat'";
}
if (isset($_GET['filter_bulan_tahun']) && $_GET['filter_bulan_tahun'] != '') {
    $bulan_tahun = $_GET['filter_bulan_tahun'];
    $where .= " AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_tahun'";
}
$sql = mysqli_query($conn, "SELECT * FROM tb_laporan_unit $where");

// Query total biaya
$query_total = "SELECT SUM(harga_total) as total_biaya FROM tb_laporan_unit WHERE tanggal IS NOT NULL";
if (isset($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] != '') {
    $alat = mysqli_real_escape_string($conn, $_GET['filter_alat_berat']);
    $query_total .= " AND alat_berat = '$alat'";
}
if (isset($_GET['filter_bulan_tahun']) && $_GET['filter_bulan_tahun'] != '') {
    $bulan_tahun = $_GET['filter_bulan_tahun'];
    $query_total .= " AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_tahun'";
}
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_biaya = $row_total['total_biaya'] ?? 0;

if (isset($_SESSION['eksekusi'])) {
?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?php
            echo $_SESSION['eksekusi'];
            unset($_SESSION['eksekusi']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<div class="mt-4">
    <form method="GET" action="">
        <div class="row">
            
            <!-- Tambah Data -->
            <div class="d-flex gap-2 mb-2">
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user') { ?>
                    <a href="kelola.php" type="button" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </a>
                <?php } ?>
            </div>

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
             
            <!-- Tombol Filter, Reset, Download -->

            <div class="col-md-4 d-flex align-items-end mt-3">
                <button type="submit" class="btn btn-success me-2">Filter</button>
                <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>#1" class="btn btn-warning me-2">Reset</a>
                
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager') { ?>
                    <a href="print.php?<?php 
                    echo http_build_query([
                        'filter_bulan_tahun' => isset($_GET['filter_bulan_tahun']) ? $_GET['filter_bulan_tahun'] : null,
                        'filter_alat_berat' => isset($_GET['filter_alat_berat']) ? $_GET['filter_alat_berat'] : null
                    ]); ?>" 
                    class="btn btn-danger" target="_blank">Download</a>
                <?php } ?>
            </div>

        </div>
    </form>
</div>

<div class="mt-3">
    <h5>Total Biaya: Rp <?php echo number_format($total_biaya, 0, ',', '.'); ?></h5>
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
            $no = 0;
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
                    <img src="img/<?php echo $result['foto_dokumentasi'];?>" style="width: 125px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('img/<?php echo $result['foto_dokumentasi'];?>')">
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