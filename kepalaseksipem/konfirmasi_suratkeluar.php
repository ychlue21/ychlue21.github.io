<!-- <?php
include '../config/config.php';

if (isset($_GET['idberkassurat']) && isset($_GET['Status_kasi'])) {
    $status_kasi = $_GET['Status_kasi'];
    $idberkassurat = $_GET['idberkassurat'];
    $konfirmasi_kasi = date("Y-m-d H:i:s");
     // Debug: cek nilai parameter yang diterima
    echo "Status_kasi: $status_kasi, idberkassurat: $idberkassurat<br>";
    
    // Tentukan nilai status_surat berdasarkan status_rt
    $statusSurat = ($status_kasi == 'Ditolak') ? 'ditolak' : 'diproses';

    // Jika status_rt disetujui, set keterangan menjadi '-'
    $keterangan = ($status_kasi == 'Disetujui') ? '' : 'Pengajuan ditolak oleh Kasi';

    // Update status_rt, status_surat, dan keterangan di database
    $update = mysqli_query($koneksi, "
        UPDATE berkaspengajuansuratkeluar 
        SET Status_kasi = '$status_kasi', status_surat = '$statusSurat', keterangan = '$keterangan',konfirmasi_kasi='$konfirmasi_kasi'
        WHERE idberkassurat = '$idberkassurat'
    ");

    // Periksa apakah update berhasil
    if ($update) {
        // Arahkan pengguna ke halaman yang sesuai
        if ($status_kasi == 'disetujui') {
            echo "<script>window.location='pengajuanwarga.php'</script>";
        } else {
            echo "<script>window.location='keterangan.php?idberkassurat=" . $idberkassurat . "';</script>";
        }
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
}

else {
    echo 'Error: Parameter idberkassurat atau Status_kasi tidak ditemukan.';
}
?> -->
<!-- <?php
include '../config/config.php';  // Pastikan Anda telah menyertakan koneksi database yang valid

if (isset($_GET['idberkassurat']) && isset($_GET['Status_kasi'])) {
    $idberkassurat = $_GET['idberkassurat'];
    $status_kasi = $_GET['Status_kasi'];
    $konfirmasi_kasi = date("Y-m-d H:i:s");

    // Debug: Menampilkan nilai yang diterima;

    // Tentukan status_surat berdasarkan status_kasi
    if ($status_kasi == 'ditolak') {
        $statusSurat = 'ditolak';
        $keterangan = 'Pengajuan ditolak oleh Kasi';
    } elseif ($status_kasi == 'disetujui') {
        $statusSurat = 'diproses';
        $keterangan = '';  // Keterangan kosong jika disetujui
    } else {
        $statusSurat = 'diproses';  // Default status jika tidak ditolak atau disetujui
        $keterangan = '';  // Keterangan kosong untuk status selain ditolak
    }

    // Update status di database
    $updateQuery = "
        UPDATE berkaspengajuansuratkeluar 
        SET Status_kasi = '$status_kasi', status_surat = '$statusSurat', keterangan = '$keterangan', konfirmasi_kasi = '$konfirmasi_kasi'
        WHERE idberkassurat = '$idberkassurat'
    ";

    $update = mysqli_query($koneksi, $updateQuery);

    if ($update) {
        // Jika status disetujui, arahkan ke pengajuansurat.php
        if ($status_kasi == 'disetujui') {
            echo "<script>window.location='pengajuanwarga.php';</script>";
        }
        // Jika status ditolak, arahkan ke keterangan.php
        elseif ($status_kasi == 'ditolak') {
            echo "<script>window.location='keterangan.php?idberkassurat=$idberkassurat';</script>";
        }
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
} else {
    echo 'Error: idberkassurat atau Status_kasi tidak ditemukan.';
}
?> -->
<?php
include '../config/config.php';  // Pastikan Anda telah menyertakan koneksi database yang valid

if (isset($_GET['idberkassurat']) && isset($_GET['Status_kasi']) && isset($_GET['redirect'])) {
    $idberkassurat = $_GET['idberkassurat'];
    $status_kasi = $_GET['Status_kasi'];
    $redirectPage = $_GET['redirect'];  // Menangkap halaman tujuan (pengajuanwarga.php atau keterangan.php)
    $konfirmasi_kasi = date("Y-m-d H:i:s");

    // Tentukan status_surat berdasarkan status_kasi
    if ($status_kasi == 'Ditolak') {
        $statusSurat = 'Ditolak';
        $keterangan = 'Pengajuan ditolak oleh Kasi';
    } elseif ($status_kasi == 'Disetujui') {
        $statusSurat = 'Diproses';
        $keterangan = '';  // Keterangan kosong jika disetujui
    }

    // Update status di database
    $updateQuery = "
        UPDATE berkaspengajuansuratkeluar 
        SET Status_kasi = '$status_kasi', status_surat = '$statusSurat', keterangan = '$keterangan', konfirmasi_kasi = '$konfirmasi_kasi',is_viewed=0
        WHERE idberkassurat = '$idberkassurat'
    ";

    $update = mysqli_query($koneksi, $updateQuery);

    if ($update) {
        // Mengarahkan ke halaman yang sesuai berdasarkan parameter redirect
        echo "<script>window.location='$redirectPage';</script>";
    } else {
        echo 'Gagal diubah: ' . mysqli_error($koneksi);
    }
} else {
    echo 'Error: idberkassurat, Status_kasi, atau redirect tidak ditemukan.';
}
?>