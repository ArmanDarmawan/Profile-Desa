<?php 
include 'template/header.php'; 
include '../db/connection.php'; 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Lowongan Kerja</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLokerModal">
            <i class="fas fa-plus"></i> Tambah Loker Baru
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
            $message = '<strong>Sukses!</strong> Lowongan kerja baru berhasil ditambahkan.';
            $alert_type = 'success';
            break;
        case 'gagal_tambah':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat menambahkan lowongan kerja. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'sukses_edit':
            $message = '<strong>Sukses!</strong> Lowongan kerja berhasil diperbarui.';
            $alert_type = 'success';
            break;
        case 'gagal_edit':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat memperbarui lowongan kerja. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'sukses_hapus':
            $message = '<strong>Sukses!</strong> Lowongan kerja berhasil dihapus.';
            $alert_type = 'success';
            break;
        case 'gagal_hapus':
            $message = '<strong>Gagal!</strong> Terjadi kesalahan saat menghapus lowongan kerja. ' . (isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '');
            $alert_type = 'danger';
            break;
        case 'gagal_upload':
        case 'gagal_upload_edit':
            $message = '<strong>Gagal!</strong> Gagal mengunggah file gambar.';
            $alert_type = 'danger';
            break;
        case 'gagal_ukuran':
        case 'gagal_ukuran_edit':
            $message = '<strong>Gagal!</strong> Ukuran file gambar terlalu besar (Maks 2MB).';
            $alert_type = 'danger';
            break;
        case 'gagal_tipe':
        case 'gagal_tipe_edit':
            $message = '<strong>Gagal!</strong> Tipe file gambar tidak diizinkan (Hanya JPG, JPEG, PNG).';
            $alert_type = 'danger';
            break;
        case 'id_tidak_ada':
            $message = '<strong>Error!</strong> ID Loker tidak ditemukan.';
            $alert_type = 'warning';
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
        Daftar Lowongan Kerja
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan/Usaha</th>
                        <th>Jenis Usaha</th>
                        <th>Alamat</th>
                        <th>Pendaftar</th>
                        <th>Tanggal Posting</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_loker = "SELECT * FROM loker ORDER BY id DESC";
                    $query_loker = mysqli_query($connection, $sql_loker);
                    $no = 1;
                    if (mysqli_num_rows($query_loker) > 0) {
                        while ($row = mysqli_fetch_assoc($query_loker)) {
                            // Mengambil path foto, jika tidak ada foto, gunakan placeholder
                            $foto_path = !empty($row['foto']) ? '../img/upload/' . htmlspecialchars($row['foto']) : 'https://placehold.co/100x100/E0E0E0/757575?text=No+Image';
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nm_perusahaan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis_usaha']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                            echo "<td><a href='view_pendaftar_loker.php?id_loker=" . $row['id'] . "' class='btn btn-sm btn-outline-info'><i class='fas fa-users'></i> " . htmlspecialchars($row['pendaftar']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($row['tgl']) . " " . htmlspecialchars($row['bln']) . "</td>";
                            echo "<td><img src='" . $foto_path . "' alt='Foto " . htmlspecialchars($row['nm_perusahaan']) . "' style='width: 70px; height: 70px; object-fit: cover; border-radius: 4px;' onerror='this.onerror=null;this.src=\"https://placehold.co/100x100/E0E0E0/757575?text=Error\";'></td>";
                            echo "<td>
                                    <button type='button' class='btn btn-sm btn-warning btn-edit-loker mb-1' 
                                        data-id='".$row['id']."' 
                                        data-nama_perusahaan='".htmlspecialchars($row['nm_perusahaan'], ENT_QUOTES)."' 
                                        data-jenis_usaha='".htmlspecialchars($row['jenis_usaha'], ENT_QUOTES)."' 
                                        data-syarat='".htmlspecialchars($row['syarat'], ENT_QUOTES)."' 
                                        data-alamat='".htmlspecialchars($row['alamat'], ENT_QUOTES)."'
                                        data-foto='".htmlspecialchars($row['foto'], ENT_QUOTES)."'
                                        data-toggle='modal' data-target='#editLokerModal'>
                                        <i class='fas fa-edit'></i> Edit
                                    </button>
                                    <a href='hapus_loker.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger mb-1' onclick='return confirm(\"Apakah Anda yakin ingin menghapus loker ini beserta semua data pendaftarnya?\")'><i class='fas fa-trash'></i> Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Belum ada lowongan kerja yang ditambahkan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addLokerModal" tabindex="-1" role="dialog" aria-labelledby="addLokerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="proses_loker.php?aksi=tambah" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLokerModalLabel">Tambah Lowongan Kerja Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nm_perusahaan">Nama Perusahaan/Usaha</label>
                        <input type="text" class="form-control" id="nm_perusahaan" name="nm_perusahaan" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_usaha">Jenis Usaha</label>
                        <input type="text" class="form-control" id="jenis_usaha" name="jenis_usaha" required>
                    </div>
                    <div class="form-group">
                        <label for="syarat">Syarat dan Ketentuan</label>
                        <textarea class="form-control" id="syarat" name="syarat" rows="4" required></textarea>
                        <small class="form-text text-muted">Pisahkan setiap syarat dengan baris baru atau koma.</small>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Perusahaan/Usaha</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto/Logo Perusahaan (Max 2MB, JPG/PNG/JPEG)</label>
                        <input type="file" class="form-control-file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg" required>
                    </div>
                    <input type="hidden" name="pendaftar" value="0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Loker</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editLokerModal" tabindex="-1" role="dialog" aria-labelledby="editLokerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="proses_loker.php?aksi=edit" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLokerModalLabel">Edit Lowongan Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_loker" id="edit_id_loker">
                    <div class="form-group">
                        <label for="edit_nm_perusahaan">Nama Perusahaan/Usaha</label>
                        <input type="text" class="form-control" id="edit_nm_perusahaan" name="nm_perusahaan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jenis_usaha">Jenis Usaha</label>
                        <input type="text" class="form-control" id="edit_jenis_usaha" name="jenis_usaha" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_syarat">Syarat dan Ketentuan</label>
                        <textarea class="form-control" id="edit_syarat" name="syarat" rows="4" required></textarea>
                        <small class="form-text text-muted">Pisahkan setiap syarat dengan baris baru atau koma.</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat Perusahaan/Usaha</label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_foto">Foto/Logo Perusahaan (Kosongkan jika tidak ingin diubah, Max 2MB, JPG/PNG/JPEG)</label>
                        <input type="file" class="form-control-file" id="edit_foto" name="foto" accept="image/jpeg,image/png,image/jpg">
                        <p class="mt-2">Foto saat ini: <br>
                            <img id="current_foto_preview" src="#" alt="Foto Saat Ini" style="max-width: 150px; max-height: 150px; margin-top: 5px; display: none; border-radius: 4px;">
                            <span id="current_foto_name" class="text-muted"></span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Loker</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Script untuk mengisi data pada modal edit loker
    $('.btn-edit-loker').on('click', function() {
        var id = $(this).data('id');
        var nama_perusahaan = $(this).data('nama_perusahaan');
        var jenis_usaha = $(this).data('jenis_usaha');
        var syarat = $(this).data('syarat');
        var alamat = $(this).data('alamat');
        var foto = $(this).data('foto'); // Nama file foto

        var modal = $('#editLokerModal');
        modal.find('#edit_id_loker').val(id);
        modal.find('#edit_nm_perusahaan').val(nama_perusahaan);
        modal.find('#edit_jenis_usaha').val(jenis_usaha);
        modal.find('#edit_syarat').val(syarat); // textarea tidak menggunakan .val() untuk html, tapi .val() untuk jQuery
        modal.find('#edit_alamat').val(alamat);
        
        modal.find('.modal-title').text('Edit Loker - ' + nama_perusahaan);

        if (foto) {
            // Tampilkan preview foto saat ini
            var fotoUrl = '../img/upload/' + foto;
            modal.find('#current_foto_preview').attr('src', fotoUrl).show();
            modal.find('#current_foto_name').text(foto);
        } else {
            modal.find('#current_foto_preview').attr('src', '#').hide();
            modal.find('#current_foto_name').text('Tidak ada foto');
        }
        // Kosongkan input file agar tidak mengirim file lama jika tidak ada file baru dipilih
        modal.find('#edit_foto').val(''); 
    });

    // Optional: Preview gambar baru yang dipilih di modal edit
    $('#edit_foto').on('change', function(event){
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('current_foto_preview');
            output.src = reader.result;
            output.style.display = 'block';
            document.getElementById('current_foto_name').textContent = event.target.files[0].name;
        };
        if(event.target.files[0]){
            reader.readAsDataURL(event.target.files[0]);
        } else {
            // Jika file dibatalkan, kembalikan ke foto lama jika ada
            var originalFoto = $('#editLokerModal').find('#current_foto_name').data('original-foto'); // Anda perlu menyimpan original foto saat modal dibuka
             if (originalFoto) {
                $('#current_foto_preview').attr('src', '../img/upload/' + originalFoto).show();
                $('#current_foto_name').text(originalFoto);
            } else {
                $('#current_foto_preview').hide();
                $('#current_foto_name').text('Tidak ada foto');
            }
        }
    });
     // Simpan nama foto original saat modal edit dibuka pertama kali
    $('#editLokerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var foto = button.data('foto');
        $(this).find('#current_foto_name').data('original-foto', foto); // Simpan nama foto original
        if (foto) {
            $('#current_foto_preview').attr('src', '../img/upload/' + foto).show();
            $('#current_foto_name').text(foto);
        } else {
            $('#current_foto_preview').attr('src', 'https://placehold.co/150x150/E0E0E0/757575?text=No+Image').show();
            $('#current_foto_name').text('Tidak ada foto');
        }
    });
});
</script>

<?php include 'template/footer.php'; ?>
