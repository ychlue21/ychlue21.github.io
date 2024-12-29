<?php
include('header.php')
?>
<?php
require('../config/config.php');
$iduser= $_SESSION['user_id'];
//query untuk card data
// $twarga=mysqli_query(mysql: $koneksi,query: "SELECT * FROM warga join KETUA_RT ON WARGA.NIK=KETUA_RT.NIK JOIN  rt on RT.IDRT=KETUA_rT.IDRT join user on user.id_user= KETUA_rt.iduser WHERE id_user ='$iduser' AND warga.alamat LIKE CONCAT('%', rt.idrt, '%') ");
$twarga=mysqli_query(mysql: $koneksi,query: "SELECT namalengkap FROM warga join rt on warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') join ketua_rt on ketua_rt.idrt=rt.idrt join user on user.id_user=ketua_rt.iduser where id_user ='$iduser'");
$COUNT1=mysqli_num_rows(result: $twarga); //menghitung surat masuk
$tkk=mysqli_query(mysql: $koneksi,query: "SELECT namalengkap FROM warga join rt on warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') join ketua_rt on ketua_rt.idrt=rt.idrt join user on user.id_user=ketua_rt.iduser where id_user ='$iduser' GROUP BY NOKK");
$COUNT2=mysqli_num_rows(result: $tkk); //menghitung surat tolak
$tsurat_terkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM berkaspengajuansuratkeluar join warga on warga.nik=berkaspengajuansuratkeluar.nik  join rt on warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') join ketua_rt on ketua_rt.idrt=rt.idrt join user on user.id_user=ketua_rt.iduser WHERE id_user ='$iduser' and status_rt IN ('disetujui', 'ditolak')");
$COUNT3=mysqli_num_rows(result: $tsurat_terkonfirmasi); //menghitung berkas pengajuan
$tsurat_belumkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM berkaspengajuansuratkeluar join warga on warga.nik=berkaspengajuansuratkeluar.nik  join rt on warga.alamat LIKE CONCAT('%', rt.nama_rt, '%') join ketua_rt on ketua_rt.idrt=rt.idrt join user on user.id_user=ketua_rt.iduser WHERE id_user ='$iduser' and status_rt='diproses' ");
$COUNT4=mysqli_num_rows(result: $tsurat_belumkonfirmasi); //menghitung berkas diproses
// query untuk menampilkan nama
$query5 = "SELECT * FROM warga join ketua_rt on ketua_rt.nik=warga.nik join rt on rt.idrt= ketua_Rt.idrt JOIN user ON user.id_user=ketua_Rt.iduser WHERE user.id_user = '$iduser'";
$result5 = mysqli_query($koneksi, $query5);
$row5 = mysqli_fetch_assoc($result5);

?>

<main class="content">
    <!-- <h2 class="title">Selamat datang </h2> -->
    <?php
     if ($row5) {
    echo "  <h2 class='title' style='margin-bottom: 30px;'>Selamat Datang Ketua " . $row5['NAMA_RT'] . " " . ucwords($row5['namalengkap']) . "</h2>";
                }
     ?>
    <!-- AWAL CARD -->
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-6 mt-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total Warga
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
        <div class="col-xl-6 col-md-6 mb-6 mt-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total KK
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT2;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-people-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-6 mt-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total SURAT TERKONFIRMASI
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT3;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-6 mt-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="card-title font-weight-bold text-primary text-uppercase mb-1">
                                Total SURAT BELUM TERKONFIRMASI
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $COUNT4;?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
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