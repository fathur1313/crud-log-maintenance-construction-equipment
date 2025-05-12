<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <!-- Tambahkan CSS Bootstrap untuk tampilan tabel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .aksi-column {
            width: 150px; /* Sesuaikan lebar kolom */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Admin</h1>

        <!-- Tombol tambah admin -->
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">Tambah Admin</button>
        <!-- Tombol kembali ke dashboard -->
        <a href="dashboard_admin.php" class="btn btn-danger mb-3">Kembali</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th class="text-center aksi-column">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                include 'koneksi.php';

                // Query untuk mengambil data admin
                $query = "SELECT id_user, username, role FROM tb_akun WHERE role = 'admin'";
                $result = mysqli_query($conn, $query);

                // Inisialisasi nomor urut
                $no = 1;

                // Tampilkan data admin
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>"; // Nomor urut
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td class='text-center'>
                                <div class='d-flex justify-content-center gap-2'>
                                    <a href='hapus_admin.php?id_user=" . $row['id_user'] . "' class='btn btn-danger btn-sm' onClick=\"return confirm('Apakah Anda yakin ingin menghapus admin ini?')\">Hapus</a>
                                    <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#ubahPasswordModal" . $row['id_user'] . "'>Ubah Pass</button>
                                </div>
                              </td>";
                        echo "</tr>";

                        // Modal untuk ubah kata sandi
                        echo "
                        <div class='modal fade' id='ubahPasswordModal" . $row['id_user'] . "' tabindex='-1' aria-labelledby='ubahPasswordModalLabel" . $row['id_user'] . "' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <form action='ubah_password_admin.php' method='POST'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='ubahPasswordModalLabel" . $row['id_user'] . "'>Ubah Kata Sandi</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <input type='hidden' name='id_user' value='" . $row['id_user'] . "'>
                                            <div class='mb-3'>
                                                <label for='password' class='form-label'>Kata Sandi Baru</label>
                                                <input type='password' class='form-control' id='password' name='password' required>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                            <button type='submit' class='btn btn-warning'>Ubah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada data admin</td></tr>";
                }

                // Tutup koneksi
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Admin -->
    <div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-labelledby="tambahAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="tambah_admin.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahAdminModalLabel">Tambah Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>