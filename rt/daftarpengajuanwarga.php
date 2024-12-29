<?php
include('header.php'); 
$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah baris per halaman

// Cek halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset

// Query total data untuk menghitung jumlah halaman
$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total 
    FROM berkaspengajuansuratkeluar
    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat
    JOIN warga ON warga.NIK = berkaspengajuansuratkeluar.NIK
    JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%')
    JOIN ketua_rt ON ketua_rt.idrt = rt.idrt
    WHERE ketua_rt.iduser = '$iduser' AND status_rt = 'diproses'
");
$totalDataRow = mysqli_fetch_assoc($totalDataQuery);
$totalData = $totalDataRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung jumlah halaman
?>

<!-- Tambahkan ini di bagian <head> dari file HTML Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <h2 class="title text-center mb-4">Konfirmasi Pengajuan Warga</h2>

    <div class="d-flex justify-content-end mb-3">
        <!-- Filter Data -->
        <div class="filter-container p-3 ">
            <form action="" method="GET" class="d-flex align-items-center">
                <label for="tanggal" class="form-label me-2">Tanggal Pengajuan:</label>
                <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal"
                    value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                <input type="submit" value="Filter" name="filter" class="btn btn-light">
            </form>
        </div>
    </div>

    <table class="table table-bordered border-dark ">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Pengusul</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;

            // Query utama untuk data dengan pagination
            if (isset($_GET['cari'])) {
                $cari = $_GET['cari'];
                $berkas = mysqli_query($koneksi, "
                    SELECT * 
                    FROM berkaspengajuansuratkeluar
                    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat
                    JOIN warga ON warga.NIK = berkaspengajuansuratkeluar.NIK
                    JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%')
                    JOIN ketua_rt ON ketua_rt.idrt = rt.idrt
                    WHERE ketua_rt.iduser = '$iduser' AND tanggalpengajuan LIKE '%$cari%'
                    ORDER BY tanggalpengajuan DESC
                    LIMIT $limit OFFSET $offset
                ");
            } else {
                $berkas = mysqli_query($koneksi, "
                    SELECT * 
                    FROM berkaspengajuansuratkeluar
                    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat
                    JOIN warga ON warga.NIK = berkaspengajuansuratkeluar.NIK
                    JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%')
                    JOIN ketua_rt ON ketua_rt.idrt = rt.idrt
                    WHERE ketua_rt.iduser = '$iduser' AND status_rt = 'diproses'
                    ORDER BY tanggalpengajuan DESC
                    LIMIT $limit OFFSET $offset
                ");
            }

            if (mysqli_num_rows($berkas) > 0) {
                while ($p = mysqli_fetch_array($berkas)) {
            ?>
            <tr>
                <td class="text-center"><?= $nomor++ ?></td>
                <td><?= ucwords(strtolower($p['namalengkap'])) ?></td>
                <td class="text-center"><?= ucwords(strtolower($p['jenissurat'])) ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($p['tanggalpengajuan'])) ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary btn-sm square-btn"
                            onclick="window.location='detailpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-info"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='setujuipengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-danger square-btn"
                            onclick="window.location='tolakpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <k class="fas fa-times"></k>
                        </button>
                        <!-- <button class="btn btn-success square-btn"
                            onclick="konfirmasiStatus('<?= $p['idberkassurat'] ?>')">
                            <i class="fas fa-check"></i>
                        </button>
                        <script>
                        function konfirmasiStatus(idberkassurat) {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "Ingin menyetujui atau menolak pengajuan surat?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Setuju',
                                cancelButtonText: 'Tolak',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika pengguna memilih "Setuju"
                                    window.location.href =
                                        `konfirmasi.php?idberkassurat=${idberkassurat}&status_rt=disetujui`;
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Jika pengguna memilih "Tolak"
                                    window.location.href =
                                        `konfirmasi.php?idberkassurat=${idberkassurat}&status_rt=ditolak`;
                                }
                            });
                        }
                        </script> -->

                    </div>
                </td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="10" class="text-center">Belum Ada Pengajuan Surat</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&cari=<?= isset($cari) ? urlencode($cari) : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <?php if (!empty($cari)) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='daftarpengajuanwarga.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php include('footer.php'); ?>