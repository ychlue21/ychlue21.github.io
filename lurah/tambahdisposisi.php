<?php
include('header.php');
$suratmasuk=mysqli_query($koneksi,"SELECT * from disposisi join suratmasuk on suratmasuk.nosuratmasuk=disposisi.nosurat WHERE nosurat='".$_GET['nosuratmasuk']."'");
$p=mysqli_fetch_object($suratmasuk);
?>

<main class="content">
    <h2 class="title text-center">ISI DISPOSISI</h2>
    <div class="box" style="width: 100%; max-width: 800px; margin: auto;">
        <form action="" method="POST">

            <div class="mb-3">
                <label for="idpegawai" class="form-label">Pegawai</label>
                <select id="idpegawai" class="form-select" name="idpegawai" required>
                    <option value="">--- Pilih ---</option>
                    <?php 
                        $sql = mysqli_query($koneksi, "SELECT * FROM pegawai join user on pegawai.iduser=user.id_user WHERE role = 'kepala_seksi'");
                        while ($result = mysqli_fetch_array($sql)) {
                        ?>
                    <option value="<?php echo $result['idPegawai'] ?>"><?php echo $result['namalengkap'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="isiDisposisi" class="form-label">Isi Disposisi</label>
                <textarea id="isiDisposisi" cols="60" rows="4" name="isiDisposisi" class="form-control" required
                    placeholder="Wajib diisi"></textarea>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary"
                    onclick="window.location='suratmasuk.php'">Kembali</button>
                <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
        <?php
            
            if(isset($_POST['submit'])){
            $query=mysqli_query($koneksi, "SELECT MAX(idDisposisi) AS maxid_disposisi from disposisi");
            $data=mysqli_fetch_array($query);
            $generateid=$data['maxid_disposisi'];
            $generateid++;       
            $generateidauto=sprintf($generateid);
            $status='Belum Selesai';
            $suratmasuk=$_GET['nosuratmasuk'];

            $simpan=mysqli_query($koneksi,"INSERT INTO disposisi (idDisposisi, nosurat, isiDisposisi, status, idpegawai) values (
              '".$generateidauto."', 
                '".$suratmasuk."', 
           
                '".$_POST['isiDisposisi']."',
              '".$status."', 
               '".$_POST['idpegawai']."'
              )");
              
            //   if($simpan){
            //    	echo "<script>window.location='disposisi.php'</script>";
            //   } else{
            //     echo'gagal disimpan' ,mysqli_error($koneksi);
            //   }
            // Jika penyimpanan disposisi berhasil, update suratmasuk
    if ($simpan) {
        $update = mysqli_query($koneksi, "UPDATE suratmasuk SET is_viewed = 0 WHERE nosuratmasuk = '" . $suratmasuk . "'");
        if ($update) {
            echo "<script>window.location='disposisi.php'</script>";
        } else {
            echo "Gagal mengupdate is_viewed: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal disimpan: " . mysqli_error($koneksi);
    }
            }
            ?>
    </div>
</main>
<?php
include('footer.php');
?>