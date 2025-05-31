<?php
include '../db/connection.php';

// Pengecekan sesi admin (diasumsikan sudah ada di header.php)
/*
session_start(); 
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // header("Location: login.php"); 
    // exit;
    // die(json_encode(['status' => 'error', 'message' => 'Akses ditolak']));
}
*/

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
$upload_dir_relative = '../img/upload/galeri/'; 
// Membuat path absolut dengan lebih aman
$upload_dir_absolute = rtrim(realpath(dirname(__FILE__) . '/' . $upload_dir_relative), '/') . '/';


// Pastikan direktori upload ada dan bisa ditulis
if (!is_dir($upload_dir_absolute)) {
    if (!mkdir($upload_dir_absolute, 0775, true)) {
        // Gagal membuat direktori, redirect dengan error
        header("Location: manage_galeri.php?status=gagal_upload&error=" . urlencode("Gagal membuat direktori upload. Periksa izin folder."));
        exit;
    }
}


if ($aksi == 'unggah') {
    if (isset($_FILES['gambar_galeri']) && $_FILES['gambar_galeri']['error'] == UPLOAD_ERR_OK) {
        $keterangan = isset($_POST['keterangan_galeri']) ? mysqli_real_escape_string($connection, $_POST['keterangan_galeri']) : '';

        $original_file_name = $_FILES['gambar_galeri']['name'];
        $file_tmp_name = $_FILES['gambar_galeri']['tmp_name'];
        $file_size = $_FILES['gambar_galeri']['size'];
        $file_type = $_FILES['gambar_galeri']['type']; // Tipe MIME dari file
        $file_ext_arr = explode('.', $original_file_name);
        $file_ext = strtolower(end($file_ext_arr));

        // Nama file unik untuk menghindari penimpaan dan membersihkan nama file
        $safe_original_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", basename($original_file_name));
        $file_name_db = time() . '_' . $safe_original_name;
        $target_file_path = $upload_dir_absolute . $file_name_db;

        $allowed_mime_types = array('image/jpeg', 'image/png', 'image/jpg');
        $allowed_extensions = array('jpg', 'jpeg', 'png');

        if (!in_array($file_type, $allowed_mime_types) || !in_array($file_ext, $allowed_extensions)) {
            header("Location: manage_galeri.php?status=tipe_salah");
            exit;
        }

        if ($file_size > 2097152) { // Maks 2MB (2 * 1024 * 1024 bytes)
            header("Location: manage_galeri.php?status=ukuran_besar");
            exit;
        }

        if (move_uploaded_file($file_tmp_name, $target_file_path)) {
            $query = "INSERT INTO galeri (nama_file, keterangan, tanggal_upload) VALUES ('$file_name_db', '$keterangan', NOW())";
            $sql = mysqli_query($connection, $query);
            if ($sql) {
                header("Location: manage_galeri.php?status=sukses_upload");
            } else {
                unlink($target_file_path); // Hapus file jika query ke database gagal
                header("Location: manage_galeri.php?status=gagal_db&error=" . urlencode(mysqli_error($connection)));
            }
        } else {
            // Error saat memindahkan file
            $php_upload_errors = array(
                UPLOAD_ERR_INI_SIZE   => "File melebihi upload_max_filesize di php.ini.",
                UPLOAD_ERR_FORM_SIZE  => "File melebihi MAX_FILE_SIZE pada form HTML.",
                UPLOAD_ERR_PARTIAL    => "File hanya terupload sebagian.",
                UPLOAD_ERR_NO_TMP_DIR => "Tidak ada folder temporary.",
                UPLOAD_ERR_CANT_WRITE => "Gagal menulis file ke disk.",
                UPLOAD_ERR_EXTENSION  => "Ekstensi PHP menghentikan upload file.",
            );
            $error_message = isset($php_upload_errors[$_FILES['gambar_galeri']['error']]) ? $php_upload_errors[$_FILES['gambar_galeri']['error']] : "Gagal memindahkan file yang diupload.";
            header("Location: manage_galeri.php?status=gagal_upload&error=" . urlencode($error_message));
        }
    } else {
        $error_code = isset($_FILES['gambar_galeri']['error']) ? $_FILES['gambar_galeri']['error'] : UPLOAD_ERR_NO_FILE;
        if ($error_code == UPLOAD_ERR_NO_FILE) {
             header("Location: manage_galeri.php?status=file_tidak_ada_atau_error&error=" . urlencode("Tidak ada file yang dipilih."));
        } else {
             header("Location: manage_galeri.php?status=file_tidak_ada_atau_error&error=" . urlencode("Error upload: code " . $error_code));
        }
    }
    exit;

} elseif ($aksi == 'hapus') {
    if (isset($_GET['id']) && isset($_GET['file'])) {
        $id_galeri = (int)$_GET['id'];
        $nama_file_url = $_GET['file']; 
        $nama_file_db = urldecode($nama_file_url); // Decode nama file dari URL

        if ($id_galeri <= 0 || empty($nama_file_db)) {
             header("Location: manage_galeri.php?status=id_file_hilang&error=" . urlencode("ID atau nama file tidak valid."));
             exit;
        }

        $file_to_delete_path = $upload_dir_absolute . $nama_file_db;

        // Hapus dari database terlebih dahulu
        $query = "DELETE FROM galeri WHERE id = '$id_galeri' AND nama_file = '".mysqli_real_escape_string($connection, $nama_file_db)."'";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            if (mysqli_affected_rows($connection) > 0) {
                // Jika berhasil dihapus dari DB, hapus file fisik
                if (file_exists($file_to_delete_path)) {
                    if (!unlink($file_to_delete_path)) {
                        // Gagal hapus file fisik, tapi data DB sudah terhapus
                        header("Location: manage_galeri.php?status=sukses_hapus&info=" . urlencode("Data DB terhapus, namun file fisik gagal dihapus. Periksa izin folder."));
                        exit;
                    }
                }
                header("Location: manage_galeri.php?status=sukses_hapus");
            } else {
                // Tidak ada baris yang terpengaruh di DB (mungkin ID atau nama file tidak cocok)
                header("Location: manage_galeri.php?status=gagal_hapus&error=" . urlencode("Data tidak ditemukan di database atau sudah dihapus."));
            }
        } else {
            header("Location: manage_galeri.php?status=gagal_hapus&error=" . urlencode(mysqli_error($connection)));
        }
    } else {
        header("Location: manage_galeri.php?status=id_file_hilang");
    }
    exit;
} else {
    // Jika aksi tidak dikenali
    header("Location: manage_galeri.php?status=aksi_tidak_valid");
    exit;
}
?>
