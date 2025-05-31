<?php
include '../db/connection.php'; //

// Cek sesi admin jika ada
// session_start();
// if(!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }

if (isset($_GET['id'])) {
    $id_loker = (int)$_GET['id'];

    // Ambil nama file foto untuk dihapus dari server
    $query_foto = "SELECT foto FROM loker WHERE id = '$id_loker'";
    $result_foto = mysqli_query($connection, $query_foto);
    if ($row_foto = mysqli_fetch_assoc($result_foto)) {
        $nama_foto = $row_foto['foto'];
        if (!empty($nama_foto) && file_exists("../img/upload/" . $nama_foto)) {
            unlink("../img/upload/" . $nama_foto);
        }
    }

    // Hapus juga pendaftar yang terkait dengan loker ini
    $query_delete_pendaftar = "DELETE FROM pendaftar WHERE id_loker = '$id_loker'";
    mysqli_query($connection, $query_delete_pendaftar);


    $query_delete_loker = "DELETE FROM loker WHERE id = '$id_loker'";
    $sql_delete = mysqli_query($connection, $query_delete_loker);

    if ($sql_delete) {
        header("Location: manage_loker.php?status=sukses_hapus");
    } else {
        header("Location: manage_loker.php?status=gagal_hapus&error=" . mysqli_error($connection));
    }
} else {
    header("Location: manage_loker.php?status=id_tidak_ada");
}
exit;
?>