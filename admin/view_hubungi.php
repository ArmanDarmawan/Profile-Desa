<?php 
include 'template/header.php'; 
include '../db/connection.php'; 

$pesan_notif = '';
$tipe_notif = 'info'; // Default

// Handle aksi
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id_pesan = (int)$_GET['id'];

    if ($id_pesan > 0) {
        if ($_GET['aksi'] == 'tandai_baca') {
            $sql_update_status = "UPDATE pesan_masuk SET status_baca = 1 WHERE id = '$id_pesan'";
            if (mysqli_query($connection, $sql_update_status)) {
                if (mysqli_affected_rows($connection) > 0) {
                    $pesan_notif = "Pesan berhasil ditandai sudah dibaca.";
                    $tipe_notif = "success";
                } else {
                    $pesan_notif = "Pesan sudah ditandai dibaca sebelumnya atau ID tidak ditemukan.";
                    $tipe_notif = "info";
                }
            } else {
                $pesan_notif = "Gagal menandai pesan. Error: " . htmlspecialchars(mysqli_error($connection));
                $tipe_notif = "danger";
            }
        } elseif ($_GET['aksi'] == 'hapus_pesan') {
            $sql_delete_pesan = "DELETE FROM pesan_masuk WHERE id = '$id_pesan'";
            if (mysqli_query($connection, $sql_delete_pesan)) {
                if (mysqli_affected_rows($connection) > 0) {
                    $pesan_notif = "Pesan berhasil dihapus.";
                    $tipe_notif = "success";
                } else {
                    $pesan_notif = "Pesan tidak ditemukan atau sudah dihapus.";
                    $tipe_notif = "warning";
                }
            } else {
                $pesan_notif = "Gagal menghapus pesan. Error: " . htmlspecialchars(mysqli_error($connection));
                $tipe_notif = "danger";
            }
        }
    } else {
        $pesan_notif = "ID Pesan tidak valid.";
        $tipe_notif = "danger";
    }
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Lihat Pesan Masuk</h1>
</div>

