<?php
include('header.php');
$iduser= $_SESSION['user_id'];
$rt=mysqli_query($koneksi,"SELECT * from KETUA_RT join RT on rt.idrt=ketua_rt.idrt join rw on rw.idrw=rt.idrw join warga on warga.nik=ketua_rt.nik join user on user.id_user=ketua_rt.iduser JOIN ketua_rw ON ketua_rw.IDRW=RW.IDRW  WHERE IDKETUART='".$_GET['IDKETUART']."'");
 $p=mysqli_fetch_object($rt);
?>

<main class="content">
    <h2 class="title text-center ">Edit Data RT</h2>
    <div class="box" style="width: 100%; max-width: 800px; margin: auto;">
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="TAHUN_JABATAN" class="form-label" style="width: 20%;">Tahun Jabatan</label>
                    <input type="text" name="TAHUN_JABATAN" id="TAHUN_JABATAN" class="form-control"
                        value="<?php echo $p->TAHUN_JABATAN; ?>">
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="IDKETUARW" class="form-label" style="width: 20%;">Pilih RW</label>
                    <select name="IDKETUARW" id="IDKETUARW" class="form-control" style="flex-grow: 1; margin: 0;">
                        <?php
                    // Mengambil data RW berdasarkan TAHUN_JABATAN
                    $TAHUN_JABATAN = $p->TAHUN_JABATAN; // Menggunakan tahun jabatan dari data yang diambil
                    $sql = "SELECT * FROM ketua_rw JOIN RW ON RW.IDRW=KETUA_RW.IDRW WHERE ketua_rw.iduser='$iduser' and TAHUN_JABATAN='$TAHUN_JABATAN' ";
                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            // Tandai opsi yang terpilih
                            $selected = ($row['IDKETUARW'] === $p->IDKETUARW) ? 'selected' : '';
                             echo "<option value='" . $row['IDKETUARW'] . "' $selected>" . $row['NAMA_RW'] . "</option>";  
                        }
                    } else {
                        echo "<option value=''>No data found</option>";
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="NAMA_RT" class="form-label" style="width: 20%;">Nama RT</label>
                    <select name="NAMA_RT" id="NAMA_RT" class="form-control" style="flex-grow: 1; margin: 0;">
                        <?php
                    // Mengambil data RT berdasarkan KETUARW
                    $IDKETUARW = $p->IDKETUARW;

// Query untuk mengambil data RT berdasarkan IDKETUARW
$sql = "
    SELECT RT.IDRT, RT.NAMA_RT 
    FROM RT 
    JOIN RW ON RW.IDRW = RT.IDRW 
    JOIN KETUA_RW ON KETUA_RW.IDRW = RW.IDRW 
    WHERE KETUA_RW.IDKETUARW = '$IDKETUARW'
";
                    $result = mysqli_query($koneksi, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            // Tandai opsi yang terpilih
                            $selected = ($row['IDRT'] === $p->IDRT) ? 'selected' : '';
                             echo "<option value='" . $row['IDRT'] . "' $selected>" . $row['NAMA_RT'] . "</option>";  
                        }
                    } else {
                        echo "<option value=''>No data found</option>";
                    }
                    ?>
                    </select>
                </div>
            </div>

            <?php
// Ambil IDKETUART dari URL
$idketuart = mysqli_real_escape_string($koneksi, $_GET['IDKETUART']);

// Query untuk mendapatkan data Ketua RT saat ini
$queryKetuaRT = "
    SELECT KETUA_RT.NIK AS NIK_KETUA, RT.NAMA_RT, RT.IDRT 
    FROM KETUA_RT 
    JOIN RT ON RT.IDRT = KETUA_RT.IDRT 
    WHERE KETUA_RT.IDKETUART = '$idketuart'
";
$resultKetuaRT = mysqli_query($koneksi, $queryKetuaRT);
$ketuaRT = mysqli_fetch_assoc($resultKetuaRT);

$nikKetua = $ketuaRT['NIK_KETUA'];
$namaRT = $ketuaRT['NAMA_RT'];

// Query untuk mendapatkan data warga sesuai RT
$queryWarga = "
    SELECT WARGA.NIK, WARGA.NAMALENGKAP 
    FROM WARGA 
    WHERE WARGA.ALAMAT LIKE '%" . mysqli_real_escape_string($koneksi, $namaRT) . "%'
";
$resultWarga = mysqli_query($koneksi, $queryWarga);
?>

            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="NIK" class="form-label" style="width: 20%;">Nama Ketua RT</label>
                    <select name="NIK" id="NIK" class="form-control" style="flex-grow: 1; margin: 0;">
                        <?php
            if (mysqli_num_rows($resultWarga) > 0) {
                while ($warga = mysqli_fetch_assoc($resultWarga)) {
                    // Tandai opsi yang sesuai dengan Ketua RT saat ini sebagai selected
                    $selected = ($warga['NIK'] === $nikKetua) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($warga['NIK']) . "' $selected>" . htmlspecialchars($warga['NAMALENGKAP']) . "</option>";
                }
            } else {
                echo "<option value=''>No data found</option>";
            }
            ?>
                    </select>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary"
                    onclick="window.location='RT.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-warning">Ubah</button>
            </div>
        </form>

        <?php
         if(isset($_POST['submit'])){   

            // $IDRT=$_POST['IDRT'];
            $TAHUN_JABATAN=$_POST['TAHUN_JABATAN'];
             $NIK=$_POST['NIK'];
             $NAMA_RT=$_POST['NAMA_RT'];
            // $IDRW=$_POST['IDRW'];
 
  $update1 = mysqli_query($koneksi, "UPDATE ketua_rt SET 
                            IDRT='$NAMA_RT',
                            NIK='$NIK',
                            TAHUN_JABATAN= '$TAHUN_JABATAN'
                    WHERE IDKETUART ='$p->IDKETUART'");                         
                     if($update1){
                echo '<script>window.location="RT.php"</script>';
            }else{
                echo'data RT telah Ada Sebelumnya'.mysqli_error($koneksi);
            }
        }
            
?>
    </div>
</main>
<?php
include('footer.php');
?>