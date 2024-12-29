<?php
// Koneksi ke database
include '../config/config.php';
$iduser= $_SESSION['user_id'];

// $TAHUN_JABATAN = $_POST['TAHUN_JABATAN'];

  $sql = "SELECT * FROM ketua_rw JOIN RW ON RW.IDRW=KETUA_RW.IDRW JOIN USER ON USER.ID_USER =KETUA_RW.IDUSER WHERE  id_user='$iduser' ";
$result = mysqli_query($koneksi, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['IDKETUARW'] . "'>" . $row['NAMA_RW'] . "</option>";
    }
} else {
    echo "<option value=''>Tidak ada RW yang ditemukan</option>";
}