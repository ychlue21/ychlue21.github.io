<?php
session_start();
include '../config/config.php';

// Validasi sesi login
if (!isset($_SESSION['status_login'])) {
    echo "<script>window.location='../index.php'</script>";
    exit;
}

$iduser = $_SESSION['user_id'];

// Query notifikasi surat masuk
$queryNotifikasiSuratMasuk = "
    SELECT suratmasuk.nosuratmasuk, 'suratmasuk' AS sumber, 
           disposisi.status AS status, suratmasuk.filesurat, suratmasuk.pengirim, 
           CASE 
               WHEN disposisi.status = 'Belum selesai' THEN tanggaldisposisi
               ELSE tanggal_verifikasi 
           END AS waktu
    FROM disposisi 
    JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat
    WHERE suratmasuk.is_viewed = 0 
    ORDER BY waktu DESC ";
$resultNotifikasiSuratMasuk = mysqli_query($koneksi, $queryNotifikasiSuratMasuk);

// Query notifikasi surat keluar
$queryNotifikasiSuratKeluar = "
    SELECT berkaspengajuansuratkeluar.idberkassurat, 'berkaspengajuansuratkeluar' AS sumber, 
           status_kasi AS status, jenissurat, berkaspengajuansuratkeluar.NIK AS pengirim,
           CASE 
               WHEN status_kasi = 'Diproses' THEN tanggalpengajuan 
               WHEN status_kasi = 'Disetujui' THEN konfirmasi_kasi
               ELSE tanggalselesai 
           END AS waktu  
    FROM berkaspengajuansuratkeluar 
    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
    WHERE berkaspengajuansuratkeluar.is_viewed = 0 
    AND status_stafsurat = 'disetujui' and status_kasi='diproses'
    ORDER BY waktu DESC ";
$resultNotifikasiSuratKeluar = mysqli_query($koneksi, $queryNotifikasiSuratKeluar);

// Gabungkan hasil dari kedua query
$notifikasi = [];

// Tambahkan notifikasi dari suratmasuk
while ($notif_suratmasuk = mysqli_fetch_assoc($resultNotifikasiSuratMasuk)) {
    $notif_suratmasuk['sumber'] = 'suratmasuk';
    $notifikasi[] = $notif_suratmasuk;
}

// Tambahkan notifikasi dari berkaspengajuansuratkeluar
while ($notif_berkaspengajuan = mysqli_fetch_assoc($resultNotifikasiSuratKeluar)) {
    $notif_berkaspengajuan['sumber'] = 'berkaspengajuansuratkeluar';
    $notifikasi[] = $notif_berkaspengajuan;
}

// Urutkan array notifikasi berdasarkan waktu
usort($notifikasi, function ($a, $b) {
    return strtotime($b['waktu']) - strtotime($a['waktu']);
});

// Ambil maksimal 5 notifikasi terbaru
$notifikasi = array_slice($notifikasi, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kepala Seksi</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="../assets/css/style.css" rel="stylesheet" />
    <script>
    function updateNotificationCount() {
        const badge = document.getElementById('notificationCount');
        let count = parseInt(badge.innerText);
        count = Math.max(0, count - 1); // Kurangi count, minimum 0
        badge.innerText = count;

        if (count === 0) {
            badge.style.display = 'none';
        }
    }

    function markAsViewed(id, sumber) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "mark_as_viewed.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        const params = sumber === 'suratmasuk' ? `nosuratmasuk=${id}` : `idberkassurat=${id}`;
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    console.log(response.message);
                    updateNotificationCount();
                } else {
                    console.error(response.message);
                }
            } else {
                console.error("Terjadi kesalahan dalam permintaan.");
            }
        };
        xhr.send(params);
    }
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top p-1">
            <div class=" container-fluid">
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
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="suratmasuk.php">Surat Masuk</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="true">
                                Surat Keluar Warga
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="daftarpengajuanwarga.php">Konfirmasi</a></li>
                                <li><a class="dropdown-item" href="pengajuanwarga.php">Daftar Pengajuan</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="notificationDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <?php if (count($notifikasi) > 0): ?>
                                <span id="notificationCount" class="badge bg-danger"><?= count($notifikasi); ?></span>
                                <?php else: ?>
                                <span id="notificationCount" class="badge bg-danger" style="display: none;"></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">Notifikasi Terbaru</li>
                                <?php foreach ($notifikasi as $notif): ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= $notif['sumber'] === 'suratmasuk' ? 'suratmasuk.php' : 'detailpengajuan.php?idberkassurat=' . $notif['idberkassurat']; ?>"
                                        onclick="markAsViewed('<?= $notif['idberkassurat'] ?? ''; ?>')">
                                        <span class="badge bg-<?php 
                                            $status = strtolower($notif['status'] ?? '');
                                            echo match ($status) {
                                                'disetujui' => 'success',
                                                'diproses' => 'warning',
                                                'ditolak' => 'danger',
                                                'belum selesai' => 'secondary',
                                                'selesai' => 'primary',
                                                default => 'dark'
                                            };
                                        ?>">
                                            <?= ucfirst($notif['status']); ?>
                                        </span>
                                        <?= $notif['sumber'] === 'suratmasuk' ? 'Surat Masuk' : 'Surat Keluar'; ?>
                                        <br>
                                        <small
                                            class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <li><a class="dropdown-item text-center" href="notifikasi.php">Lihat Semua</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                <li class="dropdown-header">Notifikasi Terbaru</li>
                                <?php foreach ($notifikasi as $notif): ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= $notif['sumber'] == 'suratmasuk' ? 'suratmasuk.php' : 'detailpengajuan.php?idberkassurat=' . $notif['idberkassurat']; ?>"
                                        onclick="markAsViewed('<?= $notif['idberkassurat'] ?? ''; ?>')">
                                        <span class="badge bg-<?php 
                            $status = strtolower($notif['status'] ?? '');
                            echo match($status) {
                                'disetujui' => 'success',
                                'diproses' => 'warning',
                                'ditolak' => 'danger',
                                'belum selesai' => 'secondary',
                                default => 'primary'
                            };
                        ?>">
                                            <?= ucfirst($notif['status']); ?></span>
                                        <?= $notif['sumber'] === 'suratmasuk' ? 'Surat Masuk' : 'Surat Keluar'; ?>
                                        <br>
                                        <small
                                            class="text-muted"><?= date('d M Y, H:i', strtotime($notif['waktu'])); ?></small>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <li><a class="dropdown-item text-center" href="notifikasi.php">Lihat Semua</a></li>
                            </ul> -->
                    </li>
                    </ul>


                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 " style="list-style: none;">
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fa-solid fa-circle-user"></i></a>
                        </li> -->
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fa-solid fa-circle-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profil.php"><i
                                            class="fas fa-user fa-sm fa-fw mr-2"></i> Profil</a>
                                </li>
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