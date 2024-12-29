<?php
include('header.php');
require('../config/config.php');
// $iduser = $_SESSION['user_id'];

$limit = 5; // Jumlah baris per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Menghitung total halaman
    $totalWargaQuery = "SELECT COUNT(*) AS total FROM warga 
                                            JOIN rw ON warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') 
                                            JOIN ketua_rw ON ketua_rw.idrw = rw.idrw            
                                            JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') 
                                            WHERE ketua_rw.iduser = '$iduser'";

        // Tambahkan filter pencarian
        if ($cari) {
            $totalWargaQuery .= " AND (warga.namalengkap LIKE '%$cari%' 
                                    OR warga.NIK LIKE '%$cari%' 
                                    OR warga.NOKK LIKE '%$cari%' 
                                    OR warga.alamat LIKE '%$cari%')";
        }

$totalWarga = mysqli_query($koneksi, $totalWargaQuery);
$totalRows = mysqli_fetch_assoc($totalWarga)['total'];
$totalPages = ceil($totalRows / $limit);


    $query = "SELECT WARGA.NIK, WARGA.NOKK, namalengkap, JK, alamat, RT.NAMA_RT 
                      FROM warga 
                      JOIN rw ON warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') 
                      JOIN ketua_rw ON ketua_rw.idrw = rw.idrw 
                      JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') 
                      WHERE ketua_rw.iduser = '$iduser' ";
            if ($cari) {
                $query .= "AND (warga.namalengkap LIKE '%$cari%' OR warga.NIK LIKE '%$cari%' OR warga.NOKK LIKE '%$cari%' OR warga.alamat LIKE '%$cari%') ";
            }
            $query .= "ORDER BY RT.NAMA_RT ASC, NOKK ASC LIMIT $limit OFFSET $offset";
            $warga = mysqli_query($koneksi, $query);
?>

<main class="content">
    <h2 class="title text-center mb-4">Data Warga</h2>
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <div class="p-3">
            <button type="button" class="btn btn-outline-success" onclick="window.location='tambahwarga.php'">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <div class="filter-container p-2 d-flex align-items-center">
                <h6 class="text-center me-3 mb-0">Cari</h6>
                <form action="" method="GET" class="d-flex mb-0">
                    <input type="text" name="cari" class="form-control me-2" placeholder="masukkan data"
                        value="<?= $cari ?>">
                    <input type="submit" value="Filter" name="filter" class="btn btn-light">
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>NIK</th>
                    <th>NO KK</th>
                    <th>Nama Warga</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $nomor = $offset + 1;
            if (mysqli_num_rows($warga) > 0) {
                while ($p = mysqli_fetch_array($warga)) {
                    ?>
                <tr>
                    <td class="text-center"><?= $nomor++ ?></td>
                    <td><?= $p['NIK'] ?></td>
                    <td><?= $p['NOKK'] ?></td>
                    <td><?= $p['namalengkap'] ?></td>
                    <td><?= $p['JK'] ?></td>
                    <td><?= $p['alamat'] ?></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-primary btn-sm square-btn"
                                onclick="window.location='detailwarga.php?NIK=<?= $p['NIK'] ?>'">
                                <i class="fas fa-info"></i>
                            </button>
                            <button class="btn btn-warning btn-sm square-btn"
                                onclick="window.location='editwarga.php?NIK=<?= $p['NIK'] ?>'">
                                <i class="fas fa-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm square-btn"
                                onclick="if(confirm('Yakin ingin menghapus?')) window.location='hapuswarga.php?NIK=<?= $p['NIK'] ?>'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                }
            } else {
                echo "<tr class='text-center'><td colspan='7'>TIDAK ADA DATA WARGA</td></tr>";
            }
            ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&cari=<?= urlencode($cari) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>

        <?php if ($cari) { ?>
        <div class="text-start">
            <button type="button" class="btn btn-outline-secondary"
                onclick="window.location='warga.php'">Kembali</button>
        </div>
        <?php } ?>

</main>

<?php include('footer.php'); ?>