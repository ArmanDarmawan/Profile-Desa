<?php
include '../db/connection.php';

// Pengecekan sesi admin (diasumsikan sudah ada di header.php atau perlu ditambahkan jika file ini diakses langsung)
/*
session_start(); 
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // header("Location: login.php"); // Atau kirim response error jika API
    // exit;
    // die(json_encode(['status' => 'error', 'message' => 'Akses ditolak']));
}
*/

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if ($aksi == 'tambah') {
    if (isset($_POST['pertanyaan'], $_POST['jawaban'], $_POST['urutan'])) {
        $pertanyaan = mysqli_real_escape_string($connection, $_POST['pertanyaan']);
        // Untuk jawaban, kita mungkin ingin mengizinkan beberapa HTML dasar. 
        // Jika tidak, gunakan strip_tags atau htmlentities saat menampilkan, atau sanitasi lebih ketat di sini.
        // Untuk saat ini, kita asumsikan mysqli_real_escape_string cukup untuk mencegah SQL Injection.
        // Pembersihan HTML lebih lanjut bisa dilakukan dengan library seperti HTML Purifier jika diperlukan.
        $jawaban = mysqli_real_escape_string($connection, $_POST['jawaban']); 
        $urutan = (int)$_POST['urutan'];

        if (empty($pertanyaan) || empty($jawaban)) {
            header("Location: manage_faq.php?status=gagal_tambah&error=" . urlencode("Pertanyaan dan jawaban tidak boleh kosong."));
            exit;
        }

        $query = "INSERT INTO faq (pertanyaan, jawaban, urutan) VALUES ('$pertanyaan', '$jawaban', '$urutan')";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            header("Location: manage_faq.php?status=sukses_tambah");
        } else {
            header("Location: manage_faq.php?status=gagal_tambah&error=" . urlencode(mysqli_error($connection)));
        }
    } else {
        header("Location: manage_faq.php?status=gagal_tambah&error=" . urlencode("Data tidak lengkap."));
    }
    exit;

} elseif ($aksi == 'edit') {
    if (isset($_POST['id_faq'], $_POST['pertanyaan'], $_POST['jawaban'], $_POST['urutan'])) {
        $id_faq = (int)$_POST['id_faq'];
        $pertanyaan = mysqli_real_escape_string($connection, $_POST['pertanyaan']);
        $jawaban = mysqli_real_escape_string($connection, $_POST['jawaban']);
        $urutan = (int)$_POST['urutan'];

        if (empty($pertanyaan) || empty($jawaban)) {
            header("Location: manage_faq.php?status=gagal_edit&error=" . urlencode("Pertanyaan dan jawaban tidak boleh kosong."));
            exit;
        }
        if ($id_faq <= 0) {
            header("Location: manage_faq.php?status=gagal_edit&error=" . urlencode("ID FAQ tidak valid."));
            exit;
        }

        $query = "UPDATE faq SET 
                    pertanyaan='$pertanyaan', 
                    jawaban='$jawaban', 
                    urutan='$urutan' 
                  WHERE id='$id_faq'";

        $sql = mysqli_query($connection, $query);
        if ($sql) {
            if (mysqli_affected_rows($connection) > 0) {
                header("Location: manage_faq.php?status=sukses_edit");
            } else {
                // Tidak ada baris yang terpengaruh, bisa jadi data sama atau ID tidak ditemukan
                // Cek apakah ID ada
                $check_id_query = mysqli_query($connection, "SELECT id FROM faq WHERE id='$id_faq'");
                if (mysqli_num_rows($check_id_query) > 0) {
                    header("Location: manage_faq.php?status=sukses_edit&info=" . urlencode("Tidak ada perubahan data."));
                } else {
                    header("Location: manage_faq.php?status=gagal_edit&error=" . urlencode("ID FAQ tidak ditemukan."));
                }
            }
        } else {
            header("Location: manage_faq.php?status=gagal_edit&error=" . urlencode(mysqli_error($connection)));
        }
    } else {
        header("Location: manage_faq.php?status=gagal_edit&error=" . urlencode("Data tidak lengkap."));
    }
    exit;

} elseif ($aksi == 'hapus') {
    if (isset($_GET['id'])) {
        $id_faq = (int)$_GET['id'];
        if ($id_faq <= 0) {
            header("Location: manage_faq.php?status=gagal_hapus&error=" . urlencode("ID FAQ tidak valid."));
            exit;
        }

        $query = "DELETE FROM faq WHERE id = '$id_faq'";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            if (mysqli_affected_rows($connection) > 0) {
                header("Location: manage_faq.php?status=sukses_hapus");
            } else {
                header("Location: manage_faq.php?status=gagal_hapus&error=" . urlencode("ID FAQ tidak ditemukan atau sudah dihapus."));
            }
        } else {
            header("Location: manage_faq.php?status=gagal_hapus&error=" . urlencode(mysqli_error($connection)));
        }
    } else {
        header("Location: manage_faq.php?status=id_tidak_ada");
    }
    exit;
} else {
    // Jika aksi tidak dikenali
    header("Location: manage_faq.php?status=aksi_tidak_valid");
    exit;
}
?>
