<?php 
include 'template/header.php'; 
include '../db/connection.php';

$pesan_notif = '';
$tipe_notif = 'info'; // Default

if(isset($_GET['status'])){
    $status = $_GET['status'];
    switch ($status) {
        case 'sukses_upload':
            $pesan_notif = 'Gambar berhasil diunggah ke galeri.';
            $tipe_notif = 'success';
            break;
        case 'gagal_upload':
            $pesan_notif = 'Gagal mengunggah gambar. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $tipe_notif = 'danger';
            break;
        case 'tipe_salah':
            $pesan_notif = 'Tipe file tidak diizinkan. Hanya JPG, JPEG, PNG yang diperbolehkan.';
            $tipe_notif = 'danger';
            break;
        case 'ukuran_besar':
            $pesan_notif = 'Ukuran file terlalu besar (Maksimal 2MB).';
            $tipe_notif = 'danger';
            break;
        case 'sukses_hapus':
            $pesan_notif = 'Gambar berhasil dihapus dari galeri.';
            $tipe_notif = 'success';
            break;
        case 'gagal_hapus':
            $pesan_notif = 'Gagal menghapus gambar. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $tipe_notif = 'danger';
            break;
        case 'file_tidak_ada_atau_error':
            $pesan_notif = 'Tidak ada file yang dipilih atau terjadi error saat upload.';
            $tipe_notif = 'warning';
            break;
        case 'gagal_db':
            $pesan_notif = 'Gagal menyimpan informasi gambar ke database. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $tipe_notif = 'danger';
            break;
        case 'id_file_hilang':
            $pesan_notif = 'ID gambar atau nama file tidak ditemukan untuk proses penghapusan.';
            $tipe_notif = 'warning';
            break;
        default:
            $pesan_notif = htmlspecialchars($status);
            break;
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Galeri Desa</h1>
</div>

<?php if ($pesan_notif): ?>
    <div class="alert alert-<?php echo $tipe_notif; ?> alert-dismissible fade show" role="alert">
        <?php echo $pesan_notif; // Pesan sudah di-escape jika perlu dari switch case ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-plus"></i> Unggah Gambar Baru
    </div>
    <div class="card-body">
        <form action="proses_galeri.php?aksi=unggah" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gambar_galeri">Pilih Gambar (Max 2MB, Tipe: JPG/PNG/JPEG)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="gambar_galeri" name="gambar_galeri" accept="image/jpeg,image/png,image/jpg" required>
                    <label class="custom-file-label" for="gambar_galeri">Pilih file...</label>
                </div>
                <small class="form-text text-muted">Pastikan gambar memiliki kualitas baik dan ukuran sesuai.</small>
            </div>
            <div class="form-group">
                <label for="keterangan_galeri">Keterangan (Opsional)</label>
                <textarea class="form-control" id="keterangan_galeri" name="keterangan_galeri" rows="3" placeholder="Masukkan keterangan singkat tentang gambar"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Unggah Gambar</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
       <i class="fas fa-images"></i> Daftar Gambar Galeri
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $sql_galeri = "SELECT * FROM galeri ORDER BY tanggal_upload DESC";
            $query_galeri = mysqli_query($connection, $sql_galeri);
            if (mysqli_num_rows($query_galeri) > 0) {
                while ($item = mysqli_fetch_assoc($query_galeri)) {
                    $image_path = "../img/upload/galeri/" . htmlspecialchars($item['nama_file']);
                    $placeholder_image = "https://placehold.co/300x200/E0E0E0/757575?text=Image+Not+Found";
            ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo $image_path; ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($item['keterangan']); ?>" 
                         style="height: 200px; object-fit: cover; border-top-left-radius: 0.25rem; border-top-right-radius: 0.25rem;"
                         onerror="this.onerror=null; this.src='<?php echo $placeholder_image; ?>';">
                    <div class="card-body">
                        <?php if (!empty($item['keterangan'])): ?>
                        <p class="card-text text-small"><?php echo nl2br(htmlspecialchars($item['keterangan'])); ?></p>
                        <?php else: ?>
                        <p class="card-text text-muted text-small"><em>Tidak ada keterangan.</em></p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">Diupload: <?php echo date('d M Y, H:i', strtotime($item['tanggal_upload'])); ?></small>
                        <a href="proses_galeri.php?aksi=hapus&id=<?php echo $item['id']; ?>&file=<?php echo urlencode($item['nama_file']); ?>" 
                           class="btn btn-danger btn-sm float-right" 
                           onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='col-12'><div class='alert alert-info text-center'><i class='fas fa-info-circle'></i> Belum ada gambar di galeri. Silakan unggah gambar baru.</div></div>";
            }
            ?>
        </div>
    </div>
</div>

<script>
// Script untuk menampilkan nama file pada input file custom Bootstrap
$('.custom-file-input').on('change', function() {
   let fileName = $(this).val().split('\\').pop();
   $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

// Reset form upload saat modal ditutup (jika form ada di dalam modal)
// Jika tidak di dalam modal, script ini bisa diabaikan atau disesuaikan
/*
$('#uploadGaleriModal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
    $(this).find('.custom-file-label').html('Pilih file...');
});
*/
</script>

<?php include 'template/footer.php'; ?>
