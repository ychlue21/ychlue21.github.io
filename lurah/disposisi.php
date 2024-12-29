<?php
include('header.php');
$limit = 5; // Jumlah baris per halaman

// Cek halaman saat ini
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit; // Hitung offset

// Query total data untuk menghitung jumlah halaman
$totalDataQuery = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM disposisi Join suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                                                                JOIN pegawai on pegawai.idPegawai = disposisi.idpegawai");
$totalDataRow = mysqli_fetch_assoc($totalDataQuery);
$totalData = $totalDataRow['total'];
$totalPages = ceil($totalData / $limit); // Hitung jumlah halaman


if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
}

?>

<main class="content">
    <h2 class="title text-center mb-4">Disposisi</h2>

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
                <th>No.Surat</th>
                <th>Tanggal Disposisi</th>
                <th>Penerima</th>
                <th>Isi Disposisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $nomor = $offset + 1;
                   
                    if(isset($_GET['cari'])){
                    $cari=$_GET['cari'];
                    $suratmasuk=mysqli_query(mysql: $koneksi,query: "SELECT * FROM disposisi Join suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat JOIN pegawai on pegawai.idPegawai = disposisi.idpegawai where tanggaldisposisi like '%$cari%'");
                    }
                        else{
                             $suratmasuk = mysqli_query(mysql: $koneksi, query: "SELECT idDisposisi,  nosuratmasuk, tanggaldisposisi, isiDisposisi, status, namalengkap FROM disposisi Join suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat JOIN pegawai on pegawai.idPegawai = disposisi.idpegawai 
                             ORDER BY 
            CASE 
                WHEN status = 'belum selesai' THEN 0 
                WHEN status = 'selesai' THEN 1 
                ELSE 2 
            END, 
            tanggaldisposisi DESC");
                        }
                        
                        if(mysqli_num_rows(result: $suratmasuk)>0){
                            while($p=mysqli_fetch_array(result: $suratmasuk)){          
                        ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?=$p['nosuratmasuk']?></td>
                <td>
                    <?=$p['tanggaldisposisi']?>
                </td>
                <td>
                    <?=$p['namalengkap']?>
                </td>
                <td>
                    <?=$p['isiDisposisi']?>
                </td>
                <td>
                    <?=$p['status']?>
                </td>
                <!-- <td class="text-center">
                    <div class="action-buttons">
                        <button class="btn btn-warning square-btn"
                            onclick="window.location='editdisposisi.php?idDisposisi=<?=$p['idDisposisi']?>'">
                            <i class="fas fa-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger square-btn"
                            onclick="if (confirm('Yakin ingin menghapus?')) { window.location='hapusdisposisi.php?idDisposisi=<?= $p['idDisposisi'] ?>'; }"
                            title="hapus">
                            <i class="fas fa-trash"></i>
                        </button>

                    </div>
                </td> -->
                <td class="text-center">
                    <div class="action-buttons">
                        <?php if ($p['status'] !== 'Selesai') { // Ganti 'selesai' dengan status yang sesuai ?>
                        <button class="btn btn-warning square-btn"
                            onclick="window.location='editdisposisi.php?idDisposisi=<?= $p['idDisposisi'] ?>'">
                            <i class="fas fa-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger square-btn"
                            onclick="if (confirm('Yakin ingin menghapus?')) { window.location='hapusdisposisi.php?idDisposisi=<?= $p['idDisposisi'] ?>'; }"
                            title="hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                        <?php } ?>
                    </div>
                </td>

            </tr>
            <?php } } 
                else{ ?>
            <tr>
                <td colspan=" 6">TIDAK ADA DATA DISPOSISI
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>
    <!-- Pagination Links -->
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
<?php
include('footer.php')
?>