<?php
// Koneksi ke database
include '../config/config.php';

if (!empty($_GET['filesurat'])) {
    // Ambil nama file dari parameter URL
    $filename = $_GET['filesurat'];
    
    // Tentukan jalur lengkap file
    $filepath = realpath("../stafsurat/suratmasuk/" . $filename);

    // Cek jika file yang dimaksud ada dan berada di dalam direktori yang benar
    if ($filepath && file_exists($filepath) && strpos($filepath, realpath("../stafsurat/berkas/")) === 0) {
        // Set header untuk memaksa browser mengunduh file
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($filename) . '"');
        readfile($filepath);
        exit;
    } else {
        echo "File tidak ditemukan atau path file tidak valid.";
    }
} else {
    echo "Parameter 'filesurat' tidak ditemukan.";
}
?>