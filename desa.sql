-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 06:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `full_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$exampleHashValue...', 'Administrator Utama', 'admin@desacikondang.id', '2025-05-31 16:20:35', '2025-05-31 16:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban` text NOT NULL,
  `urutan` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konten_halaman`
--

CREATE TABLE `konten_halaman` (
  `id` int(11) NOT NULL,
  `nama_bagian` varchar(100) NOT NULL,
  `isi_konten` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konten_halaman`
--

INSERT INTO `konten_halaman` (`id`, `nama_bagian`, `isi_konten`, `updated_at`) VALUES
(1, 'beranda_selamat_datang', 'Selamat Datang Di Website Desa Cikondang', '2025-05-31 13:25:07'),
(2, 'beranda_deskripsi_desa', 'Cikondang adalah desa di kecamatan Ciawi, Tasikmalaya, Jawa Barat. Desa Cikondang Mempunyai [jumlah] RW dengan beberapa Grumbul/Kedusunan. Grumbul/Kedusunan dalam masyarakat setempat merupakan wilayah kecil yang terdiri dari satu atau beberapa RW. Sebagian Desa Cikondang memiliki topografi wilayah berupa perbukitan.', '2025-05-31 13:25:07'),
(3, 'beranda_kehidupan_sosial', 'Desa ini cukup potensial untuk dijadikan contoh bagi desa disekitarnya. Desa ini cukup tentram karena toleransi, ramah tamah dan instansi pemerintah Desa Cikondang yang tergolong bagus. Keamanan dan ketertiban Masyarakat Desa Cikondang amat baik karena pemuda pemudi Desa ini mempunyai wadah perkumpulan. Desa Cikondang bekerja sama dengan unsur beberapa elemen antara lain Koramil dan Polsek setempat untuk menjaga roda pemerintahan dan keamanan.', '2025-05-31 13:25:07'),
(4, 'beranda_pembangunan_deskripsi', 'Pembangunan Yang dilaksanakan oleh pemerintah Desa Cikondang.', '2025-05-31 13:25:07'),
(5, 'peta_iframe_src', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.157367562747!2d108.15788881920769!3d-7.277348978118957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f5bb6066f4529%3A0x1e1d9f6a70ca227!2sCikondang%2C%20Kec.%20Cineam%2C%20Kabupaten%20Tasikmalaya%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1670000000000!5m2!1sid!2sid', '2025-05-31 13:25:07'),
(6, 'peta_pembagian_wilayah', '', '2025-05-31 15:38:32'),
(7, 'peta_batas_utara', '[Nama Desa/Wilayah Batas Utara]', '2025-05-31 13:25:07'),
(8, 'peta_batas_timur', '[Nama Desa/Wilayah Batas Timur]', '2025-05-31 13:25:07'),
(9, 'peta_batas_selatan', '[Nama Desa/Wilayah Batas Selatan]', '2025-05-31 13:25:07'),
(10, 'peta_batas_barat', '[Nama Desa/Wilayah Batas Barat]', '2025-05-31 13:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `loker`
--

CREATE TABLE `loker` (
  `id` int(11) NOT NULL,
  `nm_perusahaan` varchar(255) NOT NULL,
  `jenis_usaha` varchar(255) NOT NULL,
  `syarat` text NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tgl` int(11) NOT NULL,
  `bln` varchar(11) NOT NULL,
  `pendaftar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loker`
--

INSERT INTO `loker` (`id`, `nm_perusahaan`, `jenis_usaha`, `syarat`, `alamat`, `foto`, `tgl`, `bln`, `pendaftar`) VALUES
(1, 'Sate Ayam', 'Bisnis', '1.good Looking\r\n2.suka makan', 'cihonje jawa timur', 'IMG_20210720_012111.jpg', 17, 'Jul', 0),
(2, 'JUALAN PETE', 'PETE', 'SERBA BISA', 'Cikondang', '1748708977_Screenshot_2025_04_21_214451.png', 31, 'May', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `id_loker` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_tlp` int(30) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `kk` varchar(255) NOT NULL,
  `pengajuan` varchar(255) NOT NULL,
  `tgl` int(10) NOT NULL,
  `bln` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_masuk`
--

CREATE TABLE `pesan_masuk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_terima` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_baca` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesan_masuk`
--

INSERT INTO `pesan_masuk` (`id`, `nama`, `email`, `subjek`, `pesan`, `tanggal_terima`, `tanggal_kirim`, `status_baca`) VALUES
(1, 'Arman Darmawan', 'armanciamis13@gmail.com', 'Haloo', 'Halo ini aku', '2025-05-31 15:37:51', '2025-05-31 15:37:51', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konten_halaman`
--
ALTER TABLE `konten_halaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_bagian` (`nama_bagian`);

--
-- Indexes for table `loker`
--
ALTER TABLE `loker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan_masuk`
--
ALTER TABLE `pesan_masuk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten_halaman`
--
ALTER TABLE `konten_halaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `loker`
--
ALTER TABLE `loker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesan_masuk`
--
ALTER TABLE `pesan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
