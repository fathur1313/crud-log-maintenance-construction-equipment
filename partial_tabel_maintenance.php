<?php
// filepath: c:\xampp\htdocs\crud_perusahaan\partial_tabel_maintenance.php

// Filter Query
$where = "WHERE tanggal IS NOT NULL";
if (!empty($_GET['filter_alat_berat'])) {
    $alat = mysqli_real_escape_string($conn, $_GET['filter_alat_berat']);
    $where .= " AND alat_berat = '$alat'";
}
if (!empty($_GET['filter_bulan_tahun'])) {
    $bulan_tahun = $_GET['filter_bulan_tahun'];
    $where .= " AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_tahun'";
}
$sql = mysqli_query($conn, "SELECT * FROM tb_laporan_unit $where");

// Query total biaya
$query_total = "SELECT SUM(harga_total) as total_biaya FROM tb_laporan_unit WHERE tanggal IS NOT NULL";
if (!empty($_GET['filter_alat_berat'])) {
    $alat = mysqli_real_escape_string($conn, $_GET['filter_alat_berat']);
    $query_total .= " AND alat_berat = '$alat'";
}
if (!empty($_GET['filter_bulan_tahun'])) {
    $bulan_tahun = $_GET['filter_bulan_tahun'];
    $query_total .= " AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_tahun'";
}
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_biaya = $row_total['total_biaya'] ?? 0;

