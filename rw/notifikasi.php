<?php
include('header.php');
include '../config/config.php';

$iduser = $_SESSION['user_id'];

// Mark all notifications as viewed when accessing the notifications page
$updateQuery = "UPDATE berkaspengajuansuratkeluar 
                SET is_viewed = 1 
                WHERE NIK IN (SELECT nik FROM warga WHERE iduser = '$iduser')";

if (!mysqli_query($koneksi, $updateQuery)) {
    echo "Error updating notifications: " . mysqli_error($koneksi);
}

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
                       JOIN rw ON warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') 
                       JOIN ketua_rw ON ketua_rw.idrw = rw.idrw 
                       JOIN rt ON rt.idrw = rw.idrw 
                       JOIN ketua_rt ON ketua_rt.idrt = rt.idrt 
                       WHERE ketua_rw.iduser= '$iduser
                       ORDER BY waktu DESC";

$resultAllNotifikasi = mysqli_query($koneksi, $queryAllNotifikasi);

if (!$resultAllNotifikasi) {
    echo "Error fetching notifications: " . mysqli_error($koneksi);
}
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

            <span
                class="badge bg-<?= strtolower($notif['status_rt']) === 'disetujui' ? 'success' : (strtolower($notif['status_rt']) === 'diproses' ? 'warning' : 'danger'); ?>">
                <?= ucfirst($notif['status_rt']); ?>
            </span>

        </li>
        <?php endwhile; ?>
    </ul>
</main>