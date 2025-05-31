    <footer class="footer-area bg-dark text-light py-5">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="single-footer-widget footer_1">
                        <a href="<?php echo isset($GLOBALS['base_url']) ? $GLOBALS['base_url'] : '../index.php'; ?>"> 
                            <img src="../img/logo.png" alt="Logo Desa" style="max-height: 50px; margin-bottom: 15px;"> 
                        </a>
                        <p class="text-white-50">Kantor Desa Cikondang <br>
                            Jl. Raya Cikondang, Desa Cikondang, Kec. Ciawi, Kab. Tasikmalaya, Jawa Barat. <br>
                            Kode Pos: [ISI KODE POS ANDA]
                        </p>
                        <div class="social-links mt-3">
                            <ul class="list-unstyled d-flex">
                                <li class="mr-2"><a href="#" class="text-white-50"><i class="fa fa-facebook fa-lg"></i></a></li>
                                <li class="mr-2"><a href="#" class="text-white-50"><i class="fa fa-twitter fa-lg"></i></a></li>
                                <li><a href="#" class="text-white-50"><i class="fa fa-linkedin fa-lg"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                    <div class="single-footer-widget">
                        <h5 class="widget_title mb-3 text-white">Tautan Cepat</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="../index.php" class="text-white-50">Home</a></li>
                            <li class="mb-2"><a href="galeri.php" class="text-white-50">Galeri</a></li>
                            <li class="mb-2"><a href="sejarah.php" class="text-white-50">Sejarah</a></li>
                            <li class="mb-2"><a href="peta.php" class="text-white-50">Peta Desa</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="single-footer-widget footer_icon">
                         <h5 class="widget_title mb-3 text-white">Kontak Kami</h5>
                        <div class="office-location">
                            <ul class="list-unstyled">
                                <li class="mb-2 text-white-50">
                                    <i class="fa fa-map-marker mr-2"></i> Jawa Barat, Indonesia
                                </li>
                                <li class="text-white-50">
                                   <i class="fa fa-phone mr-2"></i> +62 [NOMOR TELEPON DESA]
                                </li>
                                 <li class="text-white-50 mt-2">
                                   <i class="fa fa-envelope mr-2"></i> kontak@desacikondang.id
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="copyright_text text-center">
                        <p class="text-white-50">
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Desa Cikondang 
                            <br><small>Tugas PKK Produktif</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="../js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="../js/vendor/jquery-1.12.4.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/ajax-form.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/scrollIt.js"></script>
    <script src="../js/jquery.scrollUp.min.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/nice-select.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/plugins.js"></script>

    <script src="../js/contact.js"></script>
    <script src="../js/jquery.ajaxchimp.min.js"></script>
    <script src="../js/jquery.form.js"></script>
    <script src="../js/jquery.validate.min.js"></script>
    <script src="../js/mail-script.js"></script>

    <script src="../js/main.js"></script>

    <script>
    // Initialize Magnific Popup for galleries
    $(document).ready(function() {
        $('.popup-image').magnificPopup({
            type: 'image',
            gallery:{
                enabled:true
            },
            image: {
                titleSrc: function(item) {
                    return item.el.attr('alt') || ''; // Use alt text as caption
                }
            }
        });

        // Activate mobile navigation
        $('#navigation').slicknav({
            prependTo:'.mobile_menu', // Ensure this target exists in your HTML for mobile menu
            label: 'MENU',
            closedSymbol: '&#9658;', // Arrow right
            openedSymbol: '&#9660;'  // Arrow down
        });

        // Handle status messages from GET parameters (for form submissions)
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const msg = urlParams.get('msg');

        if (status && msg) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${status === 'sukses' || status === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                ${decodeURIComponent(msg)}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;
            // Prepend to a main content area, or a specific message placeholder
            // This example prepends to the first .container, adjust as needed
            const mainContainer = document.querySelector('.container');
            if (mainContainer) {
                mainContainer.prepend(alertDiv);
            }
            // Remove the query parameters from URL without reloading
            if (history.pushState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path:newUrl},'',newUrl);
            }
        }
    });
    </script>

</body>
</html>
