<?php 
include 'template/header.php';
include '../db/connection.php';

$id_loker = null;
$loker_data = null;

if (isset($_GET["id"])) {
    $id_loker = (int)$_GET["id"];
    // Query untuk mengambil detail lowongan
    $sql_loker = "SELECT * FROM loker WHERE id = $id_loker";
    $query_loker = mysqli_query($connection, $sql_loker);
    if ($query_loker && mysqli_num_rows($query_loker) > 0) {
        $loker_data = mysqli_fetch_assoc($query_loker);
    } else {
        // Redirect or show error if loker not found
        header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode("Lowongan tidak ditemukan."));
        exit;
    }
} else {
    // Redirect if no ID is provided
    header("Location: loker.php?status_loker=gagal&msg_loker=" . urlencode("ID Lowongan tidak valid."));
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
                            <h2>Pendaftaran Lowongan Pekerjaan</h2>
                            <p>Lengkapi formulir di bawah ini untuk melamar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-area section-padding">
        <div class="container">
            <div id="mendaftar-status-placeholder" class="mb-4"></div>

            <?php if ($loker_data): ?>
            <div class="row mb-5">
                <div class="col-lg-10 offset-lg-1">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                             <h3 class="mb-0">Detail Lowongan: <?php echo htmlspecialchars($loker_data['nm_perusahaan']); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <?php 
                                    $foto_loker_path = "../img/upload/" . htmlspecialchars($loker_data['foto']);
                                    if (!file_exists($foto_loker_path) || empty($loker_data['foto'])) {
                                        $foto_loker_path = "https://placehold.co/300x200/e0e0e0/777?text=Logo+Perusahaan";
                                    }
                                    ?>
                                    <img src="<?php echo $foto_loker_path; ?>" alt="Logo <?php echo htmlspecialchars($loker_data['nm_perusahaan']); ?>" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Jenis Usaha:</strong> <?php echo htmlspecialchars($loker_data['jenis_usaha']); ?></p>
                                    <p><strong>Alamat:</strong> <?php echo htmlspecialchars($loker_data['alamat']); ?></p>
                                    <p><strong>Syarat & Ketentuan:</strong><br><?php echo nl2br(htmlspecialchars($loker_data['syarat'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Formulir Pendaftaran</h4>
                        </div>
                        <div class="card-body">
                            <form action="proses_daftar.php?id=<?php echo $id_loker; ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama lengkap Anda" required>
                                    <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Alamat Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="contoh@email.com" required>
                                        <div class="invalid-feedback">Format email tidak valid atau email wajib diisi.</div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="no_tlp">Nomor Telepon <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="no_tlp" id="no_tlp" placeholder="08xxxxxxxxxx" required pattern="[0-9]{10,15}">
                                        <div class="invalid-feedback">Nomor telepon wajib diisi (10-15 digit angka).</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap Sesuai KTP <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
                                    <div class="invalid-feedback">Alamat wajib diisi.</div>
                                </div>
                                
                                <h5 class="mt-4 mb-3">Unggah Dokumen (Max 1MB per file, Format: PDF, JPG, PNG)</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="ktp">Foto KTP <span class="text-danger">*</span></label>
                                        <input type="file" name="ktp" id="ktp" class="form-control-file" required accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="invalid-feedback">Foto KTP wajib diunggah.</div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="kk">Foto KK <span class="text-danger">*</span></label>
                                        <input type="file" name="kk" id="kk" class="form-control-file" required accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="invalid-feedback">Foto KK wajib diunggah.</div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pengajuan">Surat Lamaran/Pengajuan <span class="text-danger">*</span></label>
                                        <input type="file" name="pengajuan" id="pengajuan" class="form-control-file" required accept=".pdf,.jpg,.jpeg,.png">
                                        <div class="invalid-feedback">Surat lamaran wajib diunggah.</div>
                                    </div>
                                </div>
                                <small class="form-text text-muted mb-3">Pastikan semua dokumen jelas dan dapat dibaca.</small>

                                <button type="submit" class="btn btn-success btn-lg btn-block mt-3">Kirim Lamaran</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php 
include 'template/footer.php';
?>
<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Bootstrap validation
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Handle status messages
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status_daftar');
        const msg = urlParams.get('msg_daftar');
        const placeholder = document.getElementById('mendaftar-status-placeholder');

        if (status && msg && placeholder) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${status === 'sukses' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                ${decodeURIComponent(msg)}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            placeholder.appendChild(alertDiv);
            
            if (history.pushState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?id=" + <?php echo json_encode($id_loker); ?>; // Keep ID for context
                window.history.pushState({path:newUrl},'',newUrl);
            }
        }
    }, false);
})();
</script>
