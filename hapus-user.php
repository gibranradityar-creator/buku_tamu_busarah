<?php
require_once('function.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (hapus_user($id) > 0) {
        echo "<script>
                alert('Data user berhasil dihapus!');
                document.location.href = 'users.php';
              </script>";
    } else {
        echo "<script>
                alert('Data user gagal dihapus!');
                document.location.href = 'users.php';
              </script>";
    }
} else {
    header("Location: users.php");
}
?>