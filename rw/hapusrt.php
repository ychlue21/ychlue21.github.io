<?php
include'../config/config.php';

if(isset($_GET['IDKETUART'])){

     $delete=mysqli_query($koneksi,"DELETE KETUA_RT, user
        FROM KETUA_RT
        INNER JOIN user ON KETUA_rt.iduser = user.id_user
        WHERE KETUA_rt.idKETUArt ='".$_GET['IDKETUART']."'");
    //  echo"<script>window.location='rt.php'</script>";
  
    // if($delete){
    //            echo"<script>window.location='rt.php'</script>";
    //         }else{
    //             echo'DATA RW TIDAK DAPAT DIHAPUS'.mysqli_error($koneksi);
    //         }
     if($delete){
              echo "<script>alert('Data berhasil dihapus'); window.location='rt.php'</script>";
            }else{
                // echo'DATA RW TIDAK DAPAT DIHAPUS'.mysqli_error($koneksi);
                echo "<script>alert('DATA RT TIDAK DAPAT DIHAPUS: " . mysqli_error($koneksi) . "'); window.location='rt.php'</script>";
            }


}
?>