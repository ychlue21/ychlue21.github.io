<?php
include('header.php');
?>
<?php
$suratmasuk=mysqli_query($koneksi,"SELECT * from disposisi WHERE idDisposisi='".$_GET['idDisposisi']."'");
$p=mysqli_fetch_object($suratmasuk);
?>

<main class="content">
    <h2 class="title text-center">EDIT DISPOSISI</h2>
    <div class="box" style="width: 100%; max-width: 800px; margin: auto;">
        <form action="" method="POST">

            <div class="mb-3">
                <label for="idpegawai" class="form-label">Pegawai</label>
                <select id="idpegawai" class="form-select" name="idpegawai" required>
                    <?php 
        // Ambil ID disposisi yang sedang diedit
        $id_disposisi = $_GET['idDisposisi']; // ID disposisi didapat dari parameter URL

        // Query untuk mendapatkan idpegawai yang sudah tersimpan di disposisi
        $sql_disposisi = "SELECT idpegawai FROM disposisi WHERE iddisposisi = $id_disposisi";
        $result_disposisi = $koneksi->query($sql_disposisi);
        $data_disposisi = $result_disposisi->fetch_assoc();
        $id_pegawai_selected = $data_disposisi['idpegawai'] ?? null; // Pegawai terpilih

        // Query untuk mendapatkan semua pegawai dengan role kepala_seksi
        $sql_pegawai = "SELECT pegawai.idpegawai, pegawai.namalengkap
                        FROM pegawai
                        JOIN user ON pegawai.iduser = user.id_user
                        WHERE user.role = 'kepala_seksi'";
        $result_pegawai = $koneksi->query($sql_pegawai);

        // Tampilkan dropdown menu
        while ($row = $result_pegawai->fetch_assoc()) {
            $selected = ($row['idpegawai'] == $id_pegawai_selected) ? "selected" : "";
            echo "<option value='" . $row['idpegawai'] . "' $selected>" . htmlspecialchars($row['namalengkap']) . "</option>";
        }
        ?>
                </select>
            </div>


            <div class="mb-3">
                <label for="isiDisposisi" class="form-label">Isi Disposisi</label>
                <textarea cols="60" rows="4" type="text" pattern="[A-Za-z ._%+- ]+" title="HURUF SAJA"
                    name="isiDisposisi" class="form-control" required><?=$p->isiDisposisi?></textarea>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Kembali</button>
                <button type="submit" name="submit" class="btn btn-outline-warning">Simpan perubahan</button>
            </div>
        </form>
        <?php     
            if(isset($_POST['submit'])){  
          
              $idpegawai=$_POST['idpegawai'];
               $isiDisposisi=$_POST['isiDisposisi'];
                
                $update=mysqli_query($koneksi,"UPDATE disposisi SET 
                idPegawai='".$idpegawai."',
                 isiDisposisi='".$isiDisposisi."'      
                 WHERE idDisposisi ='".$_GET['idDisposisi']."'
                 ");
              
              
              if($update){
               	echo "<script>window.location='disposisi.php'</script>";
              } else{
                echo'gagal diubah' ,mysqli_error($koneksi);
              }
            }
            ?>
    </div>
    </div>
</main>
<?php
include('footer.php');
?>