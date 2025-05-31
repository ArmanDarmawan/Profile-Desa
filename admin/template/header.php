<?php
session_start();
// Sesi admin harus aktif untuk mengakses halaman ini
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Alihkan ke halaman login jika tidak ada sesi admin yang aktif
    // Komentari baris header di bawah ini saat pengembangan jika ingin melewati login
    header("Location: login.php"); 
    exit;
    // Untuk pengembangan, Anda bisa menampilkan pesan atau membiarkannya seperti ini
    // echo "<div class='alert alert-warning'>Sesi admin tidak aktif. Harap <a href='login.php'>login</a>. Fitur admin mungkin tidak berfungsi.</div>";
}

// Fungsi untuk menentukan apakah link navigasi aktif
function isActive($pageName) {
    return basename($_SERVER['PHP_SELF']) == $pageName ? 'active' : '';
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard - Desa Cikondang</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan font Inter */
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: 600;
            padding-left: 1rem; /* Tambahkan padding agar tidak terlalu mepet */
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 56px 0 0; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40; /* Warna sidebar lebih gelap */
            color: #adb5bd;
            transition: all 0.3s; /* Transisi untuk sidebar */
        }

        /* Style untuk sidebar ketika di-collapse */
        .sidebar.collapsed {
            width: 0;
            overflow: hidden; /* Sembunyikan konten saat collapsed */
        }


        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #adb5bd; /* Warna link default */
            padding: .75rem 1.5rem;
            border-left: 3px solid transparent; /* Indikator aktif transparan */
            transition: all 0.2s ease-in-out; /* Transisi halus untuk hover dan active */
        }

        .sidebar .nav-link .fa,
        .sidebar .nav-link .fas { /* Menambahkan .fas untuk Font Awesome 5 */
            margin-right: 10px; /* Jarak ikon dan teks */
            width: 20px; /* Lebar tetap untuk ikon agar teks rapi */
            text-align: center;
        }

        .sidebar .nav-link:hover {
            color: #ffffff; /* Warna link saat hover */
            background-color: #495057; /* Background saat hover */
            border-left-color: #007bff; /* Indikator saat hover */
        }

        .sidebar .nav-link.active {
            color: #ffffff; /* Warna link aktif */
            background-color: #007bff; /* Background link aktif */
            border-left-color: #ffffff; /* Indikator aktif lebih jelas */
        }
        
        .main-content {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            transition: margin-left 0.3s; /* Transisi untuk main content */
        }
        
        /* Style untuk main content ketika sidebar di-collapse */
        .main-content.sidebar-collapsed {
            margin-left: 0;
        }


        .navbar-toggler {
            border: none; /* Hilangkan border pada toggler */
        }
        
        .navbar-toggler:focus {
            outline: none; /* Hilangkan outline pada focus */
        }

        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255,255,255,.75);
        }
        .navbar-dark .navbar-nav .nav-link:hover,
        .navbar-dark .navbar-nav .nav-link:focus {
            color: #fff;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 250px; /* Lebar sidebar default di mobile */
                left: -250px; /* Sembunyikan sidebar di luar layar */
                top: 0; /* Navbar akan menutupi bagian atas sidebar */
                padding-top: 56px; /* Sesuaikan dengan tinggi navbar */
                z-index: 1030; /* Pastikan sidebar di atas konten lain saat terbuka */
            }
            .sidebar.active {
                left: 0; /* Tampilkan sidebar */
            }
            .main-content {
                margin-left: 0; /* Konten utama mengisi seluruh layar */
                padding-top: 70px; /* Beri ruang untuk navbar */
            }
             .main-content.sidebar-active { /* Saat sidebar aktif di mobile */
                margin-left:0; /* Konten tidak bergeser, sidebar akan overlay */
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1020; /* Di bawah sidebar, di atas konten */
                display: none; /* Sembunyikan default */
            }
            .sidebar-overlay.active {
                display: block; /* Tampilkan saat sidebar aktif */
            }
        }

        /* Card styling */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        .card-header {
            background-color: #e9ecef;
            font-weight: 600;
        }

        /* Table styling */
        .table-responsive {
            border-radius: 0.25rem; /* Sedikit rounded corner untuk container tabel */
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead th {
            background-color: #e9ecef; /* Header tabel lebih jelas */
            border-bottom-width: 1px; /* Garis bawah header lebih tipis */
        }
        .btn-sm .fa, .btn-sm .fas {
            margin-right: 3px; /* Jarak ikon pada tombol kecil */
        }

        /* Modal Styling */
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-header .close {
            color: white;
            opacity: 1;
        }
        .modal-title {
            font-weight: 500;
        }

        /* Utility classes */
        .text-small {
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <nav class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow-sm">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0" href="index.php">
            <img src="../img/logo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="Logo">
            Admin Cikondang
        </a>
        <button class="navbar-toggler d-md-none" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav px-3 ml-auto flex-row">
            <li class="nav-item text-nowrap mr-3">
                <a class="nav-link" href="../index.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Lihat Situs
                </a>
            </li>
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar bg-dark">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('index.php'); ?>" href="index.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_beranda.php'); ?>" href="manage_beranda.php">
                                <i class="fas fa-desktop"></i> Halaman Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_galeri.php'); ?>" href="manage_galeri.php">
                                <i class="fas fa-images"></i> Galeri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_sejarah.php'); ?>" href="manage_sejarah.php">
                                <i class="fas fa-history"></i> Sejarah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_map.php'); ?>" href="manage_map.php">
                                <i class="fas fa-map-marked-alt"></i> Peta Desa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_loker.php'); ?>" href="manage_loker.php">
                                <i class="fas fa-briefcase"></i> Lowongan Kerja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('view_hubungi.php'); ?>" href="view_hubungi.php">
                                <i class="fas fa-envelope"></i> Pesan Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo isActive('manage_faq.php'); ?>" href="manage_faq.php">
                                <i class="fas fa-question-circle"></i> FAQ
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content" id="mainContent">
                