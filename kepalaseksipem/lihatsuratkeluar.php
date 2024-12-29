<?php
// Koneksi ke database
include '../config/config.php';

if(!empty($_GET['filesurat'])){
     $filename=basename(($_GET['filesurat']));
    $filepath="../stafsurat/pdf_files/".$filename;


    // Cek apakah file ada
if (!empty ($filename) && file_exists($filepath)) {
    // Set header untuk memaksa browser mengunduh
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . basename($filename) . '"');
    readfile($filepath);
    exit;
} else {
    echo "File tidak ditemukan";
}

}


?>