<?php
include('header.php')
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
require('../config/config.php');
$iduser= $_SESSION['user_id'];
//query untuk card data
$twarga=mysqli_query(mysql: $koneksi,query: "SELECT * FROM warga join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') join ketua_rw on ketua_rw.idrw=rw.idrw join user on user.id_user=ketua_rw.iduser where id_user ='$iduser'");
$COUNT1=mysqli_num_rows(result: $twarga); //menghitung surat masuk
$tkk=mysqli_query(mysql: $koneksi,query: "SELECT namalengkap FROM warga join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') join ketua_rw on ketua_rw.idrw=rw.idrw join user on user.id_user=ketua_rw.iduser where id_user ='$iduser' GROUP BY NOKK");
$COUNT2=mysqli_num_rows(result: $tkk); //menghitung surat tolak
$tsurat_terkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM berkaspengajuansuratkeluar join warga on warga.nik=berkaspengajuansuratkeluar.nik  join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') join ketua_rw on ketua_rw.idrw=rw.idrw join rt on rt.idrw=rw.idrw join ketua_Rt on ketua_rt.idrt=rt.idrt  join user on user.id_user=ketua_rw.iduser WHERE id_user ='$iduser' and status_rt IN ('disetujui', 'ditolak')");
$COUNT3=mysqli_num_rows(result: $tsurat_terkonfirmasi); //menghitung berkas pengajuan
$tsurat_belumkonfirmasi=mysqli_query(mysql: $koneksi,query: "SELECT * FROM berkaspengajuansuratkeluar join warga on warga.nik=berkaspengajuansuratkeluar.nik  join rw on warga.alamat LIKE CONCAT('%', rw.nama_rw, '%') join ketua_rw on ketua_rw.idrw=rw.idrw join rt on rt.idrw=rw.idrw join ketua_Rt on ketua_rt.idrt=rt.idrt  join user on user.id_user=ketua_rw.iduser WHERE id_user ='$iduser' and status_rt  NOT IN ('disetujui', 'ditolak') ;");
$COUNT4=mysqli_num_rows(result: $tsurat_belumkonfirmasi); //menghitung berkas diproses


// query untuk menampilkan nama
$query5 = "SELECT * FROM warga join ketua_rw on ketua_rw.nik=warga.nik JOIN user ON user.id_user=ketua_Rw.iduser WHERE user.id_user = '$iduser'";
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