<?php if ($pesan_notif): ?>
    <div class="alert alert-<?php echo $tipe_notif; ?> alert-dismissible fade show" role="alert">
        <?php echo $pesan_notif; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-envelope-open-text"></i> Daftar Pesan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Tanggal Terima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_pesan = "SELECT * FROM pesan_masuk ORDER BY tanggal_terima DESC";
                    $query_pesan = mysqli_query($connection, $sql_pesan);
                    $no = 1;
                    if (mysqli_num_rows($query_pesan) > 0) {
                        while ($pesan = mysqli_fetch_assoc($query_pesan)) {
                            $status_baca_badge = $pesan['status_baca'] == 1 
                                ? '<span class="badge badge-success">Sudah Dibaca</span>' 
                                : '<span class="badge badge-warning">Belum Dibaca</span>';
                            
                            $row_style = $pesan['status_baca'] == 0 ? "font-weight:bold;" : "";

                            echo "<tr style='".$row_style."'>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($pesan['nama']) . "</td>";
                            echo "<td><a href='mailto:" . htmlspecialchars($pesan['email']) . "'>" . htmlspecialchars($pesan['email']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($pesan['subjek']) . "</td>";
                            echo "<td>" . date('d M Y, H:i', strtotime($pesan['tanggal_terima'])) . "</td>";
                            echo "<td>" . $status_baca_badge . "</td>";
                            echo "<td>
                                    <button type='button' class='btn btn-sm btn-info btn-lihat-pesan mb-1' 
                                        data-idpesan='".$pesan['id']."'
                                        data-nama='".htmlspecialchars($pesan['nama'], ENT_QUOTES)."' 
                                        data-email='".htmlspecialchars($pesan['email'], ENT_QUOTES)."'
                                        data-subjek='".htmlspecialchars($pesan['subjek'], ENT_QUOTES)."'
                                        data-pesan='".htmlspecialchars($pesan['pesan'], ENT_QUOTES)."'
                                        data-tanggal='".date('d M Y, H:i', strtotime($pesan['tanggal_terima']))."'
                                        data-statusbaca='".$pesan['status_baca']."'
                                        data-toggle='modal' data-target='#lihatPesanModal'>
                                        <i class='fas fa-eye'></i> Lihat
                                    </button>
                                    <a href='view_hubungi.php?aksi=hapus_pesan&id=" . $pesan['id'] . "' class='btn btn-sm btn-danger mb-1' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesan ini?\")'><i class='fas fa-trash'></i> Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'><div class='alert alert-info'><i class='fas fa-info-circle'></i> Tidak ada pesan masuk saat ini.</div></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="lihatPesanModal" tabindex="-1" role="dialog" aria-labelledby="lihatPesanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lihatPesanModalLabel">Detail Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">Dari:</dt>
                    <dd class="col-sm-9"><span id="modal_nama_pengirim"></span> (<a href="#" id="modal_email_link"><span id="modal_email_pengirim"></span></a>)</dd>

                    <dt class="col-sm-3">Tanggal:</dt>
                    <dd class="col-sm-9"><span id="modal_tanggal_terima"></span></dd>

                    <dt class="col-sm-3">Subjek:</dt>
                    <dd class="col-sm-9"><span id="modal_subjek_pesan"></span></dd>
                </dl>
                <hr>
                <p><strong>Isi Pesan:</strong></p>
                <div id="modal_isi_pesan" style="white-space: pre-wrap; background-color: #f9f9f9; border: 1px solid #eee; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;"></div>
            </div>
            <div class="modal-footer justify-content-between">
                <div id="tandaiBacaContainer">
                    </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-lihat-pesan').on('click', function() {
        var id_pesan = $(this).data('idpesan');
        var nama = $(this).data('nama');
        var email = $(this).data('email');
        var subjek = $(this).data('subjek');
        var pesan = $(this).data('pesan'); // Ini sudah di-htmlspecialchars dari PHP
        var tanggal = $(this).data('tanggal');
        var statusbaca = $(this).data('statusbaca');

        var modal = $('#lihatPesanModal');
        modal.find('#modal_nama_pengirim').text(nama);
        modal.find('#modal_email_pengirim').text(email);
        modal.find('#modal_email_link').attr('href', 'mailto:' + email);
        modal.find('#modal_subjek_pesan').text(subjek);
        modal.find('#modal_isi_pesan').html(pesan.replace(/\n/g, '<br>')); // Ganti newline dengan <br> untuk tampilan HTML, .text() untuk keamanan XSS jika pesan murni teks
        modal.find('#modal_tanggal_terima').text(tanggal);

        var tandaiBacaContainer = modal.find('#tandaiBacaContainer');
        tandaiBacaContainer.empty(); // Kosongkan container

        if (statusbaca == 0) { // Jika belum dibaca
            var linkTandaiBaca = $('<a></a>')
                .attr('href', 'view_hubungi.php?aksi=tandai_baca&id=' + id_pesan)
                .addClass('btn btn-success')
                .html('<i class="fas fa-check-square"></i> Tandai Sudah Dibaca');
            tandaiBacaContainer.append(linkTandaiBaca);
        }
    });

    // Untuk me-refresh halaman setelah modal ditutup JIKA tombol "Tandai Baca" diklik
    // Ini akan memastikan status di tabel utama terupdate.
    $('#lihatPesanModal').on('click', '#tandaiBacaContainer a.btn-success', function() {
        // Tidak perlu event.preventDefault() karena kita ingin linknya bekerja
        // Setelah link diklik dan halaman di-redirect, kita ingin modal ditutup
        // dan halaman di-refresh. Bootstrap akan handle penutupan modal.
        // Untuk memastikan refresh, kita bisa tambahkan timeout kecil sebelum reload.
        setTimeout(function(){
             $('#lihatPesanModal').modal('hide'); // Tutup modal secara manual
        }, 100); // Waktu singkat untuk memastikan link diproses
    });

    // Jika ingin reload halaman setelah modal ditutup, terlepas dari aksi di dalam modal:
    /*
    $('#lihatPesanModal').on('hidden.bs.modal', function (e) {
        // Cek apakah ada perubahan yang mungkin memerlukan reload
        // Misalnya, jika tombol "Tandai Baca" ada dan diklik
        if ($('#tandaiBacaContainer').find('a.btn-success').length === 0 && $(this).data('statusbaca_awal') == 0) {
             // Jika tombol tandai baca sudah tidak ada (karena sudah diklik) dan status awal adalah belum dibaca
             // window.location.reload();
        }
        // Simpan status awal saat modal dibuka
    }).on('show.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var statusbaca = button.data('statusbaca');
        $(this).data('statusbaca_awal', statusbaca);
    });
    */
});
</script>

<?php include 'template/footer.php'; ?>
