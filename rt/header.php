<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['status_login'])) {
    echo "<script>window.location='../index.php'</script>";
    exit;
}

$iduser = mysqli_real_escape_string($koneksi, $_SESSION['user_id']); // Menghindari SQL Injection

// Query to count all notifications that are not viewed
$totalNotifikasiQuery = "SELECT COUNT(*) AS total FROM berkaspengajuansuratkeluar 
                          JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.nik = berkaspengajuansuratkeluar.NIK 
                    JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') 
                    JOIN ketua_rt ON ketua_rt.idrt = rt.idrt 
                    JOIN user ON user.id_user = ketua_rt.iduser 
                    WHERE id_user = '$iduser' AND is_viewed = 0 and status_rt='Diproses'";
$totalNotifikasiResult = mysqli_query($koneksi, $totalNotifikasiQuery);
$totalNotifikasiRow = mysqli_fetch_assoc($totalNotifikasiResult);
$totalNotifikasi = $totalNotifikasiRow['total'];


// Query untuk mengambil notifikasi terbaru berdasarkan status_surat yang belum dilihat
$queryNotifikasi = "SELECT berkaspengajuansuratkeluar.idberkassurat, status_rt, jenissurat, tanggalpengajuan AS waktu  
                    FROM berkaspengajuansuratkeluar 
                    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
                    JOIN warga ON warga.nik = berkaspengajuansuratkeluar.NIK 
                    JOIN rt ON warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') 
                    JOIN ketua_rt ON ketua_rt.idrt = rt.idrt 
                    JOIN user ON user.id_user = ketua_rt.iduser 
                    WHERE id_user = '$iduser' AND is_viewed = 0 and status_rt='Diproses'
                    ORDER BY waktu DESC ";
$resultNotifikasi = mysqli_query($koneksi, $queryNotifikasi);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman RT</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="../assets/css/style.css" rel="stylesheet" />
    <script>
    function updateNotificationCount() {
        let badge = document.getElementById('notificationCount');
        let count = parseInt(badge.innerText);
        count--;
        badge.innerText = count;

        if (count === 0) {
            badge.style.display = 'none';
        }
    }

    function markAsViewed(idberkassurat) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "mark_as_viewed.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("Notifikasi ditandai sebagai dilihat.");
                updateNotificationCount();
            } else {
                console.error("Terjadi kesalahan saat memperbarui status notifikasi.");
            }
        };
        xhr.send("idberkassurat=" + idberkassurat);
    }
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top p-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="#!">
                    <img src="../assets/img/LOGO_KOTA_KUPANG.PNG" alt="Logo" width="30" height="30"
                        class="d-inline-block align-text-top">
                    KELURAHAN OEBA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="warga.php">Warga</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="true">Pengajuan Surat Warga</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="daftarpengajuanwarga.php">Konfirmasi</a></li>
                                <li><a class="dropdown-item" href="pengajuanwarga.php">Daftar Pengajuan</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0" style="list-style: none;">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="notificationDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <?php if ($totalNotifikasi > 0): ?>
                                <span id="notificationCount" class="badge bg-danger"><?= $totalNotifikasi; ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                <li class="dropdown-header">Notifikasi Terbaru</li>
                                <?php while ($notif = mysqli_fetch_assoc($resultNotifikasi)) : ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="detailpengajuan.php?idberkassurat=<?= $notif['idberkassurat']; ?>"
                                        onclick="updateNotificationCount();markAsViewed(<?= $notif['idberkassurat']; ?>)">
                                        <span class="badge bg-<?php 
                                            $status = strtolower(trim($notif['status_rt'])); // Normalisasi status
                                            if ($status == 'disetujui') {
                                                echo 'success'; // Hijau
                                            } elseif ($status == 'ditolak') {
                                                echo 'danger'; // Merah
                                            } elseif ($status == 'diproses') {
                                                echo 'warning'; // Kuning
                                            } else {
                                                echo 'secondary'; // Warna default
                                            }
                                        ?>">
                                            <?= ucfirst($notif['status_rt']); ?>
                                        </span>
                                        <?= $notif['jenissurat']; ?>
                                        <br>
                                        <small
                                            class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
                                    </a>
                                </li>
                                <?php endwhile; ?>
                                <li><a class="dropdown-item text-center" href="notifikasi.php">Lihat Semua</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0" style="list-style: none;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fa-solid fa-circle-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profil.php"><i
                                            class="fas fa-user fa-sm fa-fw mr-2"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="logout.php"><i
                                            class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Keluar</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>