<?php
$koneksi = mysqli_connect("localhost", "root", "", "app_bukutamu");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>