<?php
// Pastikan session sudah dimodelkan/dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek apakah role user adalah 'admin'
// Jika BUKAN admin (misal: operator), arahkan ke halaman buku-tamu.php
if ($_SESSION['user_role'] !== 'admin') {
    echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk Admin.');
            document.location.href = 'buku-tamu.php';
          </script>";
    exit;
}

require_once('function.php');
include_once('templates/header.php');

// Logika untuk menyimpan data user jika tombol simpan ditekan
if (isset($_POST['simpan_user'])) {
    if (tambah_user($_POST) > 0) {
        echo "<script>
                alert('Data user berhasil ditambahkan!');
                document.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Data user gagal ditambahkan!');
                document.location.href = 'users.php';
              </script>";
    }
}

// Ambil data user dari database
$users = query("SELECT * FROM users");
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
            <!-- Tombol Trigger Modal Tambah User -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahUserModal">
                <i class="fas fa-plus"></i> Tambah User
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID User</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['id_user']; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['user_role']; ?></td>
                                <td>
                                    <a href="edit-user.php?id=<?= $row['id_user']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="hapus-user.php?id=<?= $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <?php
                    // Logika ID User Otomatis (US001, US002, dst)
                    global $koneksi;
                    $query_id = mysqli_query($koneksi, "SELECT max(id_user) as kodeMax FROM users");
                    $data_id = mysqli_fetch_array($query_id);
                    $kodeUser = $data_id['kodeMax'];
                    $urutan = (int) substr($kodeUser, 2, 3);
                    $urutan++;
                    $huruf = "US";
                    $kodeUser = $huruf . sprintf("%03s", $urutan);
                    ?>

                    <div class="form-group">
                        <label for="id_user">ID User</label>
                        <input type="text" class="form-control" id="id_user" name="id_user" value="<?= $kodeUser; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="user_role">User Role</label>
                        <select class="form-control" id="user_role" name="user_role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_user" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('templates/footer.php');
?>