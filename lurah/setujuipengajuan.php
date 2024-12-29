<?php
include '../config/config.php';

if(isset($_GET['idberkassurat'])){
    $statussurat ='Diterima';
    $idberkassurat = $_GET['idberkassurat'];
$tanggalselesai = date("Y-m-d H:i:s");
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET status_surat = '$statussurat',tanggalselesai='$tanggalselesai',is_viewed = 0
        WHERE idberkassurat = '$idberkassurat'
    ");

    // Periksa apakah update berhasil
    if ($update) {
        // Arahkan pengguna ke halaman yang sesuai
            echo "<script>window.location='suratkeluar.php'</script>";
        
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
}
?>