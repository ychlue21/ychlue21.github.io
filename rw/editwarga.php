<?php
include('header.php');
$warga = mysqli_query($koneksi, "
    SELECT 
        warga.*, 
        rt.IDRT, 
        rt.NAMA_RT, 
        rw.IDRW, 
        rw.NAMA_RW 
    FROM 
        warga 
    JOIN 
        rt ON warga.alamat LIKE CONCAT('%', rt.NAMA_RT, '%')
    JOIN 
        rw ON warga.alamat LIKE CONCAT('%', rw.NAMA_RW, '%') 
    JOIN 
        user ON user.id_user = warga.iduser 
    WHERE 
        NIK='" . $_GET['NIK'] . "'
");
$p = mysqli_fetch_object($warga);

// Fungsi untuk mengekstrak nama jalan dari alamat
function extractStreetName($address) {
    // Regular expression pattern untuk mengekstrak nama jalan
    $pattern = '/^(.*?)(?:\s+RT\s*\d+\s+RW\s*\d+)?$/i';
    preg_match($pattern, $address, $matches);

    return trim($matches[1] ?? ''); // Mengembalikan nama jalan
}

// Ambil data yang diperlukan
$idRT = $p->IDRT; // Ambil ID RT
$rt = $p->NAMA_RT; // Ambil nama RT

// Ambil data RT dari database untuk dropdown
$queryRT = mysqli_query($koneksi, "SELECT * FROM rt");

// Ambil data yang diperlukan
$idRW = $p->IDRW; // Ambil ID RW
$rw = $p->NAMA_RW; // Ambil nama RW

// Ambil data RW dari database untuk dropdown
$queryRW = mysqli_query($koneksi, "SELECT * FROM rw");

?>
<main class="content">
    <h2 class="title text-center mb-4">Edit Data Warga</h2>
    <div class="box" style="max-width: 800px; margin: auto;">

        <form action="" method="POST" class="row g-3">
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="NIK" class="form-label">NIK</label>
                <input type="text" name="NIK" id="NIK" class="form-control" value="<?php echo $p->NIK; ?>" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="NOKK" class="form-label">NO KK</label>
                <input type="text" name="NOKK" id="NOKK" class="form-control" value="<?php echo $p->NOKK; ?>" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="namalengkap" id="namalengkap" class="form-control"
                    value="<?php echo $p->namalengkap; ?>" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="JK" class="form-label">Jenis Kelamin</label>
                <select name="JK" class="form-select" required>
                    <option value="Perempuan" <?= ($p->JK == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    <option value="Laki-laki" <?= ($p->JK == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                    value="<?= $p->tempat_lahir; ?>" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="tgl_Lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_Lahir" id="tgl_Lahir" class="form-control" value="<?= $p->tgl_Lahir; ?>"
                    required>
            </div>
            <div class="col-12 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea cols="30" rows="2" class="form-control" name="alamat" id="alamat"
                    required><?= htmlspecialchars(extractStreetName($p->alamat)); ?></textarea>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="rt" class="form-label">RT</label>
                <select name="rt" id="rt" class="form-select" required>
                    <option value="">Pilih RT</option>
                    <?php
                    // Loop untuk menampilkan opsi RT
                    while ($rowRT = mysqli_fetch_assoc($queryRT)) {
                        $selected = ($rowRT['IDRT'] == $idRT) ? 'selected' : '';
                        echo "<option value='{$rowRT['IDRT']}' $selected>{$rowRT['NAMA_RT']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="rw" class="form-label">RW</label>
                <select name="rw" id="rw" class="form-select" required>
                    <option value="">Pilih RW</option>
                    <?php
                    // Loop untuk menampilkan opsi RW
                    while ($rowRW = mysqli_fetch_assoc($queryRW)) {
                        $selected = ($rowRW['IDRW'] == $idRW) ? 'selected' : '';
                        echo "<option value='{$rowRW['IDRW']}' $selected>{$rowRW['NAMA_RW']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="agama" class="form-label">Agama</label>
                <select name="agama" id="agama" class="form-select" required>
                    <option value="">--- Pilih ---</option>
                    <option value="Kristen Protestan" <?= ($p->agama == 'Kristen Protestan') ? 'selected' : ''; ?>>
                        Kristen Protestan</option>
                    <option value="Katolik" <?= ($p->agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                    <option value="Islam" <?= ($p->agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                    <option value="Hindu" <?= ($p->agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                    <option value="Buddha" <?= ($p->agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                    <option value="Konghucu" <?= ($p->agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?= $p->pekerjaan; ?>"
                    required>
            </div>

            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary"
                    onclick="window.location='warga.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-warning">Ubah</button>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $NIK = $_POST['NIK'];
            $NOKK = $_POST['NOKK'];
            $namalengkap = ucwords($_POST['namalengkap']);
            $JK = $_POST['JK'];
            $tempat_lahir = $_POST['tempat_lahir'];
            $tgl_Lahir = $_POST['tgl_Lahir'];
            $agama = $_POST['agama'];
            $alamat = ucwords($_POST['alamat']);
            $pekerjaan = $_POST['pekerjaan'];
            $RT = $_POST['rt'];
            $RW = $_POST['rw'];

            // Ambil nama RT berdasarkan ID RT
            $queryRTName = mysqli_query($koneksi, "SELECT NAMA_RT FROM rt WHERE IDRT = '$RT'");
            $rowRTName = mysqli_fetch_assoc($queryRTName);
            $namaRT = $rowRTName['NAMA_RT'];

            // Ambil nama RW berdasarkan ID RW
            $queryRWName = mysqli_query($koneksi, "SELECT NAMA_RW FROM rw WHERE IDRW = '$RW'");
            $rowRWName = mysqli_fetch_assoc($queryRWName);
            $namaRW = $rowRWName['NAMA_RW'];

            // Gabungkan alamat, nama RT, dan nama RW
            $alamatLengkap = $alamat . ' ' . $namaRT . ' ' . $namaRW;

            $update = mysqli_query($koneksi, "UPDATE warga SET 
                NIK='$NIK',
                NOKK='$NOKK',
                namalengkap='$namalengkap',
                JK='$JK',
                tempat_lahir='$tempat_lahir',
                tgl_Lahir='$tgl_Lahir',
                agama='$agama',
                alamat='$alamatLengkap',
                pekerjaan='$pekerjaan'
                WHERE NIK='" . $_GET['NIK'] . "'");

            if ($update) {
                echo '<script>window.location="warga.php"</script>';
            } else {
                echo 'Data warga telah ada sebelumnya: ' . mysqli_error($koneksi);
            }
        }
        ?>
    </div>
</main>
<?php
include('footer.php');
?>