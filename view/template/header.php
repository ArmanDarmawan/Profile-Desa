<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sistem Informasi Desa</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" type="image/x-icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/themify-icons.css">
    <link rel="stylesheet" href="../css/nice-select.css">
    <link rel="stylesheet" href="../css/flaticon.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/slicknav.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Custom styles for better UI/UX and mobile experience */
        body {
            font-family: 'Arial', sans-serif; /* Consistent font */
        }

        /* Header and Navigation */
        .main-header-area .logo-img img {
            max-height: 50px; /* Control logo size */
            width: auto;
        }
        .main-menu nav ul li a {
            padding: 30px 15px; /* Adjust padding for nav items */
        }
        .slicknav_menu { /* Mobile menu styling */
            background: #333;
            padding: 10px;
        }
        .slicknav_btn {
            background-color: #fff;
        }
        .slicknav_nav a {
            color: white;
            padding: 8px 12px;
            display: block;
        }
        .slicknav_nav a:hover {
            background: #555;
            color: #fff;
        }

        /* Breadcrumb / Page Header */
        .breadcrumb_bg {
            padding-top: 80px; /* Reduced padding for smaller screens */
            padding-bottom: 80px;
        }
        .breadcrumb_iner h2 {
            font-size: 2rem; /* Responsive font size for breadcrumb title */
        }
        @media (max-width: 768px) {
            .breadcrumb_bg {
                padding-top: 60px;
                padding-bottom: 60px;
            }
            .breadcrumb_iner h2 {
                font-size: 1.5rem;
            }
        }

        /* Section Padding */
        .section-padding {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .service-area, .about-area, .faq-area, .blog_area, .contact-section, .main-project-area {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        /* Buttons */
        .boxed-btn, .button {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .btn-primary, .btn-success {
             margin-bottom: 5px; /* Add space if buttons stack on mobile */
        }

        /* Forms */
        .form-control {
            margin-bottom: 15px; /* Space below form inputs */
            border-radius: 0.25rem; /* Softer corners */
        }
        .form-contact .form-group textarea.form-control {
            height: 150px;
        }
        .form-group label {
            margin-bottom: .5rem;
            font-weight: bold;
        }

        /* Tables */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        }
        .table th, .table td {
            vertical-align: middle; /* Better alignment in table cells */
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.03);
        }


        /* Cards (used in Loker, FAQ etc.) */
        .card {
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 0.3rem;
        }
        .card-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1.25rem;
        }
        .card-body {
            padding: 1.25rem;
        }
        .card-title {
            margin-bottom: 0.75rem;
        }

        /* Images */
        .img-fluid, .project-thumb img, .blog_item_img img, .about-thumb img {
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            border-radius: 0.25rem; /* Slight rounding for images */
        }
        .single-project .project-thumb img {
            object-fit: cover; /* Ensure images in gallery cover their area */
            height: 250px; /* Fixed height for gallery items, adjust as needed */
        }
         @media (min-width: 768px) {
            .single-project .project-thumb img {
                height: 350px;
            }
        }


        /* Footer */
        .footer-area {
            padding: 40px 0;
        }
        .footer-area .single-footer-widget {
            margin-bottom: 30px;
        }
        .footer-area .single-footer-widget p {
            color: #ccc; /* Lighter text for better contrast on dark bg */
        }
        .footer-area .copyright_text p {
            color: #ccc;
        }
        .footer-area .social-links ul li a i {
            color: #fff;
        }
         .footer-area .single-footer-widget a img {
            max-height: 40px; /* Footer logo size */
        }

        /* Alerts / Notifications */
        .alert {
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        /* Specific Page Adjustments */
        /* FAQ */
        .faq-area .card .card-header .btn-link {
            text-align: left;
            width: 100%;
            text-decoration: none;
            color: #333;
        }
        .faq-area .card .card-header .btn-link:hover {
            color: #007bff;
        }
        .faq-area .card .card-body {
            background-color: #fff;
        }

        /* Loker */
        .blog_item { /* Used for Loker items */
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #fff;
        }
        .blog_item_img {
            margin-bottom: 15px;
        }
        .blog_details h2 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .blog_details h3 {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }
        .blog_details .btn {
            margin-right: 5px;
        }

        /* Peta Desa */
        .responsive-iframe-container {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
        }
        .responsive-iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
        .whole-wrap .section-top-border iframe { /* Direct iframe styling if not wrapped */
            max-width: 100%;
        }


        /* Utility classes */
        .ptb200 { /* breadcrumb padding, already defined, but can be adjusted */
            padding-top: 100px;
            padding-bottom: 100px;
        }
        @media (max-width: 768px) {
            .ptb200 {
                padding-top: 60px;
                padding-bottom: 60px;
            }
        }
        .mb-65 {
            margin-bottom: 65px !important;
        }
        @media (max-width: 768px) {
            .mb-65 {
                margin-bottom: 30px !important;
            }
        }

        /* Ensure Magnific Popup images are constrained */
        .mfp-img {
            max-width: 90vw !important;
            max-height: 90vh !important;
        }
        .mfp-figure {
             line-height: 0; /* Fix for extra space below image */
        }
        .mfp-bottom-bar {
            font-size: 12px; /* Smaller caption text */
        }

        /* Fix for search input box if it's part of the layout */
        .search_input_box {
            padding: 15px 0;
        }

    </style>
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    