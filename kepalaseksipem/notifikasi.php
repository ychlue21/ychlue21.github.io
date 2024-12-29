<?php
include('header.php');
include '../config/config.php';

$iduser = $_SESSION['user_id'];

// Update status semua notifikasi menjadi sudah dilihat
$queryUpdateNotifikasi = "UPDATE suratmasuk SET is_viewed = 1 WHERE is_viewed = 0";
mysqli_query($koneksi, $queryUpdateNotifikasi);

$queryUpdateNotifikasiKeluar = "UPDATE berkaspengajuansuratkeluar JOIN surat_keluar ON surat_keluar.idberkassuratkeluar=berkaspengajuansuratkeluar.idberkassurat SET is_viewed = 1 where berkaspengajuansuratkeluar.is_viewed = 0";
mysqli_query($koneksi, $queryUpdateNotifikasiKeluar);
// Query untuk mengambil semua notifikasi dari `berkaspengajuansuratkeluar`
$queryBerkasNotifikasi = "SELECT berkaspengajuansuratkeluar.idberkassurat, 'berkaspengajuansuratkeluar' AS sumber, 
                          status_kasi as status, jenissurat, berkaspengajuansuratkeluar.NIK AS pengirim,
                          CASE 
                              WHEN status_kasi = 'Diproses' THEN tanggalpengajuan 
                              WHEN status_kasi = 'Disetujui' THEN konfirmasi_kasi
                              ELSE tanggalselesai 
                          END AS waktu  
                          FROM berkaspengajuansuratkeluar 
                          JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                         where status_stafsurat='Disetujui' 
                         ";

// Query untuk mengambil semua notifikasi dari `suratmasuk`
$querySuratMasukNotifikasi = "SELECT suratmasuk.nosuratmasuk, 'suratmasuk' AS sumber, 
                              disposisi.status AS status, suratmasuk.filesurat, 
                              suratmasuk.pengirim, 
                              CASE 
                              WHEN disposisi.status = 'Belum selesai' THEN tanggaldisposisi
                              ELSE tanggal_verifikasi 
                          END AS waktu
                              FROM disposisi join suratmasuk on suratmasuk.nosuratmasuk=disposisi.nosurat ";

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
                <strong>Surat Keluar:</strong> <?= $notif['jenissurat']; ?>
                <?php elseif (isset($notif['pengirim'])): ?>
                <strong>Surat Masuk:</strong> <?= $notif['pengirim']; ?>
                <?php else: ?>
                <strong>Surat Masuk:</strong> (Pengirim Tidak Tersedia)
                <?php endif; ?>
                <br>
                <small class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
            </div>
            <span class="badge bg-<?php 
    $status = strtolower($notif['status'] ?? '');
    if ($status == 'disetujui') {
        echo 'success'; // Hijau
    } elseif ($status == 'diproses') {
        echo 'warning'; // Kuning
    } elseif ($status == 'ditolak') {
        echo 'danger'; // Merah
    } else if ($status == 'belum selesai'){
        echo 'secondary'; // Warna default jika status tidak dikenali atau untuk `suratmasuk`
    }
    else{
        echo'primary';
    }
?>">
                <?= ucfirst($notif['status_kasi'] ?? $notif['status'] ?? 'Info'); ?>
            </span>

        </li>
        <?php endwhile; ?>
    </ul>
</main>