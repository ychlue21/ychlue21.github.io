<?php
// Koneksi ke database
include '../config/config.php';

if(!empty($_GET['filesurat'])){
    $filename=basename(($_GET['filesurat']));
    $filepath="../stafsurat/berkas/".$filename;



    // Cek apakah file ada
if (!empty ($filename) && file_exists($filepath)) {
    // Set header untuk memaksa browser mengunduh
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    // header('Content-Length: ' . filesize($file));
    readfile($filepath);
    exit;
} else {
    echo "File tidak ditemukan";
}

}


?>