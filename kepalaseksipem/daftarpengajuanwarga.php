<?php
include('header.php');
$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Tambahkan ini di bagian <head> dari file HTML Anda
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>

<main class="content">
    <h2 class="title text-center mb-4">Konfirmasi Surat Warga</h2>
    <div class="button-container mb-4 justify-content-end">
        <form action="" method="GET" class="d-flex align-items-center">
            <label for="cari" class="form-label mb-0 me-2">Filter:</label>
            <input type="date" name="cari" class="form-control me-2" id="cari" value="<?= htmlspecialchars($cari) ?>">
            <input type="submit" value="Filter" name="filter" class="btn btn-outline-success">
        </form>
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

            if (isset($_GET['cari']) && !empty($cari)) {
                $berkas = mysqli_query($koneksi, "SELECT * FROM surat_keluar 
                    JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar 
                    JOIN jenissurat ON jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.NIK=berkaspengajuansuratkeluar.nik 
                    WHERE berkaspengajuansuratkeluar.status_stafsurat='disetujui' 
                    AND status_kasi='diproses' 
                    AND berkaspengajuansuratkeluar.tanggalpengajuan LIKE '%" . mysqli_real_escape_string($koneksi, $cari) . "%' 
                    ORDER BY konfirmasi_stafsurat DESC 
                    LIMIT $limit OFFSET $offset");
                
                $count_berkas = "SELECT COUNT(*) AS total FROM surat_keluar 
                    JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar 
                    JOIN jenissurat ON jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.NIK=berkaspengajuansuratkeluar.nik 
                    WHERE berkaspengajuansuratkeluar.status_stafsurat='disetujui' 
                    AND status_kasi='diproses' 
                    AND berkaspengajuansuratkeluar.tanggalpengajuan LIKE '%" . mysqli_real_escape_string($koneksi, $cari) . "%'";
            } else {
                $berkas = mysqli_query($koneksi, "SELECT surat_keluar.filesurat, berkaspengajuansuratkeluar.idberkassurat, 
                    jenissurat.jenissurat, warga.namalengkap, berkaspengajuansuratkeluar.tanggalpengajuan 
                    FROM surat_keluar 
                    JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar 
                    JOIN jenissurat ON jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.NIK=berkaspengajuansuratkeluar.nik 
                    WHERE berkaspengajuansuratkeluar.status_stafsurat='disetujui' 
                    AND status_kasi='diproses' 
                    ORDER BY konfirmasi_stafsurat DESC 
                    LIMIT $limit OFFSET $offset");
                
                $count_berkas = "SELECT COUNT(*) AS total FROM surat_keluar 
                    JOIN berkaspengajuansuratkeluar ON berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar 
                    JOIN jenissurat ON jenissurat.idJenisSurat=berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.NIK=berkaspengajuansuratkeluar.nik 
                    WHERE berkaspengajuansuratkeluar.status_stafsurat='disetujui' 
                    AND status_kasi='diproses'";
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
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-info btn-sm square-btn"
                            onclick="window.location='detailpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-info"></i>
                        </button>
                        <button class="btn btn-primary btn-sm square-btn"
                            onclick="window.location='lihatsuratkeluar.php?filesurat=<?= $p['filesurat'] ?>'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='setujuipengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-danger square-btn"
                            onclick="window.location='tolakpengajuan.php?idberkassurat=<?= $p['idberkassurat'] ?>'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php 
                } 
            } else { ?>
            <tr>
                <td colspan="5" class="text-center">Belum Ada Pengajuan Surat</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?><?= isset($cari) ? '&cari=' . htmlspecialchars($cari) : '' ?>">
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
            onclick="window.location='daftarpengajuanwarga.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php
include('footer.php');
?>