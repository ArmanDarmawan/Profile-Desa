<?php 
include 'template/header.php';
// No need to include connection.php here as it's not directly used for DB queries on this page load.
// It will be used by contact_process.php
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
                                        <li><a href="loker.php">Loker</a></li>
                                        <li><a href="../admin/index.php">Dashboard</a></li>
                                        <li><a class="active" href="hubungi.php">Hubungi</a></li>
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
                            <h2>Hubungi Kami</h2>
                            <p>Sampaikan masukan, saran, atau pertanyaan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-section section-padding">
        <div class="container">
            <div id="contact-form-status-placeholder"></div>

            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title text-center mb-4">Kirim Pesan</h2>
                </div>
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input class="form-control" name="nama" id="name" type="text" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                     <label for="email">Alamat Email <span class="text-danger">*</span></label>
                                    <input class="form-control" name="email" id="email" type="email" placeholder="Masukkan email Anda" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                     <label for="subject">Subjek <span class="text-danger">*</span></label>
                                    <input class="form-control" name="subject" id="subject" type="text" placeholder="Masukkan subjek pesan" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">Pesan Anda <span class="text-danger">*</span></label>
                                    <textarea class="form-control w-100" name="pesan" id="message" cols="30" rows="7" placeholder="Tuliskan pesan Anda di sini" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn btn-block">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <h4 class="mb-3">Informasi Kontak</h4>
                    <div class="media contact-info mb-3">
                        <span class="contact-info__icon mr-3"><i class="ti-home fa-2x text-primary"></i></span>
                        <div class="media-body">
                            <h5>Alamat Kantor Desa</h5>
                            <p class="mb-0">Jl. Raya Cikondang, Desa Cikondang, Kec. Ciawi, Kab. Tasikmalaya, Jawa Barat.</p>
                            <p>[ISI KODE POS ANDA]</p>
                        </div>
                    </div>
                    <div class="media contact-info mb-3">
                        <span class="contact-info__icon mr-3"><i class="ti-tablet fa-2x text-primary"></i></span>
                        <div class="media-body">
                            <h5>Telepon & Jam Pelayanan</h5>
                            <p class="mb-0">+62 [NOMOR TELEPON DESA]</p>
                            <p>Senin - Jumat: 08.00 - 16.00 WIB</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon mr-3"><i class="ti-email fa-2x text-primary"></i></span>
                        <div class="media-body">
                            <h5>Email</h5>
                            <p class="mb-0">kontak@desacikondang.id</p>
                            <p>Kirimkan pertanyaan Anda kapan saja.</p>
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
// Script for hubungi.php, if any specific JS is needed beyond global footer script
// For example, client-side form validation (though Bootstrap validation attributes are good)
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Handle status messages specifically for this page if needed
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status_hubungi'); // Use a unique param
        const msg = urlParams.get('msg_hubungi');
        const placeholder = document.getElementById('contact-form-status-placeholder');

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
            
            // Clear URL params
            if (history.pushState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path:newUrl},'',newUrl);
            }
        }
    }, false);
})();
</script>
