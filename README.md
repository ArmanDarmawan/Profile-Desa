# Sistem Informasi Desa Cikondang

Sistem Informasi Desa Cikondang adalah sebuah platform berbasis web yang dirancang untuk menyediakan informasi dan layanan terkait Desa Cikondang. Aplikasi ini mencakup berbagai fitur yang bermanfaat bagi warga desa maupun pihak luar yang ingin mengetahui lebih lanjut tentang Desa Cikondang.

## Fitur Utama

* **Beranda:** Menampilkan informasi sambutan, deskripsi singkat desa, kehidupan sosial, dan gambaran umum pembangunan.
* **Galeri:** Menyajikan dokumentasi foto kegiatan dan suasana Desa Cikondang.
* **Sejarah Desa:** Menyediakan informasi mengenai sejarah Desa Cikondang yang diambil dari catatan sejarah desa.
* **Peta Desa:** Menampilkan peta wilayah Desa Cikondang beserta informasi batas-batas wilayah dan pembagian administratifnya.
* **Lowongan Kerja (Loker):** Fitur untuk menampilkan informasi lowongan pekerjaan yang tersedia di sekitar desa. Pengguna dapat melihat detail loker dan mengajukan lamaran.
* **Hubungi Kami:** Formulir kontak untuk mengirimkan pesan, saran, atau pertanyaan kepada pihak desa.
* **FAQ (Frequently Asked Questions):** Berisi daftar pertanyaan yang sering diajukan beserta jawabannya terkait Desa Cikondang.
* **Admin Dashboard:** Halaman khusus untuk administrator mengelola konten website, termasuk beranda, galeri, sejarah, peta, loker, melihat pesan masuk, dan mengelola FAQ.

## Struktur Direktori (Contoh Utama)
    
Sistem_Informasi_Cikondang/
├── admin/                # Direktori untuk halaman administrasi
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── manage_beranda.php
│   ├── manage_faq.php
│   ├── manage_galeri.php
│   ├── manage_loker.php
│   ├── manage_map.php
│   ├── manage_sejarah.php
│   ├── proses_faq.php
│   ├── proses_galeri.php
│   ├── proses_loker.php
│   ├── hapus_loker.php
│   ├── view_hubungi.php
│   ├── view_pendaftar_loker.php
│   └── template/           # Template untuk halaman admin
│       ├── header.php
│       └── footer.php
├── css/                  # File CSS
│   ├── animate.css
│   ├── bootstrap.min.css
│   ├── flaticon.css
│   ├── font-awesome.min.css
│   ├── magnific-popup.css
│   ├── nice-select.css
│   ├── owl.carousel.min.css
│   ├── slicknav.css
│   ├── style.css
│   └── theme-default.css
├── data/                 # Penyimpanan data (misal: teks sejarah)
│   └── sejarah_content.txt
├── db/                   # Skrip koneksi database
│   └── connection.php
├── desa.sql              # Struktur dan data database
├── fonts/                # Font-font yang digunakan
│   └── flaticon.css (dan file font lainnya)
├── img/                  # Penyimpanan gambar
│   ├── logo.png
│   └── upload/             # Gambar yang diunggah (galeri, loker, dokumen pelamar, dll)
├── js/                   # File JavaScript
│   ├── ajax-form.js
│   ├── bootstrap.min.js
│   ├── contact.js
│   ├── imagesloaded.pkgd.min.js
│   ├── isotope.pkgd.min.js
│   ├── jquery.ajaxchimp.min.js
│   ├── jquery.counterup.min.js
│   ├── jquery.form.js
│   ├── jquery.magnific-popup.min.js
│   ├── jquery.scrollUp.min.js
│   ├── jquery.slicknav.min.js
│   ├── jquery.validate.min.js
│   ├── mail-script.js
│   ├── main.js
│   ├── nice-select.min.js
│   ├── owl.carousel.min.js
│   ├── plugins.js
│   ├── popper.min.js
│   ├── scrollIt.js
│   ├── waypoints.min.js
│   ├── wow.min.js
│   └── vendor/
│       ├── jquery-1.12.4.min.js
│       └── modernizr-3.5.0.min.js
├── scss/                 # File SCSS (jika menggunakan preprocessor)
│   ├── (berbagai file .scss)
├── view/                 # Halaman-halaman publik
│   ├── contact_process.php
│   ├── faq.php
│   ├── galeri.php
│   ├── hubungi.php
│   ├── loker.php
│   ├── mendaftar.php
│   ├── peta.php
│   ├── proses_daftar.php
│   ├── proses.php (untuk loker)
│   ├── sejarah.php
│   ├── tambah.php (kemungkinan terkait pendaftar loker)
│   ├── tampil_daftar.php
│   └── template/           # Template untuk halaman publik
│       ├── header.php
│       └── footer.php
├── README.md             # File README ini
└── index.php             # Halaman utama

## Database

Sistem ini menggunakan database MySQL dengan nama `desa`. Struktur tabel utama meliputi:

* `admins`: Menyimpan data login administrator.
* `faq`: Menyimpan pertanyaan dan jawaban untuk halaman FAQ.
* `galeri`: Menyimpan informasi gambar untuk galeri.
* `konten_halaman`: Menyimpan konten dinamis untuk berbagai bagian halaman (misalnya beranda, peta).
* `loker`: Menyimpan informasi lowongan pekerjaan.
* `pendaftar`: Menyimpan data pendaftar lowongan kerja.
* `pesan_masuk`: Menyimpan pesan yang dikirim melalui formulir kontak.

File `desa.sql` berisi skema database lengkap yang dapat digunakan untuk membuat struktur tabel yang diperlukan.

## Teknologi yang Digunakan

