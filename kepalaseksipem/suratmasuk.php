<?php
include('header.php');
require('../config/config.php');

$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

?>

<main class="content">
    <h2 class="title text-center mb-4">Surat Masuk</h2>
    <div class="d-flex justify-content-end mb-3">
        <div class="filter-container p-3">
            <h5 class="text-center">Filter Data</h5>
            <form action="" method="GET" class="d-flex flex-column mb-2">
                <div class="d-flex align-items-center mb-2">
                    <label for="tanggal" class="form-label me-2">Tanggal Pengajuan:</label>
                    <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal"
                        value="<?= $cari ?>">
                    <input type="submit" value="Filter" name="filter" class="btn btn-outline-success">
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered border-dark">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>No.Surat</th>
                <th>Tanggal</th>
                <th>Tujuan</th>
                <th>Disposisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;
            $query = "SELECT nosuratmasuk, tanggalsurat, tujuan, isiDisposisi, disposisi.status, filesurat 
                      FROM disposisi 
                      JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                      JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai 
                      JOIN user ON user.id_user = pegawai.iduser 
                      WHERE user.id_user = '$iduser' ";
            if ($cari) {
                $query .= "AND tanggalsurat = '$cari' ";
            }
            $query .= "ORDER BY tanggalsurat DESC LIMIT $limit OFFSET $offset";
            $suratmasuk = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($suratmasuk) > 0) {
                while ($p = mysqli_fetch_array($suratmasuk)) {
                    ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?= $p['nosuratmasuk'] ?></td>
                <td><?= $p['tanggalsurat'] ?></td>
                <td><?= $p['tujuan'] ?></td>
                <td><?= $p['isiDisposisi'] ?></td>
                <td><?= $p['status'] ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-primary square-btn"
                            onclick="window.location='konfirmasi.php?nosuratmasuk=<?= $p['nosuratmasuk'] ?>'">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='lihatsuratmasuk.php?filesurat=<?= $p['filesurat'] ?>'">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='7'>TIDAK ADA DATA SURAT</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php
    $totalSuratMasuk = mysqli_query($koneksi, "SELECT COUNT(*) AS total 
                                               FROM disposisi 
                                               JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                                               JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai 
                                               JOIN user ON user.id_user = pegawai.iduser 
                                               WHERE user.id_user = '$iduser' " . ($cari ? "AND tanggalsurat = '$cari'" : ""));
    $totalRows = mysqli_fetch_assoc($totalSuratMasuk)['total'];
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

    <?php if ($cari) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='suratmasuk.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php
include('footer.php');
?>