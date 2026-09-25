<?php
require_once('koneksi.php');

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// ==========================================
// FUNGSI UNTUK UPLOAD GAMBAR
// ==========================================
function uploadGambar() {
    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error      = $_FILES['gambar']['error'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    // Cek apakah tidak ada gambar yang diunggah
    if ($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    // Cek ekstensi file
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar      = explode('.', $namaFile);
    $ekstensiGambar      = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File yang diunggah harus gambar!');
              </script>";
        return false;
    }

    // Cek ukuran file (maksimal 1MB)
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
              </script>";
        return false;
    }

    // Generate nama gambar baru
    $namaFileBaru  = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Pindahkan file ke folder upload_gambar
    move_uploaded_file($tmpName, 'assets/upload_gambar/' . $namaFileBaru);

    return $namaFileBaru;
}

// ==========================================
// FUNGSI UNTUK BUKU TAMU
// ==========================================

// Fungsi untuk menambah data buku tamu
function tambah($data) {
    global $koneksi;

    $id_tamu     = htmlspecialchars($data['id_tamu']);
    $tanggal     = date("Y-m-d");
    $nama_tamu   = htmlspecialchars($data['nama_tamu']);
    $alamat      = htmlspecialchars($data['alamat']);
    $no_hp       = htmlspecialchars($data['no_hp']);
    $bertemu     = htmlspecialchars($data['bertemu']);
    $kepentingan = htmlspecialchars($data['kepentingan']);

    // Proses upload gambar
    $gambar = uploadGambar();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO buku_tamu VALUES ('$id_tamu', '$tanggal', '$nama_tamu', '$alamat', '$no_hp', '$bertemu', '$kepentingan', '$gambar')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk menghapus data buku tamu
function hapus($id) {
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM buku_tamu WHERE id_tamu = '$id'");
    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk mengubah/edit data buku tamu (SUDAH DIPERBARUI)
function ubah($data) {
    global $koneksi;

    $id_tamu     = htmlspecialchars($data['id_tamu']);
    $nama_tamu   = htmlspecialchars($data['nama_tamu']);
    $alamat      = htmlspecialchars($data['alamat']);
    $no_hp       = htmlspecialchars($data['no_hp']);
    $bertemu     = htmlspecialchars($data['bertemu']);
    $kepentingan = htmlspecialchars($data['kepentingan']);
    $gambarLama  = htmlspecialchars($data['gambarLama']);

    // Cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = uploadGambar();
    }

    $query = "UPDATE buku_tamu SET
                nama_tamu   = '$nama_tamu',
                alamat      = '$alamat',
                no_hp       = '$no_hp',
                bertemu     = '$bertemu',
                kepentingan = '$kepentingan',
                gambar      = '$gambar'
              WHERE id_tamu = '$id_tamu'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// ==========================================
// FUNGSI UNTUK USER
// ==========================================

// Fungsi untuk menambah data user baru
function tambah_user($data) {
    global $koneksi;

    $id_user   = htmlspecialchars($data['id_user']);
    $username  = htmlspecialchars($data['username']);
    $password  = password_hash($data['password'], PASSWORD_DEFAULT);
    $user_role = htmlspecialchars($data['user_role']);

    $query = "INSERT INTO users VALUES ('$id_user', '$username', '$password', '$user_role')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk menghapus data user
function hapus_user($id) {
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id'");
    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk mengubah/edit data user
function ubah_user($data) {
    global $koneksi;

    $id_user   = htmlspecialchars($data['id_user']);
    $username  = htmlspecialchars($data['username']);
    $user_role = htmlspecialchars($data['user_role']);

    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET
                    username  = '$username',
                    password  = '$password',
                    user_role = '$user_role'
                  WHERE id_user = '$id_user'";
    } else {
        $query = "UPDATE users SET
                    username  = '$username',
                    user_role = '$user_role'
                  WHERE id_user = '$id_user'";
    }

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
?>