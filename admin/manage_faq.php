<?php 
include 'template/header.php'; 
include '../db/connection.php'; 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola FAQ (Pertanyaan Umum)</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFAQModal">
            <i class="fas fa-plus"></i> Tambah FAQ Baru
        </button>
    </div>
</div>

<?php
// Tampilkan notifikasi status
if(isset($_GET['status'])){
    $status = $_GET['status'];
    $message = '';
    $alert_type = 'info'; // default

    switch ($status) {
        case 'sukses_tambah':
            $message = '<strong>Sukses!</strong> FAQ baru berhasil ditambahkan.';
            $alert_type = 'success';
            break;
        case 'gagal_tambah':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat menambahkan FAQ. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'sukses_edit':
            $message = '<strong>Sukses!</strong> FAQ berhasil diperbarui.';
            $alert_type = 'success';
            break;
        case 'gagal_edit':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat memperbarui FAQ. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'sukses_hapus':
            $message = '<strong>Sukses!</strong> FAQ berhasil dihapus.';
            $alert_type = 'success';
            break;
        case 'gagal_hapus':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat menghapus FAQ. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'id_tidak_ada':
            $message = '<strong>Error!</strong> ID FAQ tidak ditemukan.';
            $alert_type = 'warning';
            break;
        default:
            $message = htmlspecialchars($status); // Menampilkan status yang tidak dikenal
            break;
    }

    if ($message) {
        echo '<div class="alert alert-'.$alert_type.' alert-dismissible fade show" role="alert">
                '.$message.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
}
?>

<div class="card">
    <div class="card-header">
        Daftar FAQ
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban (Singkat)</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_faq = "SELECT * FROM faq ORDER BY urutan ASC, id ASC";
                    $query_faq = mysqli_query($connection, $sql_faq);
                    $no = 1;
                    if (mysqli_num_rows($query_faq) > 0) {
                        while ($row = mysqli_fetch_assoc($query_faq)) {
                            // Potong jawaban jika terlalu panjang, strip HTML tags untuk preview
                            $jawaban_preview = strip_tags($row['jawaban']);
                            $jawaban_singkat = strlen($jawaban_preview) > 100 ? substr($jawaban_preview, 0, 100) . "..." : $jawaban_preview;
                            
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['pertanyaan']) . "</td>";
                            echo "<td>" . htmlspecialchars($jawaban_singkat) . "</td>";
                            echo "<td>" . htmlspecialchars($row['urutan']) . "</td>";
                            echo "<td>
                                    <button type='button' class='btn btn-sm btn-warning btn-edit-faq mb-1' 
                                        data-id='".$row['id']."' 
                                        data-pertanyaan='".htmlspecialchars($row['pertanyaan'], ENT_QUOTES)."' 
                                        data-jawaban='".htmlspecialchars($row['jawaban'], ENT_QUOTES)."' 
                                        data-urutan='".$row['urutan']."'
                                        data-toggle='modal' data-target='#editFAQModal'>
                                        <i class='fas fa-edit'></i> Edit
                                    </button>
                                    <a href='proses_faq.php?aksi=hapus&id=" . $row['id'] . "' class='btn btn-sm btn-danger mb-1' onclick='return confirm(\"Apakah Anda yakin ingin menghapus FAQ ini?\")'><i class='fas fa-trash'></i> Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Belum ada FAQ yang ditambahkan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addFAQModal" tabindex="-1" role="dialog" aria-labelledby="addFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="proses_faq.php?aksi=tambah" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFAQModalLabel">Tambah FAQ Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pertanyaan_tambah">Pertanyaan</label>
                        <input type="text" class="form-control" id="pertanyaan_tambah" name="pertanyaan" required>
                    </div>
                    <div class="form-group">
                        <label for="jawaban_tambah">Jawaban</label>
                        <textarea class="form-control" id="jawaban_tambah" name="jawaban" rows="5" required></textarea>
                         <small class="form-text text-muted">Anda bisa menggunakan tag HTML sederhana seperti &lt;br&gt; untuk baris baru, &lt;strong&gt; untuk tebal, atau &lt;ul&gt;&lt;li&gt; untuk daftar.</small>
                    </div>
                    <div class="form-group">
                        <label for="urutan_tambah">Urutan (Angka kecil tampil lebih dulu)</label>
                        <input type="number" class="form-control" id="urutan_tambah" name="urutan" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFAQModal" tabindex="-1" role="dialog" aria-labelledby="editFAQModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="proses_faq.php?aksi=edit" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFAQModalLabel">Edit FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_faq" id="edit_id_faq">
                    <div class="form-group">
                        <label for="edit_pertanyaan">Pertanyaan</label>
                        <input type="text" class="form-control" id="edit_pertanyaan" name="pertanyaan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jawaban">Jawaban</label>
                        <textarea class="form-control" id="edit_jawaban" name="jawaban" rows="5" required></textarea>
                        <small class="form-text text-muted">Anda bisa menggunakan tag HTML sederhana seperti &lt;br&gt; untuk baris baru, &lt;strong&gt; untuk tebal, atau &lt;ul&gt;&lt;li&gt; untuk daftar.</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_urutan">Urutan</label>
                        <input type="number" class="form-control" id="edit_urutan" name="urutan" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Script untuk mengisi data pada modal edit FAQ
    $('.btn-edit-faq').on('click', function() {
        var id = $(this).data('id');
        var pertanyaan = $(this).data('pertanyaan');
        var jawaban = $(this).data('jawaban'); // Ini akan berisi HTML jika ada
        var urutan = $(this).data('urutan');

        var modal = $('#editFAQModal');
        modal.find('#edit_id_faq').val(id);
        modal.find('#edit_pertanyaan').val(pertanyaan);
        // Untuk textarea, .val() akan menghandle HTML dengan benar
        modal.find('#edit_jawaban').val(jawaban); 
        modal.find('#edit_urutan').val(urutan);
        
        modal.find('.modal-title').text('Edit FAQ - Pertanyaan ID: ' + id);
    });

    // Optional: Reset form tambah saat modal ditutup
    $('#addFAQModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });
});
</script>

<?php include 'template/footer.php'; ?>
