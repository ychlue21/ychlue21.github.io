<?php
// Koneksi ke database
include '../config/config.php';

$IDRT = $_POST['IDRT'];
$NAMA_RT = $_POST['NAMA_RT'];
 $sql = "SELECT warga.NIK, namalengkap FROM warga WHERE alamat LIKE '%" . mysqli_real_escape_string($koneksi, $NAMA_RT) . "%'";
$result = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['NIK'] . "'>" . $row['namalengkap'] . "</option>";
    }
} else {
    echo "<option value=''>Tidak ada warga ditemukan</option>";
}
?>