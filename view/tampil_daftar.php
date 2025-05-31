<?php 
include 'template/header.php';
include '../db/connection.php';

$id_loker = 0;
$loker_nama = "Tidak Diketahui";

if (isset($_GET['id'])) {
    $id_loker = (int)$_GET['id'];
    // Ambil nama lowongan untuk judul
    $sql_loker_info = "SELECT nm_perusahaan FROM loker WHERE id = $id_loker";
    $query_loker_info = mysqli_query($connection, $sql_loker_info);
    if ($row_loker = mysqli_fetch_assoc($query_loker_info)) {
        $loker_nama = htmlspecialchars($row_loker['nm_perusahaan']);
    }
} else {
    // Redirect jika ID tidak ada
    header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode("ID Lowongan tidak valid untuk melihat pendaftar."));
    exit;
}
 ?>
         
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area white-bg">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="logo-img">
                                <a href="../index.php">
                                    <img src="../img/logo.png" alt="Logo Desa" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-9 col-sm-8 col-6">
                            <div class="main-menu d-none d-lg-block text-right">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="../index.php">Home</a></li>
                                        <li><a href="galeri.php">Galeri</a></li>
                                        <li><a href="sejarah.php">Sejarah</a></li>
                                        <li><a href="peta.php">Peta Desa</a></li>
                                        <li><a class="active" href="loker.php">Loker</a></li>
                                        <li><a href="../admin/index.php">Dashboard</a></li>
                                        <li><a href="hubungi.php">Hubungi</a></li>
                                        <li><a href="faq.php">FAQ</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col-12 d-lg-none">
                                <div class="mobile_menu"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="breadcrumb breadcrumb_bg banner-bg-1 overlay2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="breadcrumb_iner text-center">
                        <div class="breadcrumb_iner_item">
                            <h2>Daftar Pelamar</h2>
                            <p>Untuk Lowongan: <?php echo $loker_nama; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a href="loker.php" class="btn btn-outline-secondary mb-4"><i class="fa fa-arrow-left"></i> Kembali ke Daftar Lowongan</a>
                    <?php
                    $sql_pendaftar = "SELECT * FROM pendaftar WHERE id_loker = $id_loker ORDER BY tanggal_daftar DESC";
                    $query_pendaftar = mysqli_query($connection, $sql_pendaftar);
                    
                    if (mysqli_num_rows($query_pendaftar) > 0) {
                    ?>
                    <div class="table-responsive shadow-sm">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                while ($row = mysqli_fetch_assoc($query_pendaftar)) {
                                    $ktp_path = "../img/upload/dokumen_pelamar/" . htmlspecialchars($row['ktp']);
                                    $kk_path = "../img/upload/dokumen_pelamar/" . htmlspecialchars($row['kk']);
                                    $pengajuan_path = "../img/upload/dokumen_pelamar/" . htmlspecialchars($row['pengajuan']);
                                ?>
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['no_tlp']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($row['alamat'])); ?></td>
                                    <td><?php echo htmlspecialchars(date('d M Y, H:i', strtotime($row['tanggal_daftar']))); ?></td>
                                    <td>
                                        <?php if (!empty($row['ktp']) && file_exists($ktp_path)): ?>
                                            <a href="<?php echo $ktp_path; ?>" target="_blank" class="btn btn-sm btn-outline-primary mb-1 d-block" title="Lihat KTP">KTP</a>
                                        <?php else: ?>
                                            <span class="text-muted d-block">KTP T/A</span>
                                        <?php endif; ?>

                                        <?php if (!empty($row['kk']) && file_exists($kk_path)): ?>
                                            <a href="<?php echo $kk_path; ?>" target="_blank" class="btn btn-sm btn-outline-primary mb-1 d-block" title="Lihat KK">KK</a>
                                        <?php else: ?>
                                            <span class="text-muted d-block">KK T/A</span>
                                        <?php endif; ?>

                                        <?php if (!empty($row['pengajuan']) && file_exists($pengajuan_path)): ?>
                                            <a href="<?php echo $pengajuan_path; ?>" target="_blank" class="btn btn-sm btn-outline-primary d-block" title="Lihat Surat Pengajuan">Lamaran</a>
                                        <?php else: ?>
                                            <span class="text-muted d-block">Lamaran T/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php 
                                } // end while
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    } else { // Jika tidak ada pendaftar
                    ?>
                    <div class="alert alert-info text-center" role="alert">
                        Belum ada pelamar untuk lowongan ini.
                    </div>
                    <?php
                    } 
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php 
include 'template/footer.php';
?>
