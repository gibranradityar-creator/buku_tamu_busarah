<?php
// Memulai session jika belum berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Cek role user (Pengecekan MultiUser)
// Jika role-nya adalah admin, maka tidak boleh akses buku-tamu.php (dialihkan ke users.php)
if ($_SESSION['user_role'] === 'admin') {
    echo "<script>
            alert('Akses ditolak! Halaman Buku Tamu khusus untuk Operator.');
            document.location.href = 'users.php';
          </script>";
    exit;
}

require_once('function.php');
include_once('templates/header.php');

// Mengambil seluruh data dari tabel buku_tamu
$buku_tamu = query("SELECT * FROM buku_tamu");

// Cek apakah tombol simpan sudah ditekan
if (isset($_POST['simpan'])) {
    if (tambah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'buku-tamu.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'buku-tamu.php';
              </script>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Buku Tamu</h6>
            <!-- Tombol Pemicu Modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Tamu</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Bertemu</th>
                            <th>Kepentingan</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($buku_tamu as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['id_tamu']; ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= $row['nama_tamu']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td><?= $row['no_hp']; ?></td>
                                <td><?= $row['bertemu']; ?></td>
                                <td><?= $row['kepentingan']; ?></td>
                                <td class="text-center">
                                    <img src="assets/upload_gambar/<?= $row['gambar']; ?>" width="70" class="img-thumbnail" alt="Foto Tamu">
                                </td>
                                <td>
                                    <a href="edit-buku-tamu.php?id=<?= $row['id_tamu']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="hapus.php?id=<?= $row['id_tamu']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i> Hapus</a>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Buku Tamu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Ditambahkan enctype="multipart/form-data" untuk pendukung upload file -->
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_tamu">ID Tamu</label>
                        <input type="text" class="form-control" id="id_tamu" name="id_tamu" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_tamu">Nama Tamu</label>
                        <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No. HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" maxlength="13" required>
                    </div>
                    <div class="form-group">
                        <label for="bertemu">Bertemu</label>
                        <input type="text" class="form-control" id="bertemu" name="bertemu" required>
                    </div>
                    <div class="form-group">
                        <label for="kepentingan">Kepentingan</label>
                        <input type="text" class="form-control" id="kepentingan" name="kepentingan" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Unggah Foto Tamu</label>
                        <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('templates/footer.php');
?>  