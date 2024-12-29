<?php
include'../config/config.php';

if(isset($_GET['nosuratmasuk'])){
    $update=mysqli_query($koneksi,query: "update disposisi SET 
    status ='Selesai'
     WHERE nosurat='".$_GET['nosuratmasuk']."'");
    // echo"<script>window.location='index.php'</script>";
     
              if($update){
               	echo "<script>window.location='suratmasuk.php'</script>";
              } else{
                echo'gagal diubah' ,mysqli_error($koneksi);
              }
}