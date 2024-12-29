<?php
include('header.php');
include '../config/config.php';

$iduser = $_SESSION['user_id'];

// Mark all notifications as viewed when accessing the notifications page
$updateQuery = "UPDATE berkaspengajuansuratkeluar SET is_viewed = 1 WHERE NIK IN (SELECT nik FROM warga WHERE iduser = '$iduser')";
mysqli_query($koneksi, $updateQuery);

// Query untuk mengambil semua notifikasi
$queryAllNotifikasi = "SELECT berkaspengajuansuratkeluar.idberkassurat, status_rt, jenissurat, konfirmasi_rt,
                       CASE 
                           WHEN status_rt = 'Diproses' THEN tanggalpengajuan 
                          WHEN berkaspengajuansuratkeluar.status_rt = 'disetujui' THEN berkaspengajuansuratkeluar.konfirmasi_rt
                           ELSE tanggalselesai 
                       END AS waktu  
                       FROM berkaspengajuansuratkeluar 
                       JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                       JOIN warga ON warga.nik = berkaspengajuansuratkeluar.NIK 
                       JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') 
                       JOIN ketua_rt ON ketua_rt.idrt = rt.idrt 
                       WHERE ketua_rt.iduser = '$iduser'
                       ORDER BY waktu DESC";

$resultAllNotifikasi = mysqli_query($koneksi, $queryAllNotifikasi);
?>

<main class="content">
    <h2 class="title text-center">Semua Notifikasi</h2>
    <ul class="list-group">
        <?php while ($notif = mysqli_fetch_assoc($resultAllNotifikasi)) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center"
            onclick="window.location.href='detailpengajuan.php?idberkassurat=<?= $notif['idberkassurat']; ?>'"
            style="cursor: pointer; transition: background-color 0.3s;">

            <div>
                <strong><?= ucfirst($notif['status_rt']); ?>:</strong> <?= $notif['jenissurat']; ?>
                <br>
                <small class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
            </div>
            <span class="badge bg-<?php 
    $status = strtolower($notif['status_rt']);
    if ($status == 'disetujui') {
        echo 'success'; // Hijau
    } elseif ($status == 'diproses') {
        echo 'warning'; // Kuning
    } elseif ($status == 'ditolak') {
        echo 'danger'; // Merah
    } else {
        echo 'secondary'; // Warna default jika status tidak dikenali
    }
?>">
                <?= ucfirst($notif['status_rt']); ?>
            </span>

        </li>
        <?php endwhile; ?>
    </ul>
</main>