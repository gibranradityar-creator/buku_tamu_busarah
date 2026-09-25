<?php
require_once('function.php');
include_once('templates/header.php');

// Cek apakah ada id_user di URL
if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$id_user = $_GET['id'];

// Ambil data user berdasarkan id_user
$user = query("SELECT * FROM users WHERE id_user = '$id_user'")[0];

// Cek apakah tombol simpan sudah ditekan
if (isset($_POST['ubah_user'])) {
    if (ubah_user($_POST) > 0) {
        echo "<script>
                alert('Data user berhasil diubah!');
                document.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Data user gagal diubah!');
                document.location.href = 'users.php';
              </script>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Ubah Data User</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Ubah User</h6>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="id_user">ID User</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" value="<?= $user['id_user']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah password)</small></label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="user_role">User Role</label>
                    <select class="form-control" id="user_role" name="user_role" required>
                        <option value="admin" <?= $user['user_role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="operator" <?= $user['user_role'] == 'operator' ? 'selected' : ''; ?>>Operator</option>
                    </select>
                </div>
                <button type="submit" name="ubah_user" class="btn btn-primary">Simpan Perubahan</button>
                <a href="users.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include_once('templates/footer.php');
?>