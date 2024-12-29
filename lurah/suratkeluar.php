<?php
include('header.php');
// $iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$status_surat = isset($_GET['status_surat']) ? $_GET['status_surat'] : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL

// Membuat query total data untuk menghitung jumlah halaman
$totalDataQuery = "SELECT COUNT(*) AS total FROM surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_kasi='disetujui' ";
    
// Tambahkan filter jika diisi
if (!empty($cari)) {
    $totalDataQuery .= " AND tanggalpengajuan LIKE '%$cari%'";
}
if (!empty($status_surat)) {
    $totalDataQuery .= " AND status_surat = '$status_surat'";
}

$totalDataResult = mysqli_query($koneksi, $totalDataQuery);
$totalDataRow = mysqli_fetch_assoc($totalDataResult);
$totalData = $totalDataRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung jumlah halaman

// Membuat query untuk data dengan filter
$query = "SELECT * from surat_keluar join berkaspengajuansuratkeluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat join warga on warga.NIK=berkaspengajuansuratkeluar.nik where berkaspengajuansuratkeluar.status_kasi='disetujui' ";

// Tambahkan filter jika diisi
if (!empty($cari)) {
    $query .= " AND tanggalpengajuan LIKE '%$cari%'";
}
if (!empty($status_surat)) {
    $query .= " AND status_surat = '$status_surat'";
}

// Tambahkan limit dan offset untuk paginasi
$query .= " ORDER BY idberkassurat DESC LIMIT $limit OFFSET $offset";

$result = mysqli_query($koneksi, $query);
?>
<!-- Tambahkan ini di bagian <head> dari file HTML Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <h2 class="title text-center mb-4">Konfirmasi Surat Warga</h2>
    <div class="d-flex justify-content-end mb-3">
        <div class="filter-container p-3">
            <h5 class="text-center">Filter Data</h5>
            <form action="" method="GET" class="d-flex flex-column mb-2">
                <div class="d-flex align-items-center mb-2">
                    <label for="tanggal" class="form-label me-2">Tanggal Pengajuan:</label>
                    <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal"
                        value="<?= $cari ?>">
                    <input type="submit" value="Filter" name="filter" class="btn btn-light">
                </div>
                <div class="d-flex align-items-center">
                    <label for="status" class="form-label me-2">Status:</label>
                    <select name="status_surat" class="form-select me-2 flex-grow-1" id="status">
                        <option value="">Pilih Status</option>
                        <option value="Diproses"
                            <?= (isset($_GET['status_surat']) && $_GET['status_surat'] == 'Diproses') ? 'selected' : ''; ?>>
                            Diproses</option>
                        <option value="Diterima"
                            <?= (isset($_GET['status_surat']) && $_GET['status_surat'] == 'Diterima') ? 'selected' : ''; ?>>
                            Diterima</option>
                        <option value="Ditolak"
                            <?= (isset($_GET['status_surat']) && $_GET['status_surat'] == 'Ditolak') ? 'selected' : ''; ?>>
                            Ditolak</option>
                    </select>
                    <input type="submit" value="Filter" name="filter" class="btn btn-light">
                </div>
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
                <th>Status Surat</th>
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
                <td><?= ucwords(strtolower($p['status_surat'])) ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary btn-sm square-btn"
                            onclick="window.location='detailpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-info"></i>
                        </button>
                        <button class="btn btn-info btn-sm square-btn"
                            onclick="window.location='lihatsuratkeluar.php?filesurat=<?= $p['filesurat'] ?>'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='setujuipengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-danger square-btn"
                            onclick="window.location='tolakpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <k class="fas fa-times"></k>
                        </button>
                        <!-- <button class="btn btn-warning square-btn"
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
                                        `konfirmasi_suratkeluar.php?idberkassurat=${idberkassurat}&status_surat=diterima`;
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Jika pengguna memilih "Tolak"
                                    window.location.href =
                                        `konfirmasi_suratkeluar.php?idberkassurat=${idberkassurat}&status_surat=ditolak`;
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
    <!-- Pagination -->
    <!-- Navigasi Halaman -->
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?><?= isset($cari) ? '&cari=' . $cari : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>


    <?php if (!empty($cari) || !empty($_GET['status_surat'])) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='suratkeluar.php'">Kembali</button>
    </div>
    <?php } ?>
    <!-- <?php
    $totalSuratKeluar = mysqli_query($koneksi, "SELECT COUNT(*) AS total from  surat_keluar join `berkaspengajuansuratkeluar` on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar 
join jenissurat on jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
join warga on warga.NIK=berkaspengajuansuratkeluar.NIK where status_kasi='disetujui'");
    $totalRows = mysqli_fetch_assoc($totalSuratKeluar)['total'];
    $totalPages = ceil($totalRows / $limit);
    ?>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&cari=<?= $cari ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php if (isset($_GET['cari'])) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='suratkeluar.php'">Kembali</button>
    </div>
    <?php } ?> -->
</main>

<?php
include('footer.php');
?>