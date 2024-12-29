<?php
include '../config/config.php';

if(isset($_GET['idberkassurat'])){
    $statusRt ='Disetujui';
    $idberkassurat = $_GET['idberkassurat'];
$konfirmasi_Rt = date("Y-m-d H:i:s");
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET status_rt = '$statusRt',konfirmasi_rt='$konfirmasi_Rt',is_viewed = 0
        WHERE idberkassurat = '$idberkassurat'
    ");

    // Periksa apakah update berhasil
    if ($update) {
        // Arahkan pengguna ke halaman yang sesuai
            echo "<script>window.location='pengajuanwarga.php'</script>";
        
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
}
?>