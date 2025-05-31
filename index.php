<?php 
include 'db/connection.php'; // Pindahkan koneksi ke atas jika belum

// Fungsi untuk mengambil konten dari database
function getContent($nama_bagian, $conn) {
    $sql = "SELECT isi_konten FROM konten_halaman WHERE nama_bagian = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $nama_bagian);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return htmlspecialchars($row['isi_konten']);
        }
        mysqli_stmt_close($stmt);
    }
    return ''; // Kembalikan string kosong jika tidak ada atau error
}

$selamat_datang = getContent('beranda_selamat_datang', $connection);
$deskripsi_desa_cikondang = getContent('beranda_deskripsi_desa', $connection);
$kehidupan_sosial_cikondang = getContent('beranda_kehidupan_sosial', $connection);
$pembangunan_deskripsi_cikondang = getContent('beranda_pembangunan_deskripsi', $connection);

?>
<!DOCTYPE html> <html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sistem Informasi Desa</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area white-bg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo-img">
                            <a href="#">
                                <img src="img/logo.png" alt="" width="55rem">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="main-menu d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a class="active" href="#">Home</a></li>
                                    <li><a href="view/galeri.php">Galeri</a></li>
                                    <li><a href="view/sejarah.php">Sejarah</a></li>
                                    <li><a href="view/peta.php">Peta Desa</a></li>
                                    <li><a href="view/loker.php">Loker</a></li>
                                    <li><a href="admin/index.php">Dashboard</a></li>
                                    <li><a href="view/hubungi.php">Hubungi</a></li>
                                    <li><a href="view/faq.php">FAQ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
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
                        <h2><?php echo $selamat_datang; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="service-area gray-bg">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="section-title text-center mb-65">
                <h3>DESA CIKONDANG</h3>
                <hr>
            </div>
        </div>
        <div class="text-center">
            <div class="card border-success ">
                <img src="img/project/1.jpg" alt=""> <div class="card-body">
                        <h5 class="card-title">Cikondang</h5>
                        <p class="card-text"><?php echo nl2br($deskripsi_desa_cikondang); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="service-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="section-title text-center mb-65">
                    <span>Kehidupan Sosial</span>
                    <p><?php echo nl2br($kehidupan_sosial_cikondang); ?></p>
                </div>
            </div>

    </div>
<div class="counter-area gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-4">
                <div class="single-counter">
                    <div class="icon">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="counter-number">
                        <h3><span class="counter">5.590</span><span>+</span></h3> 
                        <p>Jumlah <span>Penduduk</span> </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="single-counter">
                    <div class="icon">
                        <i class="fa fa-home fa-4x"></i>
                    </div>
                    <div class="counter-number">
                        <h3><span class="counter">185</span><span> per KM</span></h3> 
                        <p>Kepadatan <span>Penduduk</span></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="single-counter">
                    <div class="icon">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="counter-number">
                        <h3><span class="counter">2.500</span><span> Ha</span></h3> 
                        <p><span>Luas</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="project-area bg-img-2 overlay">
    <div class="container-fluid p-lg-0">
        <div class="row justify-content-end no-gutters">
            <div class="col-xl-4 col-md-6">
                <div class="section-title text-white mb-65 ml-80">
                    <h3>Pembangunan</h3>
                    <p><?php echo nl2br($pembangunan_deskripsi_cikondang); ?></p>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="project-active owl-carousel">
                    <div class="single-project">
                        <div class="project-thumb">
                            <img src="img/project/jembatan.jpg" alt="">
                        </div>
                        <div class="project-info">
                            <span>Pembangunan Jembatan</span>
                            <h3>Pembangunan Ini dilaksanakan di [Lokasi Proyek] yang dilaksanakan pada [Tanggal Proyek]</h3>
                        </div>
                    </div>
                    <div class="single-project">
                        <div class="project-thumb">
                            <img src="img/project/pengaspalan.jpg" alt="">
                        </div>
                        <div class="project-info">
                            <span>Pengaspalan Jalan</span>
                            <h3>Pengaspalan Jalan Ini dilaksanakan di [Lokasi Proyek]</h3>
                        </div>
                    </div>
                    <div class="single-project">
                        <div class="project-thumb">
                            <img src="img/project/1.jpg" alt="">
                        </div>
                        <div class="project-info">
                            <span>Memondasi Sungai</span>
                            <h3>Memondasi sungai ini dilaksanakan disungai yang dekat dengan permukiman warga</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer-area bg-dark">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-6 col-md-3 col-xl-4">
                <div class="single-footer-widget footer_1">
                    <a href="index.html"> <img src="img/logo.png" alt="" width="50rem"> </a>
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
        <center>
            <small>Copyright by Desa Cikondang ©<?php echo date("Y"); ?> | Tugas PKK Produktif</small>
        </center>
    </div>
    <div id="close">
        <div class="container-popup">
            <form action="#" method="post" class="popup-form">
                <img src="img/pop up/pop1.jpg">
                <h3>Selamat Hari Pahlawan 10 November <?php echo date("Y"); ?></h3>
                <p>Di masa sekarang untuk menjadi pahlawan tidak perlu mengangkat senjata, cukup memiliki kepedulian terhadap sesama untuk terus berjuang melalui masa sulit ini, bersatu seperti perjuangan para pahlawan Indonesia untuk mencapai kemerdekaan. Selamat Hari Pahlawan Nasional.</p>
            </form>
            <a class="close" href="#close">X</a>
        </div>
    </div>
</footer>
<style type="text/css">
body{
/* background-color: lavender; */ /* Hapus atau sesuaikan jika tidak diperlukan */
}
*{margin: 0; padding: 0}
@keyframes autopopup {
    from {opacity: 0;margin-top:-200px;}
    to {opacity: 1;}
}
#close {
    background-color: rgba(64, 68, 65, 0.5);
    position: fixed;
    top:0;
    left:0;
    right:0;
    bottom:0;
    animation:autopopup 3.5s;
    z-index: 10000; /* Pastikan popup di atas segalanya */
}
#close:target {
    -webkit-transition:all 1s;
    -moz-transition:all 1s;
    transition:all 1s;
    opacity: 0;
    visibility: hidden;
}

@media (min-width: 768px){
    .container-popup {
        width:40%;
        margin-bottom: 10px;
    }
}
@media (max-width: 767px){
    .container-popup {
        width:80%; /* Perbesar untuk mobile */
    }
}
.container-popup {
    position: relative;
    margin: 10% auto; /* Tengahkan popup */
    padding: 20px; /* Padding lebih baik */
    background-color: #fff; /* Warna latar popup */
    color: #333;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2); /* Tambah shadow */
}
.container-popup img {
    width: 100%;
    height: auto; /* Menjaga rasio aspek gambar */
    border-radius: 4px; /* Sedikit rounded corner untuk gambar */
    margin-bottom: 15px;
}
.container-popup h3 {
    margin-bottom: 10px;
    font-size: 1.5em;
}
.container-popup p {
    font-size: 1em;
    line-height: 1.6;
}
.close {
    position: absolute;
    top:10px; /* Posisi lebih baik */
    right:10px; /* Posisi lebih baik */
    background-color: #d9534f; /* Warna merah untuk tombol close */
    padding:5px 10px;
    font-size: 18px;
    text-decoration: none;
    line-height: 1;
    color:#fff;
    border-radius: 50%; /* Buat tombol close bulat */
    border: none;
}
.close:hover {
    background-color: #c9302c;
}
</style>
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/ajax-form.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/scrollIt.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/nice-select.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/plugins.js"></script>

<script src="js/contact.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/mail-script.js"></script>

<script src="js/main.js"></script>