* **Backend:** PHP
* **Frontend:** HTML, CSS, JavaScript, Bootstrap
* **Database:** MySQL (MariaDB)
* **Styling Tambahan:** SCSS (opsional, berdasarkan struktur folder)

## Instalasi dan Konfigurasi

1.  **Web Server:**
    * Pastikan Anda memiliki web server (seperti Apache atau Nginx) dengan dukungan PHP.
    * Letakkan folder proyek `Sistem_Informasi_Cikondang` di direktori root web server Anda (misalnya `htdocs` untuk XAMPP, `www` untuk WAMP).
2.  **Database Setup:**
    * Buat database baru di MySQL (misalnya dengan nama `desa`).
    * Impor file `desa.sql` ke dalam database yang baru dibuat.
3.  **Koneksi Database:**
    * Konfigurasi detail koneksi database (host, username, password, nama database) di dalam file `db/connection.php`.
    * Pastikan user database memiliki hak akses yang sesuai (SELECT, INSERT, UPDATE, DELETE) terhadap tabel-tabel yang ada.
4.  **Akses Aplikasi:**
    * Akses halaman utama melalui browser dengan URL seperti `http://localhost/Sistem_Informasi_Cikondang/`.
    * Akses halaman admin melalui `http://localhost/Sistem_Informasi_Cikondang/admin/`. Kredensial login default (berdasarkan `admin/login.php`):
        * Username: `admin`
        * Password: `admin123` (Ini harus diganti dengan sistem hashing yang aman untuk produksi).

## Panduan Penggunaan Admin

Halaman admin memungkinkan pengelolaan berbagai aspek website:

* **Dashboard (`admin/index.php`):** Halaman utama admin yang menyediakan navigasi ke berbagai modul pengelolaan.
* **Kelola Beranda (`admin/manage_beranda.php`):** Untuk mengubah teks sambutan, deskripsi desa, informasi kehidupan sosial, dan deskripsi pembangunan.
* **Kelola Loker (`admin/manage_loker.php`):** Menambah, mengedit, dan menghapus informasi lowongan kerja. Admin juga dapat melihat daftar pendaftar untuk setiap loker.
* **Kelola Galeri (`admin/manage_galeri.php`):** Mengunggah gambar baru ke galeri dan menghapus gambar yang sudah ada.
* **Kelola Sejarah (`admin/manage_sejarah.php`):** Mengedit konten teks pada halaman sejarah desa. Konten disimpan dalam file `data/sejarah_content.txt`.
* **Kelola Peta (`admin/manage_map.php`):** Memperbarui link embed Google Maps dan informasi batas-batas wilayah.
* **Lihat Pesan Masuk (`admin/view_hubungi.php`):** Menampilkan pesan yang dikirim oleh pengguna melalui formulir kontak.
* **Kelola FAQ (`admin/manage_faq.php`):** Menambah, mengedit, dan menghapus pertanyaan dan jawaban pada halaman FAQ.

## Catatan Pengembangan

* **Keamanan:**
    * Implementasi hashing password yang kuat untuk akun admin sangat direkomendasikan (contoh: `password_hash()` dan `password_verify()` di PHP). Saat ini, login admin menggunakan perbandingan teks biasa.
    * Gunakan prepared statements untuk semua query database guna mencegah SQL Injection. Beberapa file sudah menggunakan `mysqli_prepare`, namun perlu dipastikan konsistensinya di seluruh aplikasi (misal `view/contact_process.php` dan `admin/manage_beranda.php` sudah baik).
    * Lakukan validasi dan sanitasi input secara menyeluruh baik di sisi client maupun server (Contoh validasi ada di `view/contact_process.php`, `view/proses.php`, `view/proses_daftar.php`).
* **Pengelolaan File:** Pastikan direktori `img/upload/` (dan subdirektorinya seperti `galeri/`, `dokumen_pelamar/`) memiliki izin tulis yang benar agar proses unggah file dapat berjalan.
* **Error Handling:** Implementasikan error handling yang lebih robust di seluruh aplikasi. Saat ini beberapa file melakukan redirect dengan parameter `error`.
* **Struktur Kode:** Pertimbangkan untuk memisahkan logika bisnis (PHP), presentasi (HTML), dan koneksi database lebih lanjut (misalnya menggunakan model MVC atau struktur yang lebih modular).
* **Frontend:** Manfaatkan SCSS yang sudah ada untuk styling yang lebih terstruktur. Pastikan semua aset (CSS, JS, gambar) dilayani dengan benar.

## Kontribusi

Kami menyambut baik kontribusi dari siapa saja untuk meningkatkan Sistem Informasi Desa Cikondang. Jika Anda ingin berkontribusi, silakan pertimbangkan hal berikut:

1.  **Laporkan Isu (Bugs/Errors):** Jika Anda menemukan bug atau error, silakan buat laporan isu di repositori proyek (jika tersedia) dengan deskripsi yang jelas, langkah-langkah untuk mereplikasi, dan versi perangkat lunak yang digunakan.
2.  **Permintaan Fitur:** Jika Anda memiliki ide untuk fitur baru atau peningkatan fitur yang sudah ada, silakan ajukan sebagai permintaan fitur.
3.  **Pull Request:**
    * Fork repositori ini.
    * Buat branch baru untuk fitur atau perbaikan Anda (`git checkout -b nama-fitur-atau-perbaikan`).
    * Lakukan perubahan dan commit (`git commit -m 'Menambahkan fitur X'`).
    * Push ke branch Anda (`git push origin nama-fitur-atau-perbaikan`).
    * Buat Pull Request baru.

Pastikan kode Anda mengikuti standar coding yang ada dan menyertakan dokumentasi yang relevan jika diperlukan.
