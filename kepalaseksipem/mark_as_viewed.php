<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil parameter dari POST
    $idBerkasSurat = $_POST['idberkassurat'] ?? null;

    if ($idBerkasSurat) {
        // Update notifikasi surat keluar
        $queryUpdateKeluar = "
            UPDATE berkaspengajuansuratkeluar 
            SET is_viewed = 1 
            WHERE idberkassurat = ? AND is_viewed = 0
        ";
        $stmt = mysqli_prepare($koneksi, $queryUpdateKeluar);
        mysqli_stmt_bind_param($stmt, 'i', $idBerkasSurat);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Notifikasi surat keluar ditandai sebagai dilihat.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui notifikasi surat keluar atau sudah dilihat.']);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Update notifikasi surat masuk
        $queryUpdateMasuk = "
            UPDATE suratmasuk 
            SET is_viewed = 1 
            WHERE is_viewed = 0
        ";
        $result = mysqli_query($koneksi, $queryUpdateMasuk);

        if (mysqli_affected_rows($koneksi) > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Semua notifikasi surat masuk ditandai sebagai dilihat.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada notifikasi surat masuk yang perlu diperbarui.']);
        }
    }
} else {
    // Respon jika metode HTTP tidak valid
    echo json_encode(['status' => 'error', 'message' => 'Metode HTTP tidak valid.']);
}
?>