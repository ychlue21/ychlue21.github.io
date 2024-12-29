<?php
include('header.php');
$iduser = $_SESSION['user_id'];
$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
?>
<!-- Tambahkan ini di bagian <head> dari file HTML Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <h2 class="title text-center mb-4">Daftar Pengajuan Surat Keluar</h2>

    <div class="button-container mb-4 justify-content-end">
        <form action="" method="GET" class="d-flex align-items-center">
            <label for="cari" class="form-label mb-0 me-2">Filter:</label>
            <input type="date" name="cari" class="form-control me-2" id="cari">
            <input type="submit" value="Filter" name="filter" class="btn btn-outline-success">
        </form>
    </div>
    <table class="table table-bordered border-dark">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Pengusul</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Status Kepala Seksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;
           
                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                    $berkas = mysqli_query($koneksi, "SELECT * from surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_stafsurat='disetujui' and Status_kasi !='diproses' and berkaspengajuansuratkeluar.tanggalpengajuan like '%" . $cari . "%' LIMIT $limit OFFSET $offset");
                    $count_berkas = "SELECT COUNT(*) AS total from surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_stafsurat='disetujui' and Status_kasi !='diproses' and berkaspengajuansuratkeluar.tanggalpengajuan like '%" . $cari . "%'";
                } else {
                    $berkas = mysqli_query($koneksi, "SELECT * from surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_stafsurat='disetujui' and Status_kasi !='diproses' LIMIT $limit OFFSET $offset");
                    $count_berkas = "SELECT COUNT(*) AS total from surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_stafsurat='disetujui' and Status_kasi !='diproses'";
                }
 $total_result = mysqli_query($koneksi, $count_berkas);
                $total = mysqli_fetch_assoc($total_result)['total'];
                $pages = ceil($total / $limit);
                if (mysqli_num_rows($berkas) > 0) {
                    while ($p = mysqli_fetch_array($berkas)) {
                ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?= ucwords(strtolower($p['namalengkap'])) ?></td>
                <td><?= ucwords(strtolower($p['jenissurat'])) ?></td>
                <td><?= ucwords(strtolower($p['tanggalpengajuan'])) ?></td>
                <td><?= ucwords(strtolower($p['Status_kasi'])) ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-info btn-sm square-btn"
                            onclick="window.location='detailpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-info"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='setujuipengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-check"></i>
                        </button>
                        <!-- <button class="btn btn-danger square-btn"
                            onclick="window.location='tolakpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <k class="fas fa-times"></k>
                        </button> -->
                        <!-- <button class="btn btn-primary square-btn"
                            onclick="konfirmasiStatus('<?= $p['idberkassurat'] ?>', '<?= $p['Status_kasi'] ?>')">
                            <i class="fas fa-check"></i>
                        </button>


                        <script>
                        function konfirmasiStatus(idberkassurat, currentStatus) {
                            let newStatus, confirmationText;

                            // Menentukan status baru dan teks konfirmasi berdasarkan status saat ini
                            if (currentStatus === 'Ditolak') {
                                newStatus = 'Disetujui';
                                confirmationText = 'Ingin mengubah status menjadi Disetujui?';
                            } else {
                                newStatus = 'Ditolak';
                                confirmationText = 'Ingin mengubah status menjadi Ditolak?';
                            }

                            // Menampilkan konfirmasi untuk pengubahan status
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: confirmationText,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, ubah',
                                cancelButtonText: 'Batal',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Mengarahkan ke halaman konfirmasi_suratkeluar.php dengan parameter status yang baru
                                    if (newStatus === 'Disetujui') {
                                        // Jika status disetujui, arahkan ke pengajuanwarga.php
                                        window.location.href =
                                            `konfirmasi_suratkeluar.php?idberkassurat=${idberkassurat}&Status_kasi=${newStatus}&redirect=pengajuanwarga.php`;
                                    } else {
                                        // Jika status ditolak, arahkan ke keterangan.php
                                        window.location.href =
                                            `konfirmasi_suratkeluar.php?idberkassurat=${idberkassurat}&Status_kasi=${newStatus}&redirect=keterangan.php?idberkassurat=${idberkassurat}`;
                                    }
                                }
                            });
                        }
                        </script> -->

                    </div>
                </td>


            </tr>
            <?php 
                    } 
                } else { ?>
            <tr>
                <td colspan="10" class="text-center">Belum Ada Pengajuan Surat</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= isset($cari) ? '&cari=' . $cari : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php if (isset($_GET['cari'])) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='pengajuanwarga.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php
include('footer.php');
?>