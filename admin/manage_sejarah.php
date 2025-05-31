<?php 
include 'template/header.php'; 
// File untuk menyimpan konten sejarah
$data_dir = '../data';
$file_path = $data_dir . '/sejarah_content.txt';

$pesan_notif = '';
$tipe_notif = 'info'; // Default

// Proses penyimpanan jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['konten_sejarah'])) {
    $konten_baru = $_POST['konten_sejarah'];
    
    // Pastikan folder data ada dan dapat ditulis
    if (!is_dir($data_dir)) {
        if (!mkdir($data_dir, 0775, true)) {
            $pesan_notif = "Gagal membuat direktori 'data'. Pastikan folder induk dapat ditulis oleh server.";
            $tipe_notif = "danger";
        }
    }

    if (empty($pesan_notif)) { // Lanjutkan hanya jika direktori berhasil dibuat atau sudah ada
        if (is_writable($data_dir) || is_writable($file_path)) {
            if (file_put_contents($file_path, $konten_baru) !== false) {
                $pesan_notif = "Konten sejarah berhasil diperbarui.";
                $tipe_notif = "success";
            } else {
                $pesan_notif = "Gagal memperbarui konten sejarah. Pastikan file 'sejarah_content.txt' dapat ditulis atau direktori 'data' dapat ditulis.";
                $tipe_notif = "danger";
            }
        } else {
            $pesan_notif = "Gagal memperbarui konten sejarah. Direktori 'data' atau file 'sejarah_content.txt' tidak dapat ditulis oleh server. Periksa izin file/folder.";
            $tipe_notif = "danger";
        }
    }
}

// Baca konten sejarah yang ada
$konten_sejarah_saat_ini = '';
if (file_exists($file_path)) {
    $konten_sejarah_saat_ini = file_get_contents($file_path);
    if ($konten_sejarah_saat_ini === false) {
        $pesan_notif = "Gagal membaca konten sejarah dari file. File mungkin rusak atau tidak dapat diakses.";
        $tipe_notif = "warning";
        $konten_sejarah_saat_ini = ''; // Reset ke string kosong jika gagal baca
    }
} else {
    // Konten default jika file belum ada
    $konten_sejarah_saat_ini = "Desa Cikondang merupakan nama yang diambil dari salah satu Grumbul/Kedusunan atau ciri khas wilayah yang ada di Desa ini. Bahasa sehari-hari yang digunakan adalah Bahasa Sunda dialek Tasikmalaya. Sejarah Desa Cikondang dapat ditelusuri kembali ke era [Tahun/Peristiwa Penting] ketika [Deskripsi singkat awal mula desa atau tokoh pendiri]. [Lanjutkan dengan ringkasan sejarah Desa Cikondang].";
    // Coba buat file dengan konten default jika direktori 'data' bisa ditulis
    if (is_dir($data_dir) && is_writable($data_dir)) {
        if (file_put_contents($file_path, $konten_sejarah_saat_ini) === false) {
            // Tidak perlu menampilkan error besar di sini, pengguna akan tahu saat mencoba menyimpan
        }
    } elseif (!is_dir($data_dir)) {
        // Jika direktori data belum ada, akan ditangani saat POST
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Konten Sejarah Desa</h1>
</div>

<?php if ($pesan_notif): ?>
    <div class="alert alert-<?php echo $tipe_notif; ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($pesan_notif); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-landmark"></i> Edit Konten Sejarah
    </div>
    <div class="card-body">
        <form method="POST" action="manage_sejarah.php">
            <div class="form-group">
                <label for="konten_sejarah"><strong>Isi Konten Sejarah:</strong></label>
                <textarea class="form-control" id="konten_sejarah" name="konten_sejarah" rows="15" placeholder="Tuliskan atau tempelkan konten sejarah desa di sini..."><?php echo htmlspecialchars($konten_sejarah_saat_ini); ?></textarea>
                <small class="form-text text-muted">
                    Anda dapat menggunakan tag HTML dasar untuk format teks jika diperlukan (misalnya: 
                    &lt;strong&gt;<strong>Tebal</strong>&lt;/strong&gt;, 
                    &lt;em&gt;<em>Miring</em>&lt;/em&gt;, 
                    &lt;br&gt; untuk baris baru, 
                    &lt;p&gt;Paragraf&lt;/p&gt;,
                    &lt;ul&gt;&lt;li&gt;List item&lt;/li&gt;&lt;/ul&gt;). 
                    Konten akan ditampilkan apa adanya di halaman publik.
                </small>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php include 'template/footer.php'; ?>
