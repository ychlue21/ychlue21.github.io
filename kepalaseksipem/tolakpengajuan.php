<?php
include('header.php');
$iduser = $_SESSION['user_id'];
$idberkassurat = $_GET['idberkassurat'];

// Perbaiki query SQL agar lebih spesifik dan jelas
$berkas = mysqli_query($koneksi, "
       SELECT *
    FROM  berkaspengajuansuratkeluar 
    left JOIN berkaspersyaratan ON berkaspengajuansuratkeluar.idberkassurat = berkaspersyaratan.idberkassurat  
     JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
  left join surat_keluar on berkaspengajuansuratkeluar.idberkassurat=surat_keluar.idberkassuratkeluar
  join warga on warga.nik=berkaspengajuansuratkeluar.nik
    where berkaspengajuansuratkeluar.idberkassurat = '$idberkassurat'
");

// Ambil data
$p = mysqli_fetch_object($berkas);
?>
<main class="content">
    <h2 class="title text-center">Tolak Surat Keluar</h2>
    <div class="box" style="width: 100%; max-width: 800px; margin: auto;">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Jenis Surat</td>
                            <td><?= htmlspecialchars($p->jenissurat) ?></td>
                        </tr>
                        <?php if (!empty($p->tujuan)): // Cek apakah tujuan tidak kosong ?>
                        <tr>
                            <td class="font-weight-bold">Tujuan</td>
                            <td><?= htmlspecialchars($p->tujuan) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="font-weight-bold">Nama Pengusul</td>
                            <td><?= ucwords(strtolower(htmlspecialchars($p->namalengkap))) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Pengajuan</td>
                            <td><?= htmlspecialchars($p->tanggalpengajuan) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">

            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="keterangan" class="form-label" style="width: 20%;">Keterangan</label>
                    <textarea cols="30" rows="4" placeholder="" class="form-control" name="keterangan" id="keterangan"
                        required style="flex-grow: 1; margin: 0;"></textarea>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-success">Simpan</button>
            </div>
        </form>
    </div>
</main>
<?php
if (isset($_POST['submit'])&&isset($_GET['idberkassurat'])) {
    // Dapatkan nilai keterangan dari form
    $status_kasi ='Ditolak';
    $konfirmasi_kasi = date("Y-m-d H:i:s");
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $idberkassurat = $_GET['idberkassurat']; // Ambil ID berkas dari URL atau form
     $tanggalselesai = date("Y-m-d H:i:s");

    // Mengatur statusSurat berdasarkan statusRt
$statusSurat = ($status_kasi === 'Ditolak') ? 'ditolak' : 'diproses';


    // Update status dan simpan keterangan ke database
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET keterangan = '$keterangan' ,tanggalselesai='$tanggalselesai',Status_kasi = '$status_kasi',Konfirmasi_kasi='$konfirmasi_kasi',is_viewed = 0,status_surat = '$statusSurat'
        WHERE idberkassurat = '$idberkassurat'
    ");

    if ($update) {
        echo "<script>alert('Keterangan telah disimpan'); window.location='pengajuanwarga.php';</script>";
    } else {
        echo 'Gagal menyimpan keterangan: ' . mysqli_error($koneksi);
    }
}
?>