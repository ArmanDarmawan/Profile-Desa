<?php 
include 'template/header.php';
// File untuk menyimpan konten sejarah
$file_path = '../data/sejarah_content.txt';
$konten_sejarah = '';
if (file_exists($file_path)) {
    $konten_sejarah = file_get_contents($file_path);
} else {
    $konten_sejarah = "Konten sejarah belum tersedia. Silakan hubungi administrator.";
}
 ?>

<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area white-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo-img">
                            <a href="#">
                                <img src="../img/logo.png" alt="" width="55rem">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="../">Home</a></li>
                                    <li><a href="galeri.php">Galeri</a></li>
                                    <li><a class="active" href="sejarah.php">Sejarah</a></li>
                                    <li><a href="peta.php">Peta Desa</a></li>
                                    <li><a href="loker.php">Loker</a></li>
                                    <li><a href="../admin/index.php">Dashboard</a></li>
                                    <li><a href="hubungi.php">Hubungi</a></li>
                                    <li><a href="faq.php">FAQ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
                <div class="search_input" id="search_input_box">
                    <div class="container ">
                        <form class="d-flex justify-content-between search-inner">
                            <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                            <button type="submit" class="btn"></button>
                            <span class="fa fa-close" id="close_search" title="Close Search"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="breadcrumb breadcrumb_bg banner-bg-1 overlay2 ptb200">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 offset-lg-1">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>Sejarah Desa Cikondang</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="service-area">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="section-title text-center mb-65">
                <span>Desa Cikondang</span>
                <p><?php echo nl2br(htmlspecialchars($konten_sejarah)); ?></p>
            </div>
        </div>

</div>
<footer class="footer-area bg-dark">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-6 col-md-3 col-xl-4">
                <div class="single-footer-widget footer_1">
                    <a href="../index.php"> <img src="../img/logo.png" alt="" width="50rem"> </a>
                    <p  class="text-white">Kantor Desa Cikondang <br>
                        Jl. Raya Cikondang, Desa Cikondang, Kec. Ciawi, Kab. Tasikmalaya, Jawa Barat. Kode Pos: [ISI KODE POS]
                    </p>
                    <div class="social-links">
                        <ul>
                            <li><a href="#"> <i class="fa fa-facebook"></i> </a></li>
                            <li><a href="#"> <i class="fa fa-twitter"></i> </a></li>
                            <li><a href="#"> <i class="fa fa-linkedin"></i> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-xl-3">
                <div class="single-footer-widget footer_icon">
                    <div class="office-location">
                        <ul>
                            <li>
                                <strong>Indonesia</strong>
                                <strong>Jawa Barat,Indonesia <br>
                                    +62 [NOMOR TELEPON DESA]</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <center>
            <small>Copyright by Desa Cikondang ©2020 | Tugas PKK Produktif</small>
        </center>
    </div>
</footer>
    <?php 
    include 'template/footer.php';
     ?>