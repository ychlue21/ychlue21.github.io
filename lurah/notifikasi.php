<?php
include('header.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
require('../config/config.php');
$iduser= $_SESSION['user_id'];

// Tandai semua notifikasi `berkaspengajuansuratkeluar` sebagai dilihat
$updateBerkasQuery = "UPDATE berkaspengajuansuratkeluar join surat_keluar on surat_keluar.idberkassuratkeluar=berkaspengajuansuratkeluar.idberkassurat SET is_viewed = 1 WHERE berkaspengajuansuratkeluar.is_viewed = 0 and idPegawai IN (SELECT idPegawai FROM pegawai WHERE iduser = '$iduser')";
mysqli_query($koneksi, $updateBerkasQuery);

// Tandai semua notifikasi `suratmasuk` sebagai dilihat
$updateSuratMasukQuery = "UPDATE suratmasuk join disposisi on disposisi.nosurat=suratmasuk.nosuratmasuk join pegawai on disposisi.idpegawai=pegawai.idPegawai SET is_viewed = 1 WHERE pegawai.iduser = '$iduser' and is_viewed=0";
mysqli_query($koneksi, $updateSuratMasukQuery);

// Query untuk mengambil semua notifikasi dari `berkaspengajuansuratkeluar`
$queryBerkasNotifikasi = "SELECT berkaspengajuansuratkeluar.idberkassurat, 'berkaspengajuansuratkeluar' AS sumber, 
                          status_surat, jenissurat, berkaspengajuansuratkeluar.NIK AS pengirim,
                          CASE 
                              WHEN status_surat = 'Diproses' THEN tanggalpengajuan 
                              ELSE tanggalselesai 
                          END AS waktu  
                          FROM berkaspengajuansuratkeluar 
                          JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                          JOIN warga ON warga.nik = berkaspengajuansuratkeluar.NIK  
                           join surat_keluar on surat_keluar.idberkassuratkeluar=berkaspengajuansuratkeluar.idberkassurat
                          WHERE status_kasi = 'disetujui'";

// Query untuk mengambil semua notifikasi dari `suratmasuk`
$querySuratMasukNotifikasi = "SELECT nosuratmasuk, 'suratmasuk' AS sumber, tujuan, filesurat, 
                              pengirim, tanggalsurat AS waktu
                              FROM suratmasuk ";

// Gabungkan hasil dari kedua query menggunakan UNION
$queryAllNotifikasi = "$queryBerkasNotifikasi UNION  $querySuratMasukNotifikasi ORDER BY waktu DESC";
$resultAllNotifikasi = mysqli_query($koneksi, $queryAllNotifikasi);
?>

<main class="content">
    <h2 class="title text-center">Semua Notifikasi</h2>
    <ul class="list-group">
        <?php while ($notif = mysqli_fetch_assoc($resultAllNotifikasi)) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center"
            onclick="window.location.href='<?php echo ($notif['sumber'] == 'suratmasuk') ? 'suratmasuk.php' : 'detailpengajuan.php?idberkassurat=' . $notif['idberkassurat'] . '&sumber=' . $notif['sumber']; ?>'"
            style="cursor: pointer; transition: background-color 0.3s;">
            <div>
                <?php if ($notif['sumber'] == 'berkaspengajuansuratkeluar'): ?>
                <strong><?= ucfirst($notif['status_surat']); ?>:</strong> <?= $notif['jenissurat']; ?>
                <?php elseif (isset($notif['pengirim'])): ?>
                <strong>Surat Masuk:</strong> <?= $notif['pengirim']; ?>
                <?php else: ?>
                <strong>Surat Masuk:</strong> (Pengirim Tidak Tersedia)
                <?php endif; ?>
                <br>
                <small class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
            </div>
            <span class="badge bg-<?php 
    $status = strtolower($notif['status_surat'] ?? '');
    if ($status == 'diterima') {
        echo 'success'; // Hijau
    } elseif ($status == 'diproses') {
        echo 'warning'; // Kuning
    } elseif ($status == 'ditolak') {
        echo 'danger'; // Merah
    } else {
        echo 'secondary'; // Warna default jika status tidak dikenali atau untuk `suratmasuk`
    }
?>">
                <?= ucfirst($notif['status_surat'] ?? 'Info'); ?>
            </span>

        </li>
        <?php endwhile; ?>
    </ul>
</main>