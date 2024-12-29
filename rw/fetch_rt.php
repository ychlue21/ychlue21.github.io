 <?php
// Koneksi ke database
include '../config/config.php';

$IDKETUARW = $_POST['IDKETUARW'];

// Query untuk mengambil data RT berdasarkan IDKETUARW
$sql = "
    SELECT RT.IDRT, RT.NAMA_RT 
    FROM RT 
    JOIN RW ON RW.IDRW = RT.IDRW 
    JOIN KETUA_RW ON KETUA_RW.IDRW = RW.IDRW 
    WHERE KETUA_RW.IDKETUARW = '$IDKETUARW'
";

$result = mysqli_query($koneksi, $sql);

// Memeriksa hasil query
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
         echo "<option value='" . $row['IDRT'] . "' data-nama='" . $row['NAMA_RT'] . "'>" . $row['NAMA_RT'] . "</option>";
    }
} else {
    echo "<option value=''>Tidak ada RT yang ditemukan</option>";
}
?>