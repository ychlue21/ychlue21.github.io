<?php 
include('header.php'); 
// $iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah baris per halaman

// Cek halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset

// Query total data untuk menghitung jumlah halaman
$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM suratmasuk");
$totalDataRow = mysqli_fetch_assoc($totalDataQuery);
$totalData = $totalDataRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung jumlah halaman


if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
}
?>

<main class="content">
    <h2 class="title text-center mb-4">Surat Masuk</h2>

    <div class="d-flex justify-content-end mb-3">
        <!-- Filter Data -->
        <div class="filter-container p-3 ">
            <h5 class="text-center">Filter Data</h5>
            <form action="" method="GET" class="d-flex flex-column mb-2">
                <div class="d-flex align-items-center mb-2">
                    <label for="tanggal" class="form-label me-2">Tanggal Pengajuan:</label>
                    <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal">
                    <input type="submit" value="Filter" name="filter" class="btn btn-light">
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered border-dark">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>No. Surat</th>
                <th>Tanggal</th>
                <th>Asal Surat</th>
                <th>Tujuan</th>
                <th class="aksi-column">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
              $nomor = $offset + 1;
                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                    $suratmasuk = mysqli_query($koneksi, "SELECT nosuratmasuk, tanggalsurat, pengirim, tujuan, filesurat FROM suratmasuk WHERE tanggalsurat = '$cari'");
                } else {
                    $suratmasuk = mysqli_query($koneksi, "SELECT nosuratmasuk, tanggalsurat, pengirim, tujuan, filesurat FROM suratmasuk ORDER BY tanggalsurat DESC");
                }

                if (mysqli_num_rows($suratmasuk) > 0) {
                    while ($p = mysqli_fetch_array($suratmasuk)) {
                ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?= $p['nosuratmasuk'] ?></td>
                <td><?= $p['tanggalsurat'] ?></td>
                <td><?= $p['pengirim'] ?></td>
                <td><?= $p['tujuan'] ?></td>
                <td class="aksi-column">
                    <!-- Tambahkan kelas aksi-column -->
                    <div class="action-buttons">
                        <button class="btn btn-info square-btn"
                            onclick="window.location='lihatsuratmasuk.php?filesurat=<?= $p['filesurat'] ?>'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-success square-btn"
                            onclick="window.location='tambahdisposisi.php?nosuratmasuk=<?= $p['nosuratmasuk'] ?>'">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>

            </tr>
            <?php 
                    }
                } else { ?>
            <tr>
                <td colspan="5" class="text-center">TIDAK ADA DATA SURAT</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Pagination Links -->
    <!-- <div class="pagination d-flex justify-content-center">
        <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="btn btn-outline-secondary me-2">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>"
            class="btn <?= $i == $page ? 'btn-primary' : 'btn-outline-primary' ?> me-2"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="btn btn-outline-secondary">Next</a>
        <?php endif; ?>
    </div> -->
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

    <?php if (!empty($cari)) { ?>
    <div class="text-start">
        <button type="button" class="btn btn-outline-secondary"
            onclick="window.location='suratmasuk.php'">Kembali</button>
    </div>
    <?php } ?>

</main>

<?php include('footer.php'); ?>