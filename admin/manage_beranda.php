<?php 
include 'template/header.php'; 
include '../db/connection.php';

$pesan_notif = '';
$tipe_notif = 'info'; // Default

// Fungsi untuk mengambil konten
// Idealnya, fungsi ini (dan save_content) ada di file helper/functions.php agar tidak duplikasi
if (!function_exists('get_content')) {
    function get_content($nama_bagian, $conn) {
        $sql = "SELECT isi_konten FROM konten_halaman WHERE nama_bagian = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nama_bagian);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                mysqli_stmt_close($stmt);
                return $row['isi_konten'];
            }
            mysqli_stmt_close($stmt);
        }
        return ''; // Kembalikan string kosong jika tidak ada atau error
    }
}

// Fungsi untuk menyimpan konten
if (!function_exists('save_content')) {
    function save_content($nama_bagian, $isi_konten, $conn) {
        // Cek dulu apakah nama_bagian sudah ada
        $sql_check = "SELECT id FROM konten_halaman WHERE nama_bagian = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $nama_bagian);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        $exists = mysqli_num_rows($result_check) > 0;
        mysqli_stmt_close($stmt_check);

        if ($exists) {
            $sql = "UPDATE konten_halaman SET isi_konten = ? WHERE nama_bagian = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $isi_konten, $nama_bagian);
        } else {
            $sql = "INSERT INTO konten_halaman (nama_bagian, isi_konten) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $nama_bagian, $isi_konten);
        }
        
        if ($stmt) {
            $execute_success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $execute_success;
        }
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_berhasil_semua = true;
    $fields_to_update = [
        'beranda_selamat_datang' => $_POST['selamat_datang'] ?? null,
        'beranda_deskripsi_desa' => $_POST['deskripsi_desa'] ?? null,
        'beranda_kehidupan_sosial' => $_POST['kehidupan_sosial'] ?? null,
        'beranda_pembangunan_deskripsi' => $_POST['pembangunan_deskripsi'] ?? null,
    ];

    foreach ($fields_to_update as $nama_bagian => $isi_konten) {
        if ($isi_konten !== null) { // Hanya update jika field ada di POST
            if (!save_content($nama_bagian, $isi_konten, $connection)) {
                $update_berhasil_semua = false;
                // Anda bisa mencatat error spesifik per field jika perlu
                // error_log("Gagal menyimpan $nama_bagian: " . mysqli_error($connection));
            }
        }
    }

    if ($update_berhasil_semua) {
        $pesan_notif = "Konten halaman beranda berhasil diperbarui.";
        $tipe_notif = "success";
    } else {
        $pesan_notif = "Gagal memperbarui sebagian atau seluruh konten beranda. Periksa log server untuk detail.";
        $tipe_notif = "danger";
    }
}

// Ambil konten terbaru setelah potensi update
$selamat_datang = get_content('beranda_selamat_datang', $connection);
$deskripsi_desa = get_content('beranda_deskripsi_desa', $connection);
$kehidupan_sosial = get_content('beranda_kehidupan_sosial', $connection);
$pembangunan_deskripsi = get_content('beranda_pembangunan_deskripsi', $connection);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Konten Halaman Beranda</h1>
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
        <i class="fas fa-file-alt"></i> Edit Konten Beranda
    </div>
    <div class="card-body">
        <form method="POST" action="manage_beranda.php">
            <div class="form-group">
                <label for="selamat_datang"><strong>Judul Selamat Datang (di Banner)</strong></label>
                <input type="text" class="form-control" id="selamat_datang" name="selamat_datang" value="<?php echo htmlspecialchars($selamat_datang); ?>" placeholder="Contoh: Selamat Datang di Desa Cikondang">
            </div>
            <hr>
            <div class="form-group">
                <label for="deskripsi_desa"><strong>Deskripsi Singkat Desa Cikondang (di bawah banner)</strong></label>
                <textarea class="form-control" id="deskripsi_desa" name="deskripsi_desa" rows="5" placeholder="Jelaskan secara singkat tentang Desa Cikondang..."><?php echo htmlspecialchars($deskripsi_desa); ?></textarea>
                <small class="form-text text-muted">Gunakan tag &lt;br&gt; untuk baris baru jika diperlukan.</small>
            </div>
            <hr>
            <div class="form-group">
                <label for="kehidupan_sosial"><strong>Deskripsi Kehidupan Sosial</strong></label>
                <textarea class="form-control" id="kehidupan_sosial" name="kehidupan_sosial" rows="5" placeholder="Ceritakan tentang aspek kehidupan sosial di desa..."><?php echo htmlspecialchars($kehidupan_sosial); ?></textarea>
                <small class="form-text text-muted">Gunakan tag &lt;br&gt; untuk baris baru jika diperlukan.</small>
            </div>
            <hr>
            <div class="form-group">
                <label for="pembangunan_deskripsi"><strong>Deskripsi Singkat Pembangunan</strong></label>
                <textarea class="form-control" id="pembangunan_deskripsi" name="pembangunan_deskripsi" rows="3" placeholder="Sebutkan fokus atau capaian pembangunan terkini..."><?php echo htmlspecialchars($pembangunan_deskripsi); ?></textarea>
                <small class="form-text text-muted">Gunakan tag &lt;br&gt; untuk baris baru jika diperlukan.</small>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Simpan Perubahan Beranda</button>
        </form>
    </div>
</div>

<?php include 'template/footer.php'; ?>
