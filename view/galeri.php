<?php 
include 'template/header.php';
include '../db/connection.php'; 
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
                                        <li><a class="active" href="galeri.php">Galeri</a></li>
                                        <li><a href="sejarah.php">Sejarah</a></li>
                                        <li><a href="peta.php">Peta Desa</a></li>
                                        <li><a href="loker.php">Loker</a></li>
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
                            <h2>Galeri Desa Cikondang</h2>
                            <p>Dokumentasi kegiatan dan suasana Desa Cikondang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="main-project-area section-padding">
        <div class="container">
            <div class="row">
                <?php
                $sql_galeri = "SELECT * FROM galeri ORDER BY tanggal_upload DESC";
                $query_galeri = mysqli_query($connection, $sql_galeri);
                if (mysqli_num_rows($query_galeri) > 0) {
                    while ($item = mysqli_fetch_assoc($query_galeri)) {
                        $image_path = "../img/upload/galeri/" . htmlspecialchars($item['nama_file']);
                        $keterangan = htmlspecialchars($item['keterangan']);
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-project card shadow-sm">
                        <div class="project-thumb">
                            <a href="<?php echo $image_path; ?>" class="popup-image d-block" title="<?php echo $keterangan; ?>">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo $keterangan; ?>" class="img-fluid" style="height: 250px; width:100%; object-fit: cover;">
                            </a>
                        </div>
                        <?php if (!empty($keterangan)): ?>
                        <div class="project-info p-3">
                            <p class="mb-0 small text-muted"><?php echo nl2br($keterangan); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<div class='col-12'><div class='alert alert-info text-center'>Belum ada gambar di galeri saat ini.</div></div>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php 
include 'template/footer.php';
?>
