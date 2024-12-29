<?php
session_start();
include '../config/config.php';

// Atur header untuk format JSON
header('Content-Type: application/json');

// Periksa apakah `idberkassurat` atau `idsuratmasuk` disediakan dalam permintaan
if (isset($_GET['idberkassurat']) || isset($_GET['nosuratmasuk'])) {
    $success = true; // Penanda keberhasilan pembaruan
    $errors = []; // Array untuk menyimpan pesan kesalahan

    // Jika idberkassurat ada, lakukan pembaruan di tabel berkaspengajuansuratkeluar
    if (isset($_GET['idberkassurat'])) {
        $idberkassurat = mysqli_real_escape_string($koneksi, $_GET['idberkassurat']);
        $queryBerkas = "UPDATE berkaspengajuansuratkeluar SET is_viewed = 1 WHERE idberkassurat = '$idberkassurat'";
        $resultBerkas = mysqli_query($koneksi, $queryBerkas);

        if (!$resultBerkas) {
            $success = false;
            $errors[] = 'Gagal memperbarui berkaspengajuansuratkeluar: ' . mysqli_error($koneksi);
        }
    }

    // Jika idsuratmasuk ada, lakukan pembaruan di tabel suratmasuk
    if (isset($_GET['nosuratmasuk'])) {
        $nosuratmasuk = mysqli_real_escape_string($koneksi, $_GET['nosuratmasuk']);
        $querySuratMasuk = "UPDATE suratmasuk SET is_viewed = 1 WHERE nosuratmasuk = '$nosuratmasuk'";
        $resultSuratMasuk = mysqli_query($koneksi, $querySuratMasuk);

        if (!$resultSuratMasuk) {
            $success = false;
            $errors[] = 'Gagal memperbarui suratmasuk: ' . mysqli_error($koneksi);
        }
    }

    // Kirim respons JSON berdasarkan hasil pembaruan
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
} else {
    // Jika tidak ada id yang disediakan
    echo json_encode(['success' => false, 'error' => 'idberkassurat atau idsuratmasuk tidak ditemukan']);
}