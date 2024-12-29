<?php
include'../config/config.php';

if(isset($_GET['NIK'])){
//     $iduser=$_GET['id_user'];
//     $warga=mysqli_query($koneksi,"SELECT * from warga join user on user.id_user=warga.iduser WHERE iduser='".$_GET['id_user']."'");
// $p=mysqli_fetch_object($warga);
 //   $hapus=mysqli_query($koneksi,"DELETE FROM user WHERE id_user='".$_GET['id_user']."'");
    // echo"<script>window.location='warga.php'</script>";

    $delete=mysqli_query($koneksi,"DELETE warga,user 
    FROM warga 
    inner join user on user.id_user=warga.iduser
    WHERE warga.NIK='".$_GET['NIK']."'");
    
    


   
     if($delete){
              echo "<script>alert('Data berhasil dihapus'); window.location='warga.php'</script>";
            }else{
                // echo'DATA RW TIDAK DAPAT DIHAPUS'.mysqli_error($koneksi);
                echo "<script>alert('DATA warga TIDAK DAPAT DIHAPUS: " . mysqli_error($koneksi) . "'); window.location='warga.php'</script>";
            }


}