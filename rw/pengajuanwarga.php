<?php
include('header.php');
$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah baris per halaman

// Cek halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset

// Ambil filter dari parameter GET
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$status_rt = isset($_GET['status_rt']) ? $_GET['status_rt'] : '';

// Query total data untuk menghitung jumlah halaman
$totalDataQuery = "SELECT COUNT(*) AS total FROM `berkaspengajuansuratkeluar`
    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
    JOIN warga ON warga.NIK = berkaspengajuansuratkeluar.NIK 
    join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') 
    join ketua_rw on ketua_rw.idrw=rw.idrw  
    WHERE ketua_rw.iduser = '$iduser' and status_Rt!='diproses'";

// Tambahkan filter tanggal jika diisi
if (!empty($cari)) {
    $totalDataQuery .= " AND tanggalpengajuan LIKE '%$cari%'
    or konfirmasi_rt like '%$cari%'";
}

// Tambahkan filter status jika diisi
if (!empty($status_rt)) {
    $totalDataQuery .= " AND status_rt = '$status_rt'";
}

$totalDataResult = mysqli_query($koneksi, $totalDataQuery);
$totalDataRow = mysqli_fetch_assoc($totalDataResult);
$totalData = $totalDataRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung jumlah halaman

// Membuat query untuk data dengan filter ganda
$query = "SELECT * FROM berkaspengajuansuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
            JOIN warga ON warga.nik = berkaspengajuansuratkeluar.NIK join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') 
            join ketua_rw on ketua_rw.idrw=rw.idrw join rt on rt.idrw=rw.idrw join ketua_rt on ketua_rt.idrt=rt.idrt  
            WHERE ketua_rw.iduser = '$iduser' and status_Rt!='diproses'";

// Tambahkan filter tanggal jika diisi
if (!empty($cari)) {
    $query .= " AND tanggalpengajuan LIKE '%$cari%'";
}

// Tambahkan filter status jika diisi
if (!empty($status_rt)) {
    $query .= " AND status_rt = '$status_rt'";
}

// Tambahkan limit dan offset untuk paginasi
$query .= " ORDER BY konfirmasi_rt DESC LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);
?>
<!-- Tambahkan ini di bagian <head> dari file HTML Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <h2 class="title text-center mb-4">Daftar Pengajuan Surat Keluar</h2>

    <div class="d-flex justify-content-end mb-3">
        <!-- Filter Data -->
        <div class="filter-container p-3 ">
            <h5 class="text-center">Filter Data</h5>
            <form action="" method="GET" class="d-flex flex-column mb-2">
                <div class="d-flex align-items-center mb-2">
                    <label for="tanggal" class="form-label me-2">Tanggal:</label>
                    <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal"
                        value="<?= $cari ?>">
                    <input type="submit" value="Filter" name="filter" class="btn btn-outline-success">
                </div>

                <div class="d-flex align-items-center">
                    <label for="status" class="form-label me-2">Status:</label>
                    <select name="status_rt" class="form-select me-2 flex-grow-1" id="status">
                        <option value="" <?= empty($status_rt) ? 'selected' : '' ?>>Pilih Status</option>
                        <option value="Disetujui" <?= $status_rt === 'Disetujui' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="Ditolak" <?= $status_rt === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                    <input type="submit" value="Filter" name="filter" class="btn btn-outline-success">
                </div>

            </form>
        </div>
    </div>
    <table class="table table-bordered border-dark">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Pengusul</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Waktu Konfirmasi</th>
                <th>Status RT</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;
            if (mysqli_num_rows($result) > 0) {
                while ($p = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?= ucwords(strtolower($p['namalengkap'])) ?></td>
                <td><?= ucwords(strtolower($p['jenissurat'])) ?></td>
                <td><?= ucwords(strtolower($p['tanggalpengajuan'])) ?></td>
                <td class="text-center"><?= ucwords(strtolower($p['Konfirmasi_rt'])) ?></td>
                <td><?= ucwords(strtolower($p['status_rt'])) ?></td>
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
                } else { ?>
            <tr>
                <td colspan="10" class="text-center">Belum Ada Pengajuan Surat</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?>&cari=<?= urlencode($cari) ?>&status_rt=<?= urlencode($status_rt) ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <?php if (!empty($cari) || !empty($status_rt)) { ?>
    <div class="text-start mt-3">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='pengajuanwarga.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php
include('footer.php');
?>