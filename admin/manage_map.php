<?php 
include 'template/header.php'; 
include '../db/connection.php';

$pesan_notif = '';
$tipe_notif = 'info'; // Default

// Fungsi untuk mengambil konten peta
// Idealnya, fungsi ini (dan save_map_content) ada di file helper/functions.php
if (!function_exists('get_map_content_custom')) { // Menggunakan nama custom untuk menghindari konflik jika ada fungsi global
    function get_map_content_custom($nama_bagian, $conn) {
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

// Fungsi untuk menyimpan konten peta
if (!function_exists('save_map_content_custom')) { // Menggunakan nama custom
    function save_map_content_custom($nama_bagian, $isi_konten, $conn) {
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
    $update_berhasil_semua_peta = true;
    $fields_to_update_peta = [
        'peta_iframe_src' => $_POST['peta_iframe_src'] ?? null,
        'peta_pembagian_wilayah' => $_POST['peta_pembagian_wilayah'] ?? null,
        'peta_batas_utara' => $_POST['peta_batas_utara'] ?? null,
        'peta_batas_timur' => $_POST['peta_batas_timur'] ?? null,
        'peta_batas_selatan' => $_POST['peta_batas_selatan'] ?? null,
        'peta_batas_barat' => $_POST['peta_batas_barat'] ?? null,
    ];

    foreach ($fields_to_update_peta as $nama_bagian => $isi_konten) {
        if ($isi_konten !== null) { // Hanya update jika field ada di POST
            // Khusus untuk peta_iframe_src, validasi URL sederhana
            if ($nama_bagian === 'peta_iframe_src' && !empty($isi_konten) && !filter_var($isi_konten, FILTER_VALIDATE_URL)) {
                $pesan_notif = "Format URL untuk Embed Google Maps tidak valid.";
                $tipe_notif = "danger";
                $update_berhasil_semua_peta = false; // Tandai gagal agar tidak menyimpan field lain jika URL salah
                break; // Hentikan loop jika ada error validasi URL
            }

            if (!save_map_content_custom($nama_bagian, $isi_konten, $connection)) {
                $update_berhasil_semua_peta = false;
            }
        }
    }

    if (empty($pesan_notif)) { // Hanya set pesan sukses/gagal umum jika tidak ada pesan error spesifik (seperti URL salah)
        if ($update_berhasil_semua_peta) {
            $pesan_notif = "Konten halaman peta berhasil diperbarui.";
            $tipe_notif = "success";
        } else {
            $pesan_notif = "Gagal memperbarui sebagian atau seluruh konten peta.";
            $tipe_notif = "danger";
        }
    }
}

// Ambil konten terbaru setelah potensi update
$peta_iframe_src = get_map_content_custom('peta_iframe_src', $connection);
$pembagian_wilayah = get_map_content_custom('peta_pembagian_wilayah', $connection);
$batas_utara = get_map_content_custom('peta_batas_utara', $connection);
$batas_timur = get_map_content_custom('peta_batas_timur', $connection);
$batas_selatan = get_map_content_custom('peta_batas_selatan', $connection);
$batas_barat = get_map_content_custom('peta_batas_barat', $connection);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Konten Peta Desa</h1>
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
        <i class="fas fa-map-signs"></i> Edit Konten Peta
    </div>
    <div class="card-body">
        <form method="POST" action="manage_map.php">
            <div class="form-group">
                <label for="peta_iframe_src"><strong>Link Embed Google Maps (iframe src):</strong></label>
                <input type="url" class="form-control" id="peta_iframe_src" name="peta_iframe_src" value="<?php echo htmlspecialchars($peta_iframe_src); ?>" placeholder="Contoh: https://www.google.com/maps/embed?pb=!1m18!1m12!...">
                <small class="form-text text-muted">Salin hanya bagian URL (nilai dari atribut `src`) dari kode embed iframe Google Maps.</small>
            </div>
            <hr>
            <div class="form-group">
                <label for="pembagian_wilayah"><strong>Deskripsi Pembagian Wilayah:</strong></label>
                <textarea class="form-control" id="pembagian_wilayah" name="peta_pembagian_wilayah" rows="6" placeholder="Jelaskan pembagian wilayah administratif desa, misal per dusun atau RW/RT. Gunakan baris baru untuk setiap item."><?php echo htmlspecialchars($pembagian_wilayah); ?></textarea>
                <small class="form-text text-muted">Contoh: Dusun A, Dusun B, RW 01, RW 02, dst.</small>
            </div>
            <hr>
            <h5 class="mt-4 mb-3">Batas-Batas Wilayah Desa</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="peta_batas_utara"><strong>Batas Utara:</strong></label>
                        <input type="text" class="form-control" id="peta_batas_utara" name="peta_batas_utara" value="<?php echo htmlspecialchars($batas_utara); ?>" placeholder="Contoh: Desa Sukamaju">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="peta_batas_timur"><strong>Batas Timur:</strong></label>
                        <input type="text" class="form-control" id="peta_batas_timur" name="peta_batas_timur" value="<?php echo htmlspecialchars($batas_timur); ?>" placeholder="Contoh: Sungai Ciberem">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="peta_batas_selatan"><strong>Batas Selatan:</strong></label>
                        <input type="text" class="form-control" id="peta_batas_selatan" name="peta_batas_selatan" value="<?php echo htmlspecialchars($batas_selatan); ?>" placeholder="Contoh: Kecamatan Lain">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="peta_batas_barat"><strong>Batas Barat:</strong></label>
                        <input type="text" class="form-control" id="peta_batas_barat" name="peta_batas_barat" value="<?php echo htmlspecialchars($batas_barat); ?>" placeholder="Contoh: Hutan Lindung">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Simpan Perubahan Peta</button>
        </form>
    </div>
</div>

<?php include 'template/footer.php'; ?>
