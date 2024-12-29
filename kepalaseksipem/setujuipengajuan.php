<?php
include '../config/config.php';

if(isset($_GET['idberkassurat'])){
    $statusKasi ='Disetujui';
    $idberkassurat = $_GET['idberkassurat'];
$konfirmasi_kasi = date("Y-m-d H:i:s");
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET Status_kasi = '$statusKasi',Konfirmasi_kasi='$konfirmasi_kasi',is_viewed = 0
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