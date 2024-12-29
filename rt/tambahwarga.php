<?php
include('header.php');
?>

<main class="content">
    <h2 class="title text-center">Tambah Warga</h2>
    <div class="container" style="max-width: 800px; margin: auto;">

        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="NIK" class="form-label">NIK</label>
                <input type="text" name="NIK" id="NIK" class="form-control" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="NOKK" class="form-label">NO KK</label>
                <input type="text" name="NOKK" id="NOKK" class="form-control" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="namalengkap" class="form-label">Nama Lengkap</label>
                <input type="text" name="namalengkap" id="namalengkap" class="form-control" required>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="JK" class="form-label">Jenis Kelamin</label>
                <select name="JK" id="JK" class="form-select" required>
                    <option value="">Pilih</option>
                    <option value="Perempuan">Perempuan</option>
                    <option value="Laki-laki">Laki-laki</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control">
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="tgl_Lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_Lahir" id="tgl_Lahir" class="form-control" required>
            </div>
            <!-- <div class="col-12 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea cols="30" rows="4" placeholder="JALAN XXX RT XX RW XXX" class="form-control" name="alamat"
                    id="alamat"></textarea>
            </div> -->
            <div class="col-12 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea cols="30" rows="2" class="form-control" name="alamat" id="alamat" required></textarea>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="RW" class="form-label">RW</label>
                <select name="RW" id="RW" class="form-select" required>
                    <option value="">Pilih RW</option>
                    <?php
        // Ambil data RW dari database
        $queryRW = mysqli_query($koneksi, "SELECT * FROM rw"); // Ganti dengan nama tabel yang sesuai
        while ($rowRW = mysqli_fetch_assoc($queryRW)) {
            echo "<option value='{$rowRW['IDRW']}'>{$rowRW['NAMA_RW']}</option>"; // Ganti 'id_rw' dan 'rw_name' dengan nama kolom yang sesuai
        }
        ?>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="RT" class="form-label">RT</label>
                <select name="RT" id="RT" class="form-select" required>
                    <option value="">Pilih RT</option>
                    <?php
        // Ambil data RT dari database
        $queryRT = mysqli_query($koneksi, "SELECT * FROM rt"); // Ganti dengan nama tabel yang sesuai
        while ($rowRT = mysqli_fetch_assoc($queryRT)) {
            echo "<option value='{$rowRT['IDRT']}'>{$rowRT['NAMA_RT']}</option>"; // Ganti 'id_rt' dan 'rt_name' dengan nama kolom yang sesuai
        }
        ?>
                </select>
            </div>

            <div class="col-md-6 col-sm-12 mb-3">
                <label for="agama" class="form-label">Agama</label>
                <select class="form-select" name="agama" id="agama" required>
                    <option value="">Pilih</option>
                    <option value="Kristen Protestan">Kristen Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Islam">Islam</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control">
            </div>
            <div class="col-12 d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary"
                    onclick="window.location='warga.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-success">Simpan</button>
            </div>
        </form>

        <?php
         if(isset($_POST['submit'])){   
            $NIK=$_POST['NIK'];
            $NOKK=$_POST['NOKK'];
            $namalengkap=$_POST['namalengkap'];
            $JK=$_POST['JK'];
            $tempat_lahir=$_POST['tempat_lahir'];
            $tgl_Lahir=$_POST['tgl_Lahir'];
            $agama=$_POST['agama'];
            $alamat=ucwords($_POST['alamat']);  
            $pekerjaan=$_POST['pekerjaan'];
            $RT = $_POST['RT']; // Ambil nilai RT
             $RW = $_POST['RW']; // Ambil nilai RW

    // Ambil nama RT
            $queryRTName = mysqli_query($koneksi, "SELECT NAMA_RT FROM rt WHERE IDRT = '$RT'");
            $rowRTName = mysqli_fetch_assoc($queryRTName);
            $namaRT = $rowRTName['NAMA_RT'];

            // Ambil nama RW
            $queryRWName = mysqli_query($koneksi, "SELECT NAMA_RW FROM rw WHERE IDRW = '$RW'");
            $rowRWName = mysqli_fetch_assoc($queryRWName);
            $namaRW = $rowRWName['NAMA_RW'];

            // Gabungkan alamat, nama RT, dan nama RW
            $alamatLengkap = $alamat . ' ' . $namaRT . '' . $namaRW;

            $query=mysqli_query($koneksi, "SELECT MAX(id_user) AS maxid_user from user");
            $data=mysqli_fetch_array($query);
            $generateid=$data['maxid_user'] + 1;
            $username=$NIK;
            $password='12345678';
            // Hashing password menggunakan password_hash()
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role='warga';

            $insert1=mysqli_query($koneksi, "INSERT INTO user (id_user, username, password, role) VALUES ('$generateid', '$username', '$hashedPassword', '$role')");
            $insert2=mysqli_query($koneksi,"INSERT INTO warga (iduser, NIK, NOKK, namalengkap, JK, Tempat_lahir, Tgl_Lahir, agama, alamat, pekerjaan) VALUES ('$generateid', '$NIK', '$NOKK', '$namalengkap', '$JK', '$tempat_lahir', '$tgl_Lahir', '$agama', '$alamatLengkap', '$pekerjaan')");
                                
            if ($insert1 && $insert2) {
                echo '<script>window.location="warga.php";</script>';
            } else {
                error_log(mysqli_error($koneksi));
                echo '<script>alert("Terjadi kesalahan. Mohon coba lagi.");</script>';
            }
        }
        ?>
    </div>

</main>
<?php
include('footer.php');
?>