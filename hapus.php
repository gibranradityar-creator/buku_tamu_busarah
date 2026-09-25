<?php
require_once('function.php');

// Mengambil id dari URL
$id = $_GET['id'];

if (hapus($id) > 0) {
    echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'buku-tamu.php';
          </script>";
} else {
    echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'buku-tamu.php';
          </script>";
}
?>