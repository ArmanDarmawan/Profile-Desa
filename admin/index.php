<?php 
include 'template/header.php'; 
include '../db/connection.php'; // Untuk penggunaan di masa mendatang
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Admin</h1>
</div>

<p>Selamat datang di halaman administrasi Website Desa Cikondang.</p>
<p>Dari sini Anda dapat mengelola berbagai konten yang ditampilkan di website publik.</p>

<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-desktop fa-3x mb-3 text-primary"></i>
                <h5 class="card-title">Halaman Beranda</h5>
                <p class="card-text">Kelola informasi utama yang tampil di halaman depan.</p>
                <a href="manage_beranda.php" class="btn btn-primary">Kelola Beranda</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-briefcase fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Lowongan Kerja</h5>
                <p class="card-text">Tambah, edit, atau hapus data lowongan kerja dan lihat pendaftar.</p>
                <a href="manage_loker.php" class="btn btn-success">Kelola Loker</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-image fa-3x mb-3 text-info"></i>
                <h5 class="card-title">Galeri</h5>
                <p class="card-text">Unggah dan kelola gambar untuk galeri desa.</p>
                <a href="manage_galeri.php" class="btn btn-info">Kelola Galeri</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-history fa-3x mb-3 text-warning"></i>
                <h5 class="card-title">Sejarah Desa</h5>
                <p class="card-text">Perbarui dan kelola konten halaman sejarah desa.</p>
                <a href="manage_sejarah.php" class="btn btn-warning">Kelola Sejarah</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-map fa-3x mb-3 text-danger"></i>
                <h5 class="card-title">Peta Desa</h5>
                <p class="card-text">Perbarui informasi terkait peta dan wilayah desa.</p>
                <a href="manage_map.php" class="btn btn-danger">Kelola Peta</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-envelope fa-3x mb-3 text-secondary"></i>
                <h5 class="card-title">Pesan Masuk</h5>
                <p class="card-text">Lihat pesan dan masukan dari pengunjung website.</p>
                <a href="view_hubungi.php" class="btn btn-secondary">Lihat Pesan</a>
            </div>
        </div>
    </div>
     <div class="col-md-4 mb-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fa fa-question-circle fa-3x mb-3 text-dark"></i>
                <h5 class="card-title">FAQ</h5>
                <p class="card-text">Kelola daftar pertanyaan yang sering diajukan.</p>
                <a href="manage_faq.php" class="btn btn-dark">Kelola FAQ</a>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>