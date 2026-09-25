<?php
require_once('function.php');
include_once('templates/header.php');

// Ambil nilai tanggal filter dari POST jika ada
$tgl_awal = $_POST['tgl_awal'] ?? '';
$tgl_akhir = $_POST['tgl_akhir'] ?? '';

// Query data sesuai filter tanggal
if (isset($_POST['tampilkan']) && !empty($tgl_awal) && !empty($tgl_akhir)) {
    $buku_tamu = query("SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC");
} else {
    $buku_tamu = query("SELECT * FROM buku_tamu ORDER BY tanggal ASC");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Buku Tamu</h1>

    <!-- Form Filter Tanggal & Export -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Periode Laporan</h6>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal; ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir; ?>">
                    </div>
                    <div class="col-md-4 align-self-end">
                        <button type="submit" name="tampilkan" class="btn btn-primary">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                        <button type="submit" name="export" formaction="export-laporan.php" formtarget="_blank" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <a href="laporan.php" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Laporan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Buku Tamu</h6>
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
                            <th>No HP</th>
                            <th>Bertemu</th>
                            <th>Kepentingan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($buku_tamu as $row) :
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['id_tamu']; ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= $row['nama_tamu']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td><?= $row['no_hp']; ?></td>
                                <td><?= $row['bertemu']; ?></td>
                                <td><?= $row['kepentingan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>