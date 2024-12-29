<?php
include('header.php');
require('../config/config.php');

$iduser = $_SESSION['user_id'];
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Offset untuk query SQL
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
?>
<!-- Tambahkan ini di bagian <head> dari file HTML Anda -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <h2 class="title text-center mb-4">Surat Masuk</h2>
    <div class="d-flex justify-content-end mb-3">
        <!-- Filter Data -->
        <div class="filter-container p-3 ">
            <h5 class="text-center">Filter Data</h5>
            <form action="" method="GET" class="d-flex flex-column mb-2">
                <div class="d-flex align-items-center mb-2">
                    <label for="tanggal" class="form-label me-2">Tanggal surat:</label>
                    <input type="date" name="cari" class="form-control me-2 flex-grow-1" id="tanggal"
                        value="<?= $cari ?>">
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
                <th>Tanggal surat</th>
                <th>Tujuan</th>
                <th>Disposisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = $offset + 1;
            $query = "SELECT nosuratmasuk, tanggalsurat, tujuan, isiDisposisi, status, filesurat 
                      FROM disposisi 
                      JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                      JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai 
                      JOIN user ON user.id_user = pegawai.iduser 
                      WHERE user.id_user = '$iduser' ";
            if ($cari) {
                $query .= "AND tanggalsurat = '$cari' ";
            }
            $query .= "ORDER BY tanggalsurat ASC LIMIT $limit OFFSET $offset";
            $suratmasuk = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($suratmasuk) > 0) {
                while ($p = mysqli_fetch_array($suratmasuk)) {
                    ?>
            <tr>
                <td class="text-center"><?= $nomor++ ?></td>
                <td><?= ucwords(strtolower($p['nosuratmasuk'])) ?></td>
                <td class="text-center"><?= $p['tanggalsurat'] ?></td>
                <td><?= ucwords(strtolower($p['tujuan'])) ?></td>
                <td><?= ucwords($p['isiDisposisi']) ?></td>
                <td class="text-center"><?= $p['status'] ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-warning square-btn"
                            onclick="konfirmasiStatus('<?= $p['nosuratmasuk'] ?>')">
                            <i class="fas fa-check"></i>
                        </button>

                        <script>
                        function konfirmasiStatus(nosuratmasuk) {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "Apakah anda telah menyelesaikan disposisi ini?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Selesai',
                                cancelButtonText: 'Batal',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika pengguna memilih "Setuju"
                                    window.location.href =
                                        `konfirmasi.php?nosuratmasuk=${nosuratmasuk}`;
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Jika pengguna memilih "Tolak"
                                    window.location.href =
                                        `suratmasuk.php`;
                                }
                            });
                        }
                        </script>

                        <button class="btn btn-info square-btn"
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