            </main> </div> </div> <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Fungsi untuk toggle sidebar di tampilan mobile
            $('#sidebarToggle').on('click', function () {
                $('#sidebarMenu').toggleClass('active');
                $('#sidebarOverlay').toggleClass('active');
                // Optional: Geser konten utama saat sidebar mobile aktif jika diinginkan
                // $('body').toggleClass('sidebar-mobile-active'); 
            });

            // Sembunyikan sidebar mobile saat overlay diklik
            $('#sidebarOverlay').on('click', function () {
                $('#sidebarMenu').removeClass('active');
                $('#sidebarOverlay').removeClass('active');
                // $('body').removeClass('sidebar-mobile-active');
            });

            // Menyesuaikan margin konten utama berdasarkan lebar sidebar (untuk desktop)
            function adjustMainContentMargin() {
                if ($(window).width() >= 768) { // Hanya untuk layar md ke atas
                    if ($('#sidebarMenu').is(':visible') && !$('#sidebarMenu').hasClass('collapsed')) {
                        $('#mainContent').css('margin-left', $('#sidebarMenu').outerWidth() + 'px');
                    } else {
                        $('#mainContent').css('margin-left', '0');
                    }
                } else {
                    $('#mainContent').css('margin-left', '0'); // Reset margin di mobile
                }
            }

            // Panggil saat load dan resize
            // adjustMainContentMargin(); // Panggil saat load
            // $(window).on('resize', adjustMainContentMargin); // Panggil saat resize

            // Contoh: Jika ada tombol untuk collapse sidebar di desktop
            $('#desktopSidebarCollapse').on('click', function() {
                $('#sidebarMenu').toggleClass('collapsed');
                $('#mainContent').toggleClass('sidebar-collapsed');
                // adjustMainContentMargin(); // Sesuaikan margin setelah collapse/expand
            });

        });
    </script>
    </body>
</html>
