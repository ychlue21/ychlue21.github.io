<?php
include 'header.php';
$query_disposisi = "SELECT suratmasuk.nosuratmasuk, suratmasuk.tanggalsurat, disposisi.isiDisposisi 
                    FROM disposisi 
                    JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat 
                    JOIN PEGAWAI ON PEGAWAI.IDPEGAWAI=DISPOSISI.IDPEGAWAI
                    WHERE PEGAWAI.IDUSER = '$iduser'
                    ORDER BY suratmasuk.tanggalsurat DESC";
$result_disposisi = mysqli_query($koneksi, $query_disposisi);
?>

<main class="content">
    <h2 class="title text-center mb-4">Notifikasi</h2>
    <div class="list-group">
        <?php if (mysqli_num_rows($result_disposisi) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result_disposisi)): ?>
        <a href="suratmasuk.php" class="list-group-item list-group-item-action">
            <strong>No. Surat:</strong> <?= $row['nosuratmasuk'] ?><br>
            <strong>Tanggal:</strong> <?= $row['tanggalsurat'] ?><br>
            <strong>Disposisi:</strong> <?= $row['isiDisposisi'] ?>
        </a>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-center">Tidak ada notifikasi</p>
        <?php endif; ?>
    </div>
</main>