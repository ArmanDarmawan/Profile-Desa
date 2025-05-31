<?php 
include 'template/header.php';
include '../db/connection.php'; // Tambahkan koneksi

// Fungsi untuk mengambil konten dari database
function getContentPeta($nama_bagian, $conn) {
    $sql = "SELECT isi_konten FROM konten_halaman WHERE nama_bagian = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $nama_bagian);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['isi_konten']; // Tidak perlu htmlspecialchars di sini, akan diterapkan saat output
        }
        mysqli_stmt_close($stmt);
    }
    return ''; 
}

$peta_iframe_src = getContentPeta('peta_iframe_src', $connection);
$pembagian_wilayah_content = getContentPeta('peta_pembagian_wilayah', $connection);
$batas_utara_content = getContentPeta('peta_batas_utara', $connection);
$batas_timur_content = getContentPeta('peta_batas_timur', $connection);
$batas_selatan_content = getContentPeta('peta_batas_selatan', $connection);
$batas_barat_content = getContentPeta('peta_batas_barat', $connection);

// Pecah konten pembagian wilayah menjadi array per baris
$pembagian_wilayah_array = !empty($pembagian_wilayah_content) ? explode("\n", trim($pembagian_wilayah_content)) : [];

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
                                        <li><a href="../index.php">Home</a></li>
                                        <li><a href="galeri.php">Galeri</a></li>
                                        <li><a href="sejarah.php">Sejarah</a></li>
                                        <li><a class="active" href="#">Peta Desa</a></li>
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
                                <h2>Peta Desa Cikondang</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="whole-wrap">
        <div class="container box_1170">
            <div class="section-top-border">
                <iframe src="<?php echo htmlspecialchars($peta_iframe_src ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.421631713013!2d108.21800801477426!3d-7.192421094808961!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f4f1961841851%3A0x1a7380312b8097c3!2sCikondang%2C%20Cineam%2C%20Tasikmalaya%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1622470000000!5m2!1sen!2sid'); // Fallback URL jika kosong ?>" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <h3 class="mt-5 mb-3 text-center">
                <strong>Pembagian Wilayah</strong>
            </h3>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <?php if (!empty($pembagian_wilayah_array)): ?>
                    <table class="table table-bordered table-hover table-striped"> 
                        <?php foreach ($pembagian_wilayah_array as $index => $item_wilayah): ?>
                            <tr>    
                                <td style="width: 50px; text-align: center;"><?php echo $index + 1; ?>.</td>
                                <td><?php echo htmlspecialchars(trim($item_wilayah)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <p class="text-center">Data pembagian wilayah belum tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        <br>
        <center>
            <h3>Batas-Batas Wilayah Desa Cikondang</h3>
            <table class="table table-hover table-bordered table-striped text-center col-md-8">
                <tr>
                    <td style="width: 20%;">Utara</td>
                    <td><?php echo htmlspecialchars($batas_utara_content); ?></td>
                </tr>
                <tr>
                    <td>Timur</td>
                    <td><?php echo htmlspecialchars($batas_timur_content); ?></td>
                </tr>
                <tr>
                    <td>Selatan</td>
                    <td><?php echo htmlspecialchars($batas_selatan_content); ?></td>
                </tr>
                <tr>
                    <td>Barat</td>
                    <td><?php echo htmlspecialchars($batas_barat_content); ?></td>
                </tr>