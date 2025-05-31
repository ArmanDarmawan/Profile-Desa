<?php
include '../db/connection.php'; 

// Cek sesi admin jika ada (pastikan session_start() ada di header.php atau di sini jika header tidak selalu di-include)
// Jika header.php sudah memanggil session_start() dan melakukan pengecekan sesi, tidak perlu diulang di sini.
// Namun, jika file ini bisa diakses langsung, pengecekan sesi penting.
/*
session_start(); 
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect atau kirim error jika tidak terautentikasi
    // header("Location: login.php");
    // exit;
    // Atau jika ini adalah API endpoint, kirim response error
    // die(json_encode(['status' => 'error', 'message' => 'Akses ditolak'])); 
}
*/

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
$upload_dir = "../img/upload/"; // Direktori upload

// Pastikan direktori upload ada dan bisa ditulis
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0775, true);
}

if ($aksi == 'tambah') {
    $nm_perusahaan = mysqli_real_escape_string($connection, $_POST['nm_perusahaan']);
    $jenis_usaha = mysqli_real_escape_string($connection, $_POST['jenis_usaha']);
    $syarat = mysqli_real_escape_string($connection, $_POST['syarat']);
    $alamat = mysqli_real_escape_string($connection, $_POST['alamat']);
    $pendaftar = 0; // Pendaftar default 0 untuk loker baru
    $tgl = date('d'); // Tanggal saat ini
    $bln = date('M'); // Bulan saat ini (misal: May)

    $path_db = ''; // Nama file foto untuk disimpan di database

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];
        $foto_type = $_FILES['foto']['type'];
        $file_ext_arr = explode('.', $foto_name);
        $foto_ext = strtolower(end($file_ext_arr));
        
        // Nama file unik untuk menghindari penimpaan
        $path_db = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($foto_name));
        $target_file = $upload_dir . $path_db;

        $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
        $allowed_ext = array('jpg', 'jpeg', 'png');

        if (in_array($foto_type, $allowed_types) && in_array($foto_ext, $allowed_ext)) {
            if ($foto_size <= 2000000) { // Max 2MB (2 * 1024 * 1024)
                if (move_uploaded_file($foto_tmp_name, $target_file)) {
                    // File berhasil diupload
                } else {
                    header("Location: manage_loker.php?status=gagal_upload&error=" . urlencode("Gagal memindahkan file yang diupload."));
                    exit;
                }
            } else {
                header("Location: manage_loker.php?status=gagal_ukuran&error=" . urlencode("Ukuran file terlalu besar."));
                exit;
            }
        } else {
            header("Location: manage_loker.php?status=gagal_tipe&error=" . urlencode("Tipe file tidak diizinkan."));
            exit;
        }
    } else if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
        // Ada error lain saat upload selain tidak ada file yang dipilih
        $upload_error_message = "Error upload file: " . (isset($_FILES['foto']['error']) ? $_FILES['foto']['error'] : 'Tidak diketahui');
        header("Location: manage_loker.php?status=gagal_upload&error=" . urlencode($upload_error_message));
        exit;
    }
    // Jika tidak ada file foto yang diupload, $path_db akan kosong, dan kolom foto di DB juga akan kosong.

    $query = "INSERT INTO loker (nm_perusahaan, jenis_usaha, syarat, alamat, foto, tgl, bln, pendaftar) 
              VALUES ('$nm_perusahaan', '$jenis_usaha', '$syarat', '$alamat', '$path_db', '$tgl', '$bln', '$pendaftar')";
    $sql = mysqli_query($connection, $query);

    if ($sql) {
        header("Location: manage_loker.php?status=sukses_tambah");
    } else {
        // Jika query gagal, hapus file yang mungkin sudah terupload
        if (!empty($path_db) && file_exists($upload_dir . $path_db)) {
            unlink($upload_dir . $path_db);
        }
        header("Location: manage_loker.php?status=gagal_tambah&error=" . urlencode(mysqli_error($connection)));
    }
    exit;

} elseif ($aksi == 'edit') {
    $id_loker = (int)$_POST['id_loker'];
    $nm_perusahaan = mysqli_real_escape_string($connection, $_POST['nm_perusahaan']);
    $jenis_usaha = mysqli_real_escape_string($connection, $_POST['jenis_usaha']);
    $syarat = mysqli_real_escape_string($connection, $_POST['syarat']);
    $alamat = mysqli_real_escape_string($connection, $_POST['alamat']);

    // Ambil nama foto lama dari database
    $query_foto_lama = mysqli_query($connection, "SELECT foto FROM loker WHERE id='$id_loker'");
    if (!$query_foto_lama || mysqli_num_rows($query_foto_lama) == 0) {
        header("Location: manage_loker.php?status=id_tidak_ada&error=" . urlencode("Loker tidak ditemukan."));
        exit;
    }
    $data_foto_lama = mysqli_fetch_assoc($query_foto_lama);
    $path_db = $data_foto_lama['foto']; // Default menggunakan foto lama

    // Cek apakah ada file foto baru yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK && !empty($_FILES['foto']['name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];
        $foto_type = $_FILES['foto']['type'];
        $file_ext_arr = explode('.', $foto_name);
        $foto_ext = strtolower(end($file_ext_arr));

        $new_foto_filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($foto_name));
        $target_file_new = $upload_dir . $new_foto_filename;

        $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
        $allowed_ext = array('jpg', 'jpeg', 'png');

        if (in_array($foto_type, $allowed_types) && in_array($foto_ext, $allowed_ext)) {
            if ($foto_size <= 2000000) { // Max 2MB
                if (move_uploaded_file($foto_tmp_name, $target_file_new)) {
                    // Hapus foto lama jika ada dan berbeda dengan foto baru
                    if (!empty($path_db) && file_exists($upload_dir . $path_db) && $path_db != $new_foto_filename) {
                        unlink($upload_dir . $path_db);
                    }
                    $path_db = $new_foto_filename; // Update nama file foto di database dengan yang baru
                } else {
                    header("Location: manage_loker.php?status=gagal_upload_edit&error=" . urlencode("Gagal memindahkan file baru."));
                    exit;
                }
            } else {
                header("Location: manage_loker.php?status=gagal_ukuran_edit&error=" . urlencode("Ukuran file baru terlalu besar."));
                exit;
            }
        } else {
            header("Location: manage_loker.php?status=gagal_tipe_edit&error=" . urlencode("Tipe file baru tidak diizinkan."));
            exit;
        }
    } else if (isset($_FILES['foto']) && $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE && $_FILES['foto']['error'] != UPLOAD_ERR_OK) {
        // Ada error lain saat upload selain tidak ada file yang dipilih
        $upload_error_message = "Error upload file: " . $_FILES['foto']['error'];
        header("Location: manage_loker.php?status=gagal_upload_edit&error=" . urlencode($upload_error_message));
        exit;
    }
    // Jika tidak ada file baru diupload, $path_db akan tetap berisi nama foto lama.

    $query_update = "UPDATE loker SET 
                        nm_perusahaan='$nm_perusahaan', 
                        jenis_usaha='$jenis_usaha', 
                        syarat='$syarat', 
                        alamat='$alamat', 
                        foto='$path_db' 
                     WHERE id='$id_loker'";

    $sql_update = mysqli_query($connection, $query_update);
    if ($sql_update) {
        header("Location: manage_loker.php?status=sukses_edit");
    } else {
        // Jika query gagal, dan foto baru sudah terupload, hapus foto baru tersebut untuk konsistensi
        if (isset($new_foto_filename) && file_exists($upload_dir . $new_foto_filename) && $new_foto_filename != $data_foto_lama['foto']) {
             unlink($upload_dir . $new_foto_filename);
        }
        header("Location: manage_loker.php?status=gagal_edit&error=" . urlencode(mysqli_error($connection)));
    }
    exit;

} else {
    // Jika aksi tidak dikenali
    header("Location: manage_loker.php?status=aksi_tidak_valid");
    exit;
}
?>
