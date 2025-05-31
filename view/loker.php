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
                            <h2>Lowongan Pekerjaan</h2>
                            <p>Temukan peluang karir di sekitar Desa Cikondang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog_area section-padding">
        <div class="container">
            <div id="loker-status-placeholder" class="mb-4"></div>

            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4">Lowongan Tersedia</h3>
                    <?php
                      $sql_loker = "SELECT * FROM loker ORDER BY id DESC"; // Show newest first
                      $query_loker = mysqli_query($connection, $sql_loker);
                      if (mysqli_num_rows($query_loker) > 0) {
                          while ($row = mysqli_fetch_assoc($query_loker)) {
                              $foto_path = "../img/upload/" . htmlspecialchars($row['foto']);
                              if (!file_exists($foto_path) || empty($row['foto'])) {
                                  $foto_path = "https://placehold.co/600x400/e0e0e0/777?text=Image+Not+Available"; // Placeholder
                              }
                    ?>
                    <article class="blog_item card shadow-sm mb-4">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <div class="blog_item_img">
                                    <img class="card-img-top img-fluid" src="<?php echo $foto_path; ?>" alt="Foto <?php echo htmlspecialchars($row['nm_perusahaan']); ?>" style="height: 200px; object-fit: cover;">
                                    <?php if(!empty($row['tgl']) && !empty($row['bln'])): ?>
                                    <div class="blog_item_date">
                                        <h3><?php echo htmlspecialchars($row['tgl']); ?></h3>
                                        <p><?php echo htmlspecialchars($row['bln']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="blog_details card-body">
                                    <a class="d-inline-block" href="mendaftar.php?id=<?php echo $row['id']; ?>">
                                        <h4 class="card-title"><?php echo htmlspecialchars($row['nm_perusahaan']); ?></h4>
                                    </a>
                                    <p class="card-text"><small class="text-muted">Jenis Usaha: <?php echo htmlspecialchars($row['jenis_usaha']); ?></small></p>
                                    <p class="card-text"><strong>Syarat & Ketentuan:</strong><br><?php echo nl2br(htmlspecialchars($row['syarat'])); ?></p>
                                    <p class="card-text"><small class="text-muted">Alamat: <?php echo htmlspecialchars($row['alamat']); ?></small></p>
                                    
                                    <a href="tampil_daftar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-info mr-2">
                                        <i class="fa fa-users"></i> <?php echo htmlspecialchars($row['pendaftar'] ?: 0); ?> Pendaftar
                                    </a>
                                    <a href="mendaftar.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">
                                        <i class="fa fa-file-text-o"></i> Mendaftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php 
                          }
                      } else {
                    ?>
                    <div class="alert alert-info text-center" role="alert">
                        Saat ini belum ada lowongan pekerjaan yang tersedia.
                    </div>
                    <?php
                      } 
                    ?>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Tambah Lowongan Baru</h4>
                        </div>
                        <div class="card-body">
                            <form action="proses.php" method="post" enctype="multipart/form-data" id="formTambahLoker" class="needs-validation" novalidate>
                                <input type="hidden" name="daftar" value="0"> 
                                <div class="form-group">
                                    <label for="nm_usaha">Nama Usaha/Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nm_usaha" id="nm_usaha" placeholder="Contoh: PT Maju Jaya" required>
                                    <div class="invalid-feedback">Nama usaha wajib diisi.</div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_usaha">Jenis Usaha <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenis_usaha" id="jenis_usaha" placeholder="Contoh: Retail, Manufaktur" required>
                                    <div class="invalid-feedback">Jenis usaha wajib diisi.</div>
                                </div>
                                <div class="form-group">
                                    <label for="syarat">Syarat dan Ketentuan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="syarat" id="syarat" rows="5" placeholder="Sebutkan persyaratan, misal: Lulusan SMA, Pengalaman 1 tahun, dll." required></textarea>
                                    <small class="form-text text-muted">Gunakan koma (,) atau baris baru untuk memisahkan beberapa syarat.</small>
                                    <div class="invalid-feedback">Syarat dan ketentuan wajib diisi.</div>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat lengkap perusahaan" required>
                                    <div class="invalid-feedback">Alamat wajib diisi.</div>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Perusahaan/Logo (Max 1MB)</label>
                                    <input type="file" class="form-control-file" name="foto" id="foto" accept="image/jpeg, image/png">
                                    <small class="form-text text-muted">Format: JPG, PNG. Kosongkan jika tidak ada.</small>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Tambahkan Lowongan</button>
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

        // Handle status messages for loker page
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status_loker');
        const msg = urlParams.get('msg_loker');
        const placeholder = document.getElementById('loker-status-placeholder');

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
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path:newUrl},'',newUrl);
            }
        }
    }, false);
})();
</script>
