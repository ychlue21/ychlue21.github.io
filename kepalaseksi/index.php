<?php
include('header.php');
require('../config/config.php');
$iduser= $_SESSION['user_id'];
//query untuk card data
$tsurat_masuk=mysqli_query(mysql: $koneksi,query: "SELECT * FROM disposisi join pegawai on pegawai.idPegawai = disposisi.idpegawai join user on user.id_user = pegawai.iduser where user.id_user = '$iduser'");
// $COUNT1=mysqli_num_rows(result: $tsurat_masuk); //menghitung surat masuk
$COUNT1=mysqli_num_rows($tsurat_masuk);
$tsurat_terkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM disposisi join pegawai on pegawai.idPegawai = disposisi.idpegawai join user on user.id_user = pegawai.iduser where user.id_user = '$iduser' and status ='Selesai'");
$COUNT2=mysqli_num_rows(result: $tsurat_terkonfirmasi); //menghitung surat tolak
$tsurat_belumkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * from disposisi join pegawai on pegawai.idPegawai = disposisi.idpegawai join user on user.id_user = pegawai.iduser where user.id_user = '$iduser' and status ='Belum Selesai'");
$COUNT3=mysqli_num_rows(result: $tsurat_belumkonfirmasi); //menghitung berkas pengajuan

// query untuk menampilkan nama
$query5 = "SELECT namalengkap FROM pegawai JOIN user ON user.id_user=pegawai.iduser WHERE user.id_user = '$iduser'";
$result5 = mysqli_query($koneksi, $query5);
$row5 = mysqli_fetch_assoc($result5);
?>
<main class="content">
    <!-- <h2 class="title">Selamat datang </h2> -->
    <?php
     if ($row5) {
    echo "  <h2 class='title' style='margin-bottom: 30px;'>Selamat datang " . strtolower($row5['namalengkap']) . "</h2>";
                }
     ?>
    <!-- AWAL CARD -->
    <div class="row">
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Surat Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT1;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-person fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Disposisi Terkonfirmasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT2;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-person fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Disposisi Belum Terkonfirmasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT3;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-person fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<?php
include('footer.php')
?>