// Notifikasi Eksekusi
if (isset($_SESSION['eksekusi'])): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <?php
            echo $_SESSION['eksekusi'];
            unset($_SESSION['eksekusi']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container-fluid px-0" style="max-width: 100%;">
    <div class="mt-4" style="max-width: 1000px; margin: 0 auto;">
        <form method="GET" action="">
            <div class="row g-3 align-items-end">
                <!-- Filter Alat Berat -->
                <div class="col-lg-3 col-md-6">
                    <label for="filter_alat_berat" class="form-label fw-semibold">Alat Berat</label>
                    <select class="form-select shadow-sm" id="filter_alat_berat" name="filter_alat_berat">
                        <option value="">Semua Alat Berat</option>
                        <?php
                        $alat_berat_query = "SELECT DISTINCT alat_berat FROM tb_laporan_unit";
                        $alat_berat_result = mysqli_query($conn, $alat_berat_query);
                        while ($row = mysqli_fetch_assoc($alat_berat_result)):
                            $selected = (!empty($_GET['filter_alat_berat']) && $_GET['filter_alat_berat'] == $row['alat_berat']) ? 'selected' : '';
                            echo "<option value='{$row['alat_berat']}' $selected>{$row['alat_berat']}</option>";
                        endwhile;
                        ?>
                    </select>
                </div>

                <!-- Filter Bulan dan Tahun -->
                <div class="col-lg-3 col-md-6">
                    <label for="filter_bulan_tahun" class="form-label fw-semibold">Bulan & Tahun</label>
                    <input type="month" class="form-control shadow-sm" id="filter_bulan_tahun" name="filter_bulan_tahun"
                        value="<?php echo isset($_GET['filter_bulan_tahun']) ? $_GET['filter_bulan_tahun'] : ''; ?>">
                </div>

                <!-- Tombol Filter, Reset, Download, Tambah Data -->
                <div class="col-lg-6 col-md-12 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-success flex-fill shadow-sm d-flex align-items-center gap-2">
                        <i class="fa fa-filter"></i>
                        <span>Filter</span>
                    </button>
                    <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>#1" class="btn btn-warning flex-fill shadow-sm d-flex align-items-center gap-2">
                        <i class="fa fa-refresh"></i>
                        <span>Reset</span>
                    </a>
                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manager'): ?>
                        <a href="print.php?<?php 
                            echo http_build_query([
                                'filter_bulan_tahun' => $_GET['filter_bulan_tahun'] ?? null,
                                'filter_alat_berat' => $_GET['filter_alat_berat'] ?? null
                            ]);
                        ?>" class="btn btn-danger flex-fill shadow-sm d-flex align-items-center gap-2" target="_blank">
                            <i class="fa fa-download"></i>
                            <span>Download</span>
                        </a>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user'): ?>
                        <a href="kelola.php" class="btn btn-primary flex-fill shadow-sm d-flex align-items-center gap-2">
                            <i class="fa fa-plus fa-lg"></i>
                            <span>Tambah Data</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4" style="max-width: 1000px; margin: 0 auto;">
        <div class="alert alert-info d-flex align-items-center gap-2 shadow-sm mb-0" role="alert" style="font-size:1.1rem;">
            <i class="fa fa-money-bill-wave fa-lg text-success"></i>
            <strong>Total Biaya:</strong>
            <span class="ms-2 text-danger fw-bold">Rp <?php echo number_format($total_biaya, 0, ',', '.'); ?></span>
        </div>
    </div>
</div>

<?php
// --- PAGINATION LOGIC ---
// Get current page from GET, default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 6; // Rows per page
$offset = ($page - 1) * $limit;

// Count total rows for pagination
$count_query = "SELECT COUNT(*) as total FROM tb_laporan_unit $where";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_rows = $count_row['total'] ?? 0;
$total_pages = ceil($total_rows / $limit);

// Fetch paginated data
$sql = mysqli_query($conn, "SELECT * FROM tb_laporan_unit $where ORDER BY tanggal DESC LIMIT $limit OFFSET $offset");
?>

<div class="table-responsive mt-3">
    <table class="table align-middle table-bordered table-hover table-striped shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th class="text-center">No.</th>
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
            <?php $no = $offset; while ($result = mysqli_fetch_assoc($sql)): ?>
                <tr>
                    <td class="text-center fw-bold"><?php echo ++$no; ?></td>
                    <td><?php echo date('d F Y', strtotime($result['tanggal'])); ?></td>
                    <td><span class="badge bg-info text-dark"><?php echo $result['alat_berat']; ?></span></td>
                    <td><?php echo $result['part_name']; ?></td>
                    <td><?php echo $result['part_number']; ?></td>
                    <td class="text-end"><?php echo $result['qty']; ?></td>
                    <td class="text-end text-success">Rp <?php echo number_format($result['harga_satuan'], 0, ',', '.'); ?></td>
                    <td class="text-end text-danger fw-semibold">Rp <?php echo number_format($result['harga_total'], 0, ',', '.'); ?></td>
                    <td><?php echo $result['keterangan']; ?></td>
                    <td>
                        <?php if (!empty($result['foto_dokumentasi'])): ?>
                            <img src="img/<?php echo $result['foto_dokumentasi']; ?>" class="img-thumbnail border-2 shadow-sm"
                                style="width: 90px; height: 60px; object-fit: cover; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                onclick="showImage('img/<?php echo $result['foto_dokumentasi']; ?>')">
                        <?php else: ?>
                            <span class="text-muted fst-italic">Tidak ada foto</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="kelola.php?ubah=<?php echo $result['no']; ?>" class="btn btn-success btn-sm" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="proses.php?hapus=<?php echo $result['no']; ?>" class="btn btn-danger btn-sm"
                                onClick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Tersebut???')" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php if ($no == $offset): ?>
        <div class="alert alert-warning text-center mt-3 mb-0">Data tidak ditemukan.</div>
    <?php endif; ?>
</div>

<!-- PAGINATION NAVIGATION -->
<?php if ($total_pages > 1): ?>
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center shadow-sm rounded-pill bg-white py-2 px-3" style="gap: 0.25rem;">
        <!-- Previous -->
        <li class="page-item<?php if ($page <= 1) echo ' disabled'; ?>">
            <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
               href="?<?php
                    $params = $_GET;
                    $params['page'] = $page - 1;
                    echo http_build_query($params);
                ?>"
               tabindex="-1"
               aria-label="Sebelumnya"
               style="width: 38px; height: 38px;">
                <i class="fa fa-chevron-left"></i>
            </a>
        </li>
        <!-- Page Numbers (show max 5 pages, with ellipsis if needed) -->
        <?php
        $max_links = 5;
        $start = max(1, $page - floor($max_links / 2));
        $end = min($total_pages, $start + $max_links - 1);
        if ($end - $start < $max_links - 1) {
            $start = max(1, $end - $max_links + 1);
        }
        if ($start > 1): ?>
            <li class="page-item">
                <a class="page-link rounded-circle" href="?<?php
                    $params = $_GET;
                    $params['page'] = 1;
                    echo http_build_query($params);
                ?>" style="width: 38px; height: 38px;">1</a>
            </li>
            <?php if ($start > 2): ?>
                <li class="page-item disabled"><span class="page-link bg-transparent border-0" style="width: 38px;">...</span></li>
            <?php endif; ?>
        <?php endif; ?>
        <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
                <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
                   href="?<?php
                        $params = $_GET;
                        $params['page'] = $i;
                        echo http_build_query($params);
                    ?>"
                   style="width: 38px; height: 38px;"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?>
                <li class="page-item disabled"><span class="page-link bg-transparent border-0" style="width: 38px;">...</span></li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link rounded-circle" href="?<?php
                    $params = $_GET;
                    $params['page'] = $total_pages;
                    echo http_build_query($params);
                ?>" style="width: 38px; height: 38px;"><?php echo $total_pages; ?></a>
            </li>
        <?php endif; ?>
        <!-- Next -->
        <li class="page-item<?php if ($page >= $total_pages) echo ' disabled'; ?>">
            <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
               href="?<?php
                    $params = $_GET;
                    $params['page'] = $page + 1;
                    echo http_build_query($params);
                ?>"
               aria-label="Berikutnya"
               style="width: 38px; height: 38px;">
                <i class="fa fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
<?php endif; ?>