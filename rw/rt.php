<?php
include('header.php');
require('../config/config.php');
$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

   $totalRTQuery = "SELECT COUNT(*) AS total FROM ketua_rt 
                                       JOIN rt ON rt.IDRT = ketua_rt.IDRT 
                                       JOIN rw ON rw.IDRW = rt.IDRW 
                                       JOIN ketua_rw ON rw.IDRW = ketua_rw.IDRW 
                                       JOIN warga ON warga.NIK = ketua_rt.NIK 
                                       WHERE ketua_rw.iduser = '$iduser'";
    if ($cari) {
    // Tambahkan filter pencarian pada query total data
    $totalRTQuery .= " AND (warga.namalengkap LIKE '%$cari%' 
                        OR ketua_rt.TAHUN_JABATAN LIKE '%$cari%' 
                        OR rt.NAMA_RT LIKE '%$cari%')";
}

$totalRT = mysqli_query($koneksi, $totalRTQuery);
$totalRows = mysqli_fetch_assoc($totalRT)['total'];
$totalPages = ceil($totalRows / $limit);

     $query = "SELECT * FROM ketua_rt 
                      JOIN rt ON rt.IDRT = ketua_rt.IDRT 
                      JOIN rw ON rw.IDRW = rt.IDRW 
                      JOIN ketua_rw ON rw.IDRW = ketua_rw.IDRW 
                      JOIN warga ON warga.NIK = ketua_rt.NIK 
                      WHERE ketua_rw.iduser = '$iduser' ";

    if ($cari) {
                $query .= "AND (warga.namalengkap LIKE '%$cari%' 
                OR KETUA_RT.TAHUN_JABATAN LIKE '%$cari%'
                OR RT.NAMA_RT LIKE '%$cari%') ";
            }
            
    $query .= "ORDER BY RT.idrw ASC LIMIT $limit OFFSET $offset";
    $rt = mysqli_query($koneksi, $query);           
?>

<main class="content">
    <h2 class="title text-center mb-4">Data Rukun Tetangga</h2>
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <div class="p-3">
            <button type="button" class="btn btn-outline-success" onclick="window.location='tambahrt.php'">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>

        <div class="d-flex justify-content-end-mb-3">
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

    <div class="table=responsive">
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>RT</th>
                    <th>Nama Ketua RT</th>
                    <th>Tahun Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
            $nomor = $offset + 1;
            if (mysqli_num_rows($rt) > 0) {
                while ($p = mysqli_fetch_array($rt)) {
                    ?>
                <tr>
                    <td class="text-center"><?= $nomor++ ?></td>
                    <td class="text-center"><?= $p['NAMA_RT'] ?></td>
                    <td><?= $p['namalengkap'] ?></td>
                    <td class="text-center"><?= $p['TAHUN_JABATAN'] ?></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-primary btn-sm square-btn"
                                onclick="window.location='detailrt.php?NIK=<?= $p['NIK'] ?>'">
                                <i class="fas fa-info"></i>
                            </button>
                            <button class="btn btn-warning btn-sm square-btn"
                                onclick="window.location='editrt.php?IDKETUART=<?= $p['IDKETUART'] ?>'">
                                <i class="fas fa-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger btn-sm square-btn"
                                onclick="if(confirm('Yakin ingin menghapus?')) window.location='hapusrt.php?IDKETUART=<?= $p['IDKETUART'] ?>'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php
                }
            } else {
                echo "<tr class='text-center'><td colspan='5'>TIDAK ADA DATA RT</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>



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
        <button type="button" class="btn btn-outline-secondary" onclick="window.location='rt.php'">Kembali</button>
    </div>
    <?php } ?>
</main>

<?php
include('footer.php');
?>