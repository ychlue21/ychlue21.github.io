<?php
include'../config/config.php';

if(isset($_GET['idDisposisi'])){
    $delete=mysqli_query($koneksi,"DELETE FROM disposisi WHERE idDisposisi='".$_GET['idDisposisi']."'");
    echo"<script>window.location='disposisi.php'</script>";
}