<?php
include('header.php');
$iduser= $_SESSION['user_id'];

// Query untuk mendapatkan tahun_jabatan
$query = "SELECT tahun_jabatan FROM ketua_rw WHERE iduser = $iduser";
$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Fetch hasil sebagai array asosiatif
    $tahun_jabatan = $row['tahun_jabatan'] ?? ''; // Ambil nilai tahun_jabatan
} else {
    $tahun_jabatan = ''; // Jika tidak ada hasil, beri nilai kosong
}
?>
<main class="content">
    <h2 class="title text-center ">Tambah Data RT</h2>
    <div class="box" style="width: 100%; max-width: 800px; margin: auto;">
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="TAHUN_JABATAN" class="form-label" style="width: 20%;">Tahun Jabatan</label>
                    <input type="text" name="TAHUN_JABATAN" id="TAHUN_JABATAN" class="form-control" required
                        style="flex-grow: 1; margin: 0;" value="<?= htmlspecialchars($tahun_jabatan); ?>">
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="IDKETUARW" class="form-label" style="width: 20%;">Pilih RW</label>
                    <select name="IDKETUARW" id="IDKETUARW" class="form-select" required
                        style="flex-grow: 1; margin: 0;">
                        <option value="">Pilih</option>
                        <?php
                               $iduser= $_SESSION['user_id'];

  $sql = "SELECT * FROM ketua_rw JOIN RW ON RW.IDRW=KETUA_RW.IDRW  WHERE ketua_rw.iduser='$iduser' ";
$result = mysqli_query($koneksi, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['IDKETUARW'] . "'>" . $row['NAMA_RW'] . "</option>";
    }
} else {
    echo "<option value=''>Tidak ada RW yang ditemukan</option>";
}
                                ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="IDRT" class="form-label" style="width: 20%;">Pilih RT</label>
                    <select name="IDRT" id="IDRT" class="form-select" required style="flex-grow: 1; margin: 0;">
                        <!-- <option value="">Pilih</option> -->
                    </select>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="d-flex align-items-center">
                    <label for="NIK" class="form-label" style="width: 20%;">Nama Ketua RT</label>
                    <select name="NIK" id="NIK" class="form-control" required style="flex-grow: 1; margin: 0;">
                        <option value=""></option>

                    </select>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary"
                    onclick="window.location='RT.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-success">Simpan</button>
            </div>
        </form>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- mendapatkan data rw saat memilih tahun jabatan -->

        <!-- mendapatkan data rt berdasarkan ketuarw yang dipilih -->
        <script>
        $(document).ready(function() {
            $('#IDKETUARW').change(function() {
                var IDKETUARW = $(this).val();
                console.log('IDKETUARW: ', IDKETUARW); // Cek nilai ini
                $.post('fetch_rt.php', {
                    IDKETUARW: IDKETUARW
                }, function(data) {
                    console.log(data); // Cek respons dari server
                    $('#IDRT').html(data);
                });
            });
        });
        </script>
        <!-- mendapatkan data warga berdasarkan rt yang dipilih -->
        <script>
        $(document).ready(function() {
            $('#IDRT').change(function() {
                var IDRT = $(this).val();
                var NAMA_RT = $(this).find(':selected').data('nama');
                $.post('fetch_wargaRT.php', {
                    IDRT: IDRT,
                    NAMA_RT: NAMA_RT
                }, function(data) {
                    $('#NIK').html(data);
                });
            });
        });
        </script>


        <?php
         if(isset($_POST['submit'])){  

            // untuk buat username akun
            function generateUsername($nama_rt, $tahun_jabatan) {
            // Ambil hanya nomor RT dari nama RT, misalnya "RT 14" menjadi "14"
            $rt_number = preg_replace('/[^0-9]/', '', $nama_rt);
            // Ambil 4 digit pertama dari tahun jabatan
            $tahun_awal = substr($tahun_jabatan, 0, 4);
            // Gabungkan "rt" dengan nomor RT dan tahun awal
            $username = 'rt' . $rt_number . '_' . $tahun_awal;
            return $username;
        }

// function generateUsername($nama_rt, $tahun_jabatan) {
//     // Hapus spasi dan karakter khusus dari nama RT
//     $nama_rt_clean = preg_replace('/\s+/', '', $nama_rt);
//     // Ambil 4 digit pertama dari tahun jabatan
//     $tahun_awal = substr($tahun_jabatan, 0, 4);
//     // Gabungkan menjadi username
//     $username = strtolower($nama_rt_clean) . '_' . $tahun_awal;
//     return $username;
// }


// buat id ketua rt
 $query2=mysqli_query($koneksi, "SELECT MAX(IDKETUART) AS maxid_RT from KETUA_RT");
            $data = mysqli_fetch_array($query2);
            $generateid=$data['maxid_RT'];
            $urutan = (int) substr($generateid, 3, 3);
            $urutan++;
            $huruf = "rt";
	        $generateidauto1 = $huruf . sprintf("%02s", $urutan);


// data ketua_rt

             $IDRT=$_POST['IDRT'];
            $TAHUN_JABATAN=$_POST['TAHUN_JABATAN'];
             $NIK=$_POST['NIK'];
  

//data user id user
            $query=mysqli_query($koneksi, "SELECT MAX(id_user) AS maxid_user from user");
            $data=mysqli_fetch_array($query);
            $generateid=$data['maxid_user'];
            $generateid++;       
            $generateidauto=sprintf($generateid); 

$username = generateUsername($IDRT, $TAHUN_JABATAN);
             $password='12345678';
             $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
             $role='rt';
           

             $insert1=mysqli_query($koneksi,"INSERT INTO user VALUES
                (
                 '".$generateidauto."',
                   '".$username."',
                   '".$hashedPassword."',
                   '".$role."'
                  
                                )");

                $insert2=mysqli_query($koneksi,"INSERT INTO KETUA_RT(IDKETUART, iduser,NIK,IDRT,TAHUN_JABATAN) VALUES
                (
                 '".$generateidauto1."',
                   '".$generateidauto."',
                    '".$NIK."',
                    '".$IDRT."',
                   '".$TAHUN_JABATAN."'
                   
                                )");
                                
                        
                     if($insert1&&$insert2){
                echo '<script>window.location="RT.php"</script>';
            }else{
                echo'data RT telah Ada Sebelumnya'.mysqli_error($koneksi);
            }
        }
            
?>
    </div>
    </div>
</main>
<?php
include('footer.php');
?>