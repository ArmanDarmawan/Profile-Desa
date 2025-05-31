<?php
include "../db/connection.php";

// Initialize variables
$from_email = '';
$nama = '';
$subject = '';
$pesan_form = '';
$errors = [];

// Sanitize and validate inputs
if (isset($_POST['email'])) {
    $from_email = trim($_POST['email']);
    if (empty($from_email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($from_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
} else {
    $errors[] = "Email tidak ditemukan.";
}

if (isset($_POST['nama'])) {
    $nama = trim($_POST['nama']);
    if (empty($nama)) {
        $errors[] = "Nama wajib diisi.";
    }
} else {
    $errors[] = "Nama tidak ditemukan.";
}

if (isset($_POST['subject'])) {
    $subject = trim($_POST['subject']);
    if (empty($subject)) {
        $errors[] = "Subjek wajib diisi.";
    }
} else {
    $errors[] = "Subjek tidak ditemukan.";
}

if (isset($_POST['pesan'])) {
    $pesan_form = trim($_POST['pesan']);
    if (empty($pesan_form)) {
        $errors[] = "Pesan wajib diisi.";
    }
} else {
    $errors[] = "Pesan tidak ditemukan.";
}

// If there are validation errors, redirect back with an error message
if (!empty($errors)) {
    $error_message = implode("<br>", $errors);
    header("Location: hubungi.php?status_hubungi=gagal&msg_hubungi=" . urlencode($error_message));
    exit;
}

// Escape data for database insertion
$nama_db = mysqli_real_escape_string($connection, $nama);
$from_email_db = mysqli_real_escape_string($connection, $from_email);
$subject_db = mysqli_real_escape_string($connection, $subject);
$pesan_form_db = mysqli_real_escape_string($connection, $pesan_form);

// Simpan ke database
$sql_insert = "INSERT INTO pesan_masuk (nama, email, subjek, pesan, tanggal_kirim) VALUES ('$nama_db', '$from_email_db', '$subject_db', '$pesan_form_db', NOW())";
$query_insert = mysqli_query($connection, $sql_insert);

if ($query_insert) {
    // Optionally, try to send an email
    // Note: mail() function might not work on all servers without configuration.
    // Consider using a library like PHPMailer for more reliable email sending.
    $to = "kontak@desacikondang.id"; // Email tujuan
    
    $headers = "From: " . $nama . " <" . $from_email . ">\r\n"; // Show sender's name and email
    $headers .= "Reply-To: ". $from_email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Use UTF-8

    $email_subject = "Pesan Baru dari Website Desa Cikondang: " . htmlspecialchars($subject);

    // Construct HTML body for the email
    $body = "<!DOCTYPE html><html lang='id'><head><meta charset='UTF-8'><title>Pesan dari Website Desa Cikondang</title>";
    $body .= "<style> body { font-family: Arial, sans-serif; line-height: 1.6;} table { width: 100%; border-collapse: collapse; } th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd;} th { background-color: #f2f2f2;} </style></head><body>";
    $body .= "<h2>Pesan Baru dari Website Desa Cikondang</h2>";
    $body .= "<table>";
    $body .= "<tr><th>Nama Pengirim:</th><td>" . htmlspecialchars($nama) . "</td></tr>";
    $body .= "<tr><th>Email Pengirim:</th><td>" . htmlspecialchars($from_email) . "</td></tr>";
    $body .= "<tr><th>Subjek:</th><td>" . htmlspecialchars($subject) . "</td></tr>";
    $body .= "<tr><th>Pesan:</th><td>" . nl2br(htmlspecialchars($pesan_form)) . "</td></tr>";
    $body .= "</table>";
    $body .= "<hr><p><small>Email ini dikirim dari formulir kontak di website Desa Cikondang.</small></p>";
    $body .= "</body></html>";

    // Suppress errors from mail() if it fails, as DB insert was successful
    // @mail($to, $email_subject, $body, $headers); 
    // For testing, you can assume mail sending is successful or log its status.

    // Redirect with success message
    header("Location: hubungi.php?status_hubungi=sukses&msg_hubungi=" . urlencode("Pesan Anda telah berhasil dikirim dan disimpan. Terima kasih!"));
    exit;
} else {
    // Redirect with database error message
    $db_error = mysqli_error($connection);
    header("Location: hubungi.php?status_hubungi=gagal&msg_hubungi=" . urlencode("Gagal menyimpan pesan ke database. Silakan coba lagi. Error: " . $db_error));
    exit;
}
?>
