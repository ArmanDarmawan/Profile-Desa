<?php
include "../db/connection.php";

$id_loker = 0;
if (isset($_GET["id"])) {
    $id_loker = (int)$_GET["id"];
} else {
    // Redirect if no ID Loker is provided in URL
    header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode("Akses tidak valid. ID Lowongan tidak ditemukan."));
    exit;
}

// Initialize variables
$nama = '';
$email = '';
$no_tlp = '';
$alamat = '';
$errors = [];
$uploaded_files = []; // To keep track of successfully uploaded files for potential rollback

// File upload settings
$target_dir = "../img/upload/dokumen_pelamar/"; // Create this directory if it doesn't exist and make it writable
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}
$allowed_doc_types = ['pdf', 'jpg', 'jpeg', 'png'];
$max_doc_size = 1024 * 1024; // 1MB

// --- Input Validation and Sanitization ---
if (isset($_POST['nama'])) {
    $nama = trim($_POST['nama']);
    if (empty($nama)) $errors[] = "Nama lengkap wajib diisi.";
} else { $errors[] = "Data nama tidak ditemukan."; }

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (empty($email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
} else { $errors[] = "Data email tidak ditemukan."; }

if (isset($_POST['no_tlp'])) {
    $no_tlp = trim($_POST['no_tlp']);
    if (empty($no_tlp)) {
        $errors[] = "Nomor telepon wajib diisi.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $no_tlp)) {
        $errors[] = "Format nomor telepon tidak valid (10-15 digit angka).";
    }
} else { $errors[] = "Data nomor telepon tidak ditemukan."; }

if (isset($_POST['alamat'])) {
    $alamat = trim($_POST['alamat']);
    if (empty($alamat)) $errors[] = "Alamat wajib diisi.";
} else { $errors[] = "Data alamat tidak ditemukan."; }

// --- File Upload Handling Function ---
function handle_upload($file_key, $target_dir, $allowed_types, $max_size, &$errors_array, &$uploaded_files_array) {
    if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES[$file_key]['tmp_name'];
        $file_name = basename($_FILES[$file_key]['name']);
        $file_size = $_FILES[$file_key]['size'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $file_final_name = uniqid($file_key . '_', true) . '.' . $file_type;
        $target_file = $target_dir . $file_final_name;

        if (!in_array($file_type, $allowed_types)) {
            $errors_array[] = "Format file untuk " . ucfirst($file_key) . " tidak valid. Hanya PDF, JPG, PNG yang diizinkan.";
            return null;
        }
        if ($file_size > $max_size) {
            $errors_array[] = "Ukuran file untuk " . ucfirst($file_key) . " terlalu besar. Maksimal 1MB.";
            return null;
        }
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            $uploaded_files_array[$file_key] = $target_file; // Store full path for rollback
            return $file_final_name; // Return just the name for DB
        } else {
            $errors_array[] = "Gagal mengupload file " . ucfirst($file_key) . ".";
            return null;
        }
    } elseif (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == UPLOAD_ERR_NO_FILE) {
        $errors_array[] = ucfirst($file_key) . " wajib diunggah."; // All files are required
        return null;
    } elseif (isset($_FILES[$file_key])) {
        $errors_array[] = "Terjadi kesalahan saat mengupload " . ucfirst($file_key) . ": error code " . $_FILES[$file_key]['error'];
        return null;
    } else {
        $errors_array[] = "File " . ucfirst($file_key) . " tidak ditemukan.";
        return null;
    }
}

$fotoktp_name = handle_upload('ktp', $target_dir, $allowed_doc_types, $max_doc_size, $errors, $uploaded_files);
$fotokk_name = handle_upload('kk', $target_dir, $allowed_doc_types, $max_doc_size, $errors, $uploaded_files);
$foto_pengajuan_name = handle_upload('pengajuan', $target_dir, $allowed_doc_types, $max_doc_size, $errors, $uploaded_files);

// If there are any errors (validation or file upload), redirect back
if (!empty($errors)) {
    // Attempt to delete any files that were successfully uploaded before an error occurred
    foreach ($uploaded_files as $file_path_to_delete) {
        if (file_exists($file_path_to_delete)) {
            unlink($file_path_to_delete);
        }
    }
    $error_message = implode("<br>", $errors);
    header("Location: mendaftar.php?id=" . $id_loker . "&status_daftar=gagal&msg_daftar=" . urlencode($error_message));
    exit;
}

// Escape data for DB
$nama_db = mysqli_real_escape_string($connection, $nama);
$email_db = mysqli_real_escape_string($connection, $email);
$no_tlp_db = mysqli_real_escape_string($connection, $no_tlp);
$alamat_db = mysqli_real_escape_string($connection, $alamat);
// File names are already handled (sanitized by uniqueid and extension)

$tgl_daftar = date('Y-m-d H:i:s'); // Use DATETIME for precision

// Insert into pendaftar table
$query_insert_pendaftar = "INSERT INTO pendaftar (id_loker, nama, email, no_tlp, alamat, ktp, kk, pengajuan, tanggal_daftar) 
                           VALUES ('$id_loker', '$nama_db', '$email_db', '$no_tlp_db', '$alamat_db', '$fotoktp_name', '$fotokk_name', '$foto_pengajuan_name', '$tgl_daftar')";
$sql_insert_pendaftar = mysqli_query($connection, $query_insert_pendaftar);

if ($sql_insert_pendaftar) {
    // Increment pendaftar count in loker table
    $query_update_loker = "UPDATE loker SET pendaftar = pendaftar + 1 WHERE id = '$id_loker'";
    mysqli_query($connection, $query_update_loker); // Execute update, error checking can be added

    header("Location: loker.php?status_loker=sukses&msg_loker=" . urlencode("Lamaran Anda berhasil dikirim untuk lowongan ID: $id_loker. Terima kasih!"));
    exit;
} else {
    // If DB insert fails, attempt to delete uploaded files
    foreach ($uploaded_files as $file_path_to_delete) {
        if (file_exists($file_path_to_delete)) {
            unlink($file_path_to_delete);
        }
    }
    $db_error = mysqli_error($connection);
    header("Location: mendaftar.php?id=" . $id_loker . "&status_daftar=gagal&msg_daftar=" . urlencode("Gagal menyimpan data lamaran. Silakan coba lagi. Error: " . $db_error));
    exit;
}
?>
