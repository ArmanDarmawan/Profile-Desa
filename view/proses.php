<?php
include "../db/connection.php";

// Initialize variables
$nm_perusahaan = '';
$jenis_usaha = '';
$syarat = '';
$alamat = '';
$daftar = 0; // Default value for pendaftar
$errors = [];
$upload_success = false;
$foto_final_name = NULL; // Store the final name of the uploaded photo

// File upload settings
$target_dir = "../img/upload/"; // Make sure this directory exists and is writable
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
$max_file_size = 1024 * 1024; // 1MB

// Sanitize and validate inputs
if (isset($_POST['nm_usaha'])) {
    $nm_perusahaan = trim($_POST['nm_usaha']);
    if (empty($nm_perusahaan)) {
        $errors[] = "Nama usaha/perusahaan wajib diisi.";
    }
} else {
    $errors[] = "Data nama usaha tidak ditemukan.";
}

if (isset($_POST['jenis_usaha'])) {
    $jenis_usaha = trim($_POST['jenis_usaha']);
    if (empty($jenis_usaha)) {
        $errors[] = "Jenis usaha wajib diisi.";
    }
} else {
    $errors[] = "Data jenis usaha tidak ditemukan.";
}

if (isset($_POST['syarat'])) {
    $syarat = trim($_POST['syarat']);
    if (empty($syarat)) {
        $errors[] = "Syarat dan ketentuan wajib diisi.";
    }
} else {
    $errors[] = "Data syarat tidak ditemukan.";
}

if (isset($_POST['alamat'])) {
    $alamat = trim($_POST['alamat']);
    if (empty($alamat)) {
        $errors[] = "Alamat perusahaan wajib diisi.";
    }
} else {
    $errors[] = "Data alamat tidak ditemukan.";
}

if (isset($_POST['daftar'])) {
    $daftar = (int)$_POST['daftar']; // Ensure it's an integer
}

// Handle file upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
    $foto_tmp_name = $_FILES['foto']['tmp_name'];
    $foto_name = basename($_FILES['foto']['name']);
    $foto_size = $_FILES['foto']['size'];
    $foto_type = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));

    // Generate a unique name for the file to prevent overwriting
    $foto_final_name = uniqid('loker_', true) . '.' . $foto_type;
    $target_file = $target_dir . $foto_final_name;

    if (!in_array($foto_type, $allowed_types)) {
        $errors[] = "Format file foto tidak valid. Hanya JPG, JPEG, PNG, GIF yang diizinkan.";
    } elseif ($foto_size > $max_file_size) {
        $errors[] = "Ukuran file foto terlalu besar. Maksimal 1MB.";
    } else {
        if (move_uploaded_file($foto_tmp_name, $target_file)) {
            $upload_success = true;
        } else {
            $errors[] = "Gagal mengupload file foto. Periksa izin folder.";
        }
    }
} elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] != UPLOAD_ERR_NO_FILE) {
    // Handle other upload errors
    $errors[] = "Terjadi kesalahan saat mengupload foto: " . $_FILES['foto']['error'];
}


// If there are validation errors (excluding file not provided if optional), redirect back
if (!empty($errors)) {
    $error_message = implode("<br>", $errors);
    header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode($error_message));
    exit;
}

// Escape data for database insertion
$nm_perusahaan_db = mysqli_real_escape_string($connection, $nm_perusahaan);
$jenis_usaha_db = mysqli_real_escape_string($connection, $jenis_usaha);
$syarat_db = mysqli_real_escape_string($connection, $syarat);
$alamat_db = mysqli_real_escape_string($connection, $alamat);
// $foto_final_name is already safe or NULL

$tgl = date('d');
$bln = date('M'); // e.g., Jan, Feb

// Proses simpan ke Database
$query = "INSERT INTO loker(nm_perusahaan, jenis_usaha, syarat, alamat, foto, tgl, bln, pendaftar) 
          VALUES('$nm_perusahaan_db', '$jenis_usaha_db', '$syarat_db', '$alamat_db', ".($foto_final_name ? "'$foto_final_name'" : "NULL").", '$tgl', '$bln', '$daftar')";
$sql = mysqli_query($connection, $query);

if ($sql) {
    header("Location: loker.php?status_loker=sukses&msg_loker=" . urlencode("Lowongan pekerjaan berhasil ditambahkan."));
    exit;
} else {
    // If DB insert fails, and a file was uploaded, attempt to delete the uploaded file
    if ($upload_success && $foto_final_name && file_exists($target_dir . $foto_final_name)) {
        unlink($target_dir . $foto_final_name);
    }
    $db_error = mysqli_error($connection);
    header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode("Gagal menyimpan data ke database. Silakan coba lagi. Error: " . $db_error));
    exit;
}
?>
