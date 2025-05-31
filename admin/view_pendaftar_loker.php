<?php 
include 'template/header.php'; 
include '../db/connection.php'; //

if (!isset($_GET['id_loker'])) {
    echo "<p class='alert alert-danger'>ID Loker tidak ditemukan.</p>";
    include 'template/footer.php';
    exit;
}
$id_loker = (int)$_GET['id_loker'];

// Ambil informasi loker
$sql_info_loker = "SELECT nm_perusahaan, jenis_usaha FROM loker WHERE id = '$id_loker'";
$query_info_loker = mysqli_query($connection, $sql_info_loker);
$info_loker = mysqli_fetch_assoc($query_info_loker);

if (!$info_loker) {
    echo "<p class='alert alert-danger'>Informasi Loker tidak ditemukan.</p>";
    include 'template/footer.php';
    exit;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Pendaftar - <?php echo htmlspecialchars($info_loker['nm_perusahaan']); ?> (<?php echo htmlspecialchars($info_loker['jenis_usaha']); ?>)</h1>
    <a href="manage_loker.php" class="btn btn-sm btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Kelola Loker</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pendaftar</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Tgl Daftar</th>
                <th>Dokumen</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_pendaftar = "SELECT * FROM pendaftar WHERE id_loker = '$id_loker' ORDER BY id DESC";
            $query_pendaftar = mysqli_query($connection, $sql_pendaftar);
            $no = 1;
            if (mysqli_num_rows($query_pendaftar) > 0) {
                while ($row = mysqli_fetch_assoc($query_pendaftar)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_tlp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tgl']) . " " . htmlspecialchars($row['bln']) . "</td>";
                    echo "<td>
                            <a href='../img/upload/" . htmlspecialchars($row['ktp']) . "' target='_blank' class='btn btn-sm btn-info mb-1'><i class='fa fa-id-card'></i> KTP</a><br>
                            <a href='../img/upload/" . htmlspecialchars($row['kk']) . "' target='_blank' class='btn btn-sm btn-info mb-1'><i class='fa fa-users'></i> KK</a><br>
                            <a href='../img/upload/" . htmlspecialchars($row['pengajuan']) . "' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-file-text'></i> Pengajuan</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Belum ada pendaftar untuk lowongan ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'template/footer.php'; ?>