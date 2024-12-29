<?php
session_start();
include '../config/config.php';
if(!isset($_SESSION['status_login'])){
    echo "<script>window.location='../index.php'</script>";
}

// Query untuk menghitung jumlah notifikasi dari suratmasuk yang belum dilihat
$query_notifikasi_suratmasuk = "SELECT 
        nosuratmasuk, 
        'suratmasuk' AS sumber, 
        tujuan, 
        filesurat, 
        pengirim, 
        tanggalsurat AS waktu 
    FROM suratmasuk 
    WHERE is_viewed = 0 
    ORDER BY waktu DESC 
    LIMIT 5";
$result_notifikasi_suratmasuk = mysqli_query($koneksi, $query_notifikasi_suratmasuk);
$jumlah_notifikasi_suratmasuk = mysqli_num_rows($result_notifikasi_suratmasuk);

// Query untuk mengambil notifikasi terbaru dari berkaspengajuansuratkeluar
$queryNotifikasi_berkaspengajuan = "SELECT 
        berkaspengajuansuratkeluar.idberkassurat, 
        status_surat, 
        status_kasi, 
        jenissurat, 
        tanggalpengajuan AS waktu, 
        nik as pengirim,
        'berkaspengajuan' as sumber 
    FROM berkaspengajuansuratkeluar 
    JOIN jenissurat ON jenissurat.idJenisSurat = berkaspengajuansuratkeluar.Idjenisurat 
    WHERE is_viewed = 0 AND status_kasi = 'disetujui' and status_surat='Diproses'
    ORDER BY waktu DESC ";
$resultNotifikasi_berkaspengajuan = mysqli_query($koneksi, $queryNotifikasi_berkaspengajuan);

// Menggabungkan hasil dari kedua query
$notifikasi = [];

// Tambahkan notifikasi dari suratmasuk ke dalam array
while ($notif_suratmasuk = mysqli_fetch_assoc($result_notifikasi_suratmasuk)) {
    $notif_suratmasuk['sumber'] = 'suratmasuk'; // Menambahkan sumber untuk membedakan
    $notifikasi[] = $notif_suratmasuk;
}

// Tambahkan notifikasi dari berkaspengajuansuratkeluar ke dalam array
while ($notif_berkaspengajuan = mysqli_fetch_assoc($resultNotifikasi_berkaspengajuan)) {
    $notif_berkaspengajuan['sumber'] = 'berkaspengajuan'; // Menambahkan sumber untuk membedakan
    $notifikasi[] = $notif_berkaspengajuan;
}

// Mengurutkan array notifikasi berdasarkan waktu secara descending
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
    <title>Halaman Lurah</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link href="../assets/css/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                        <!-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="suratmasuk.php">Surat Masuk</a>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="true">
                                Surat Masuk
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="suratmasuk.php">Konfirmasi</a></li>
                                <li><a class="dropdown-item" href="disposisi.php">Disposisi</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="suratkeluar.php">Surat Keluar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="laporan.php">Laporan</a>
                        </li>

                    </ul>

                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0" style="list-style: none;">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="notificationDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                <?php
$total_notifikasi = $jumlah_notifikasi_suratmasuk + count($notifikasi);
if ($total_notifikasi > 0):
?>
                                <span id="notificationCount" class="badge bg-danger"><?= $total_notifikasi; ?></span>
                                <?php else: ?>
                                <span id="notificationCount" class="badge bg-danger" style="display: none;"></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                <li class="dropdown-header">Notifikasi Terbaru</li>
                                <?php foreach ($notifikasi as $notif): ?>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= $notif['sumber'] === 'suratmasuk' ? 'suratmasuk.php' : 'detailpengajuan.php?idberkassurat=' . $notif['idberkassurat']; ?>"
                                        onclick="markAsViewed('<?= $notif['idberkassurat'] ?? ''; ?>')">
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
                                            <?php
    // Menampilkan informasi sesuai dengan sumber
    if ($notif['sumber'] == 'suratmasuk') {
        // Jika sumber adalah suratmasuk, tampilkan sumber dan pengirim
        echo ucfirst($notif['sumber']) ;
    } else {
        // Untuk sumber lainnya, tampilkan sumber dan jenissurat
        echo ucfirst($notif['status_surat']);
    }
    ?>
                                        </span>

                                        <?php
    // Menampilkan informasi sesuai dengan sumber
    if ($notif['sumber'] == 'suratmasuk') {
        // Jika sumber adalah suratmasuk, tampilkan pengirim
        echo ucfirst($notif['pengirim']);
    } else {
        // Untuk sumber lainnya, tampilkan jenissurat
        echo ucfirst($notif['jenissurat']);
    }
?>
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

                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0 " style="list-style: none;">
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