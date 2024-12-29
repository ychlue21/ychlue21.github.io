<?php
include '../config/config.php';

if (isset($_GET['idberkassurat']) && isset($_GET['status_surat'])) {
    $statussurat = $_GET['status_surat'];
    $idberkassurat = $_GET['idberkassurat'];
 $tanggalselesai = date("Y-m-d H:i:s");
    // Tentukan nilai status_surat berdasarkan status_rt
    $statusSuratkeluar = ($statussurat == 'ditolak') ? 'ditolak' : 'diproses';

    // Jika status_rt disetujui, set keterangan menjadi '-'
    $keterangan = ($statussurat == 'diterima') ? '' : '';

    // Update status_rt, status_surat, dan keterangan di database
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET  status_surat = '$statussurat', keterangan = '$keterangan',tanggalselesai='$tanggalselesai',is_viewed=0
        WHERE idberkassurat = '$idberkassurat'
    ");

    // Periksa apakah update berhasil
    if ($update) {
        // Arahkan pengguna ke halaman yang sesuai
        if ($statussurat == 'diterima') {
            echo "<script>window.location='suratkeluar.php'</script>";
        } else {
            echo "<script>window.location='keterangan.php?idberkassurat=" . $idberkassurat . "';</script>";
        }
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
}
?>