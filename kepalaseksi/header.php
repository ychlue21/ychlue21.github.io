<?php
session_start();
include '../config/config.php';
if(!isset($_SESSION['status_login'])){
    echo "<script>window.location='../index.php'</script>";
}

$iduser = $_SESSION['user_id'];
// Ambil jumlah notifikasi disposisi baru yang belum dilihat
$query_notifikasi = "SELECT COUNT(*) AS jumlah FROM disposisi 
                     JOIN suratmasuk ON suratmasuk.nosuratmasuk = disposisi.nosurat
                     JOIN pegawai ON pegawai.idPegawai = disposisi.idpegawai
                     WHERE pegawai.iduser = '$iduser' AND disposisi.status = 'belum selesai'";
$result_notifikasi = mysqli_query($koneksi, $query_notifikasi);
$jumlah_notifikasi = mysqli_fetch_assoc($result_notifikasi)['jumlah'];
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

                    </ul>
                    <ul class="navbar-nav ml-auto mb-2 mb-lg-0" style="list-style: none;">
                        <li class="nav-item">
                            <a class="nav-link" href="notifikasi.php">
                                <i class="fas fa-bell"></i>
                                <?php if ($jumlah_notifikasi > 0): ?>
                                <span class="badge bg-danger"><?= $jumlah_notifikasi ?></span>
                                <?php endif; ?>
                            </a>
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