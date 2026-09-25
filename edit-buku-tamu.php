<?php
require_once('function.php');
include_once('templates/header.php');

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data buku tamu berdasarkan ID
$tamu = query("SELECT * FROM buku_tamu WHERE id_tamu = '$id'")[0];

// Cek apakah tombol ubah/simpan sudah ditekan
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'buku-tamu.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah atau tidak ada perubahan!');
                document.location.href = 'buku-tamu.php';
              </script>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Ubah Data Buku Tamu</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Ubah Data</h6>
        </div>
        <div class="card-body">
            <!-- 1. Ditambahkan enctype="multipart/form-data" -->
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_tamu" value="<?= $tamu['id_tamu']; ?>">
                
                <!-- 2. Hidden input gambarLama -->
                <input type="hidden" name="gambarLama" value="<?= $tamu['gambar']; ?>">

                <div class="form-group row">
                    <label for="id_tamu_view" class="col-sm-2 col-form-label">ID Tamu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id_tamu_view" value="<?= $tamu['id_tamu']; ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $tamu['tanggal']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_tamu" class="col-sm-2 col-form-label">Nama Tamu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" value="<?= $tamu['nama_tamu']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $tamu['alamat']; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">No. HP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" maxlength="13" value="<?= $tamu['no_hp']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bertemu" class="col-sm-2 col-form-label">Bertemu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bertemu" name="bertemu" value="<?= $tamu['bertemu']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kepentingan" class="col-sm-2 col-form-label">Kepentingan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kepentingan" name="kepentingan" value="<?= $tamu['kepentingan']; ?>" required>
                    </div>
                </div>

                <!-- 3. Field Unggah Gambar / Foto -->
                <div class="form-group row">
                    <label for="gambar" class="col-sm-2 col-form-label">Gambar Foto</label>
                    <div class="col-sm-10">
                        <img src="assets/upload_gambar/<?= $tamu['gambar']; ?>" alt="Foto Tamu" width="120" class="img-thumbnail mb-2"><br>
                        <input type="file" class="form-control-file" id="gambar" name="gambar">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <a href="buku-tamu.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="ubah